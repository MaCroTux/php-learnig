<?php

namespace Application\Kraken;

use Monolog\Logger;

class KrakenAmazonEs implements Kraken
{
    private const FINDER_URL = 'https://www.amazon.es/s/ref=nb_sb_noss?&page=1&field-keywords=';
    private const SOURCE     = 'amazones';

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function source(): string
    {
        return self::SOURCE;
    }

    public function execute($findProduct): array
    {
        $this->logger->info("Buscando: ". self::FINDER_URL.str_replace(' ', '+', $findProduct));

        $data = file_get_contents(self::FINDER_URL.str_replace(' ', '+', $findProduct));

        $dataOutEndLine = preg_replace("/[\r\n|\n|\r]+/", '', $data);

        $dom = new \DOMDocument;

        @$dom->loadHTML($dataOutEndLine);

        $finder    = new \DomXPath($dom);

        $classname = "s-result-item";
        $nodesName = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
        $products = [];

        /** @var \DOMNode $node */
        foreach ($nodesName as $index => $node) {

            $product = $node->childNodes->item(0)->childNodes;

            if ($product->count() === 0) {
                continue;
            }

            if ($product->count() > 1) {
                $product = $node->childNodes->item(1)->childNodes;
            }

            $infoSquared = $node->childNodes->item(0)
                ->childNodes->item(0)
                ->childNodes->item(0)
                ->childNodes->item(1);

            if (!$infoSquared->childNodes) {

                $infoSquared = $node->childNodes->item(0)
                    ->childNodes->item(0)
                    ->childNodes->item(0)
                    ->childNodes->item(0);
            }

            $infoSquared2 = $infoSquared->childNodes->item(2);

            $priceSquared2 = $infoSquared->childNodes->item(3);
            if (empty($priceSquared2 = $infoSquared->childNodes->item(3))) {
                $priceSquared2 = $infoSquared->childNodes->item(1);
            }

            if (!$infoSquared2->childNodes) {

                $infoSquared2 = $infoSquared->childNodes->item(0);
            }

            if ($infoSquared2->childNodes->item(0)->childNodes->item(0)->childNodes->item(0)->childNodes->length < 2) {
                $name = $infoSquared2
                    ->childNodes->item(0)->childNodes->item(0)->childNodes->item(0)->childNodes->item(0)->nodeValue;
                //-----
            }else{
                $name = $infoSquared2
                    ->childNodes->item(0)->childNodes->item(0)->childNodes->item(0)->childNodes->item(1)->nodeValue;
            }

            if ($priceSquared2->childNodes !== null) {
                $price = $priceSquared2->childNodes->item(0)->childNodes->item(0)->nodeValue;
            }else {
                $price = $priceSquared2->nodeValue;
            }

            $priceClean = trim(preg_replace('/[^0-9,.]/', ' ', $price));
            $priceClean = explode(' ', $priceClean);
            $priceClean = $priceClean[0];

            if (empty($priceClean)) {
                continue;
            }

            $priceNumber = number_format(str_replace(['.',','], ['','.'], $priceClean),2, ',', '.');

            $this->logger->info("Krakenis find: ".$name.' to '.$priceNumber);

            $words = explode(' ', strtolower($findProduct));
            $patter = '/'.implode('|', $words).'/';
            $nameProduct = strtolower($name);

            $match = [];
            preg_match($patter, $nameProduct, $match);

            if (count($match) > 0) {
                $products[$index] = [
                    'product' => $nameProduct,
                    'price'   => $priceNumber,
                    'date'    => time(),
                ];
            }

        }

        return $products;
    }

}

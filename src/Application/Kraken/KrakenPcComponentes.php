<?php

namespace Application\Kraken;

use Monolog\Logger;

class KrakenPcComponentes implements Kraken
{
    private const FINDER_URL = 'https://www.pccomponentes.com/buscar/?query=';
    public const SOURCE      = 'pccomponentes';

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

        $classname = "tarjeta-articulo__nombre";
        $nodesName = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");

        $classname = "tarjeta-articulo__precio-actual";
        $nodesPvp  = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");


        $product = [];

        foreach ($nodesName as $index => $node) {
            $priceClean = preg_replace('/[^0-9,.]/', ' ', $nodesPvp->item($index)->nodeValue);
            $priceNumber = number_format(str_replace(',', '.', trim($priceClean)),2, ',', '.');

            $this->logger->info("Krakenis find: ".trim($node->nodeValue).' to '.$priceNumber);

            $words = explode(' ', strtolower($findProduct));
            $patter = '/'.implode('|', $words).'/';
            $nameProduct = strtolower(trim($node->nodeValue));

            $match = [];
            preg_match($patter, $nameProduct, $match);

            if (count($match) > 0) {
                $product[$index] = [
                    'product' => trim($node->nodeValue),
                    'price'   => $priceNumber,
                    'date'    => time(),
                ];
            }
        }

        return $product;
    }

}

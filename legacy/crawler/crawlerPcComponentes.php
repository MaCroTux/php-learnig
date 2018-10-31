<?php

const FINDER_URL = 'https://www.pccomponentes.com/buscar/?query=';

function crawlerPcComponentes($findProduct): array
{
    echo "Buscando: ". FINDER_URL.str_replace(' ', '+', $findProduct)."\n";

    $data           = file_get_contents(FINDER_URL.str_replace(' ', '+', $findProduct));

    $dataOutEndLine = preg_replace("/[\r\n|\n|\r]+/", '', $data);

    $dom = new DOMDocument;

    @$dom->loadHTML($dataOutEndLine);

    $finder    = new DomXPath($dom);

    $classname = "tarjeta-articulo__nombre";
    $nodesName = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");

    $classname = "tarjeta-articulo__precio-actual";
    $nodesPvp  = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");


    $product = [];

    foreach ($nodesName as $index => $node) {
        $priceClean = preg_replace('/[^0-9,.]/', ' ', $nodesPvp->item($index)->nodeValue);
        $priceNumber = number_format(str_replace(',', '.', trim($priceClean)),2, ',', '.');
        $product[$index] = [
            'product' => trim($node->nodeValue),
            'price'   => $priceNumber,
            'date'    => time(),
        ];
    }

    return $product;
}

/*
<table>
	<tr>
		<th>Name</th>
		<th>Without IVA</th>
		<th>PVP Prive</th>
	</tr>
	<tr>
		<td><?php echo $productName ?></td>
		<td><?php echo $basePrice ?></td>
		<td><?php echo $pvpPrice ?></td>
	</tr>
</table>
<code>
<pre>
-------------------------------------------------------------
<?php echo $productName ?> : <?php echo $basePrice  ?> € / <?php echo $pvpPrice ?> €
-------------------------------------------------------------
</pre>
</code>
*/

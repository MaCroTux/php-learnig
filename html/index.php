<?php

require '../lib/storage.php';

/* Archivo donde se guardaran los productos */
const PRODUCT_FIlE_NAME = '../product.json';

$list = storageReadAllProduct();

$hmtl = '<div class="table-responsive"><table style="width: 100%"  class="table">';
$hmtl .= '<thead>';
$hmtl .= '<tr>';
$hmtl .= '<th>Producto</th>';
$hmtl .= '<th>Precio</th>';
$hmtl .= '<th style="text-align:right;">PcComponentes</th>';
$hmtl .= '</tr>';
$hmtl .= '</thead>';

$hmtl .= '<tbody>';
foreach ($list as $product) {

    $hmtl .= '<tr>';

    $hmtl .= '<td><strong>'.$product['product'].'</strong></td>';
    $hmtl .= '<td>'.number_format($product['price'], 2, ',', '.').'</td>';

    $hmtlSub .= '<table style="width: 100%" class="table-striped">';
    $hmtlSub .= '<thead>';
    $hmtlSub .= '<tr>';
    $hmtlSub .= '<th>Producto</th>';
    $hmtlSub .= '<th style="text-align:right;">Precio</th>';
    $hmtlSub .= '</tr>';
    $hmtlSub .= '</thead>';
    $hmtlSub .= '<tbody>';
    foreach ($product['PcComponentes'] as $suggest) {
        $hmtlSub .= '<tr>';
        $hmtlSub .= '<td style="text-align:left;">'.$suggest['product'].'</td>';
        $hmtlSub .= '<td style="text-align:right;"">'.$suggest['price'].'</td>';
        $hmtlSub .= '</tr>';
    }
    $hmtlSub .= '</tbody>';
    $hmtlSub .= '</table>';

    $hmtl .= '<td style="text-align:right;">'.str_replace($product['product'], '<strong style="background-color:#4ff;">'.$product['product'].'</strong>', $hmtlSub).'</td>';

    $hmtl .= '</tr>';

}
$hmtl .= '</tbody>';
$hmtl .= '</table></div>';

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Listado de productos</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <h1>Listado de productos</h1>
    <?php echo $hmtl; ?>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>


<?php

/* Campos de la DB JSON */
const ID       = 'id';
const PRIORITY = 'priority';
const PRODUCT  = 'product';
const PRICE    = 'price';

const HEAD = [[
    'id'       => 'Id',
    'product'  => 'Producto',
    'price'    => 'Precio',
    'priority' => 'Priority',
]];

function getProducts(): void
{
    $list = array_map(function ($product) {
        if (isset($product['PcComponentes'])) {
            $pcComponentesSuggess = "\n";
            foreach ($product['PcComponentes'] as $inde => $suggests) {
                $product['PcComponentesSuggess'] .=  '                 PcComponentes -> '.$suggests['product'].':  '.$suggests['price']. "\n";
            }

            $product['PcComponentes'] = $pcComponentesSuggess;
        }

        return $product;
    },  storageReadAllProduct());

    echo table(array_merge(HEAD, $list));

    echo "Fin de registro \n";
}


function newProduct()
{
    $product  = readline('Nombre del producto $ ');
    $price    = readline('Precio del producto $ ');
    $priority = readline('Prioridad [1,2,3] $ ');

    $priority = empty($priority) ? 1 : $priority;

    $productData = [
        ID       => '--',
        PRODUCT  => $product,
        PRICE    => $price,
        PRIORITY => $priority,
    ];

    echo table([$productData], HEAD);

    $subAction = readline('Guardar? [S/n] $ ');

    if (strtolower($subAction) !== 'n') {
        insertProduct($productData);

        echo "\nRegistro guardado!\n";
    }
}

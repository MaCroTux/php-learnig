<?php

/**
 * Funcion encargada de leer el contenido del storage y devolver el listado
 * : array significa que esta funcion devuelve arrays
 */
function storageReadAllProduct(): array
{
    $dataRaw = file_get_contents(PRODUCT_FIlE_NAME);

    return json_decode($dataRaw, true);
}

/* Inserta los datos en la DB Json con unos campos definidos como constantes mas arriba */
/* void significa que la funcion no devuevle nada ya que solo guarda */
function insertProduct($fieldsList): void
{
    /* Usamos para leer la funcion que tenemos arriba para ello */
    $list    = storageReadAllProduct();
    /* Crea un id unico con una funcion nativa de PHP .-) */
    $id      = uniqid();

    $list[$id]       = $fieldsList;
    /* Modificamos los -- que pusimos antes temporalmente por el id real */
    $list[$id]['id'] = $id;


    /* No nos olvidemos de codificar a JSON antes de guardar :-0 */
    $dataRaw = json_encode($list);

    /* Escribimos el ficheros */
    file_put_contents(PRODUCT_FIlE_NAME, $dataRaw);
}

function saveRaw($products): void
{
    file_put_contents(PRODUCT_FIlE_NAME, json_encode($products));
}

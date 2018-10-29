<?php

/* Librerias de lectura de DB, echale un ojo antes */
require 'lib/storage.php';
/* Librerias de manipulacion de productos */
require 'lib/product.php';
/* Libreria qie pinta tablas moolaaa */
require 'lib/drawCli.php';

/* Archivo donde se guardaran los productos */
const PRODUCT_FIlE_NAME = 'product.json';

/* MENU: No paramos de pedir datos hasta que escribas exit */
do {

    $action = readline('Operacion [get|put|exit] $ ');

    /* Obetenr los productos */
    if ($action === 'get') {
        getProducts(); // -> product.php
    }

    /* Insertar un producto */
    if ($action === 'put') {
        newProduct(); // -> product.php
    }

} while (trim($action) != 'exit');

/* Chaooo */
echo "\nSee you next! .-)\n";

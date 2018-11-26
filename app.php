<?php

declare(strict_types=1);

const SUMA = 'sumar';
const RESTA = 'restar';
const MULTIPLICAR = 'multiplicar';

$operacion = $argv[1];
$numero1 = $argv[2];
$numero2 = $argv[3];

if ($operacion == SUMA) {
    imprimir($numero1 + $numero2, $operacion);
}

if ($operacion == RESTA) {
    imprimir($numero1 - $numero2, $operacion);
}

if ($operacion == MULTIPLICAR) {
    imprimir($numero1 * $numero2, $operacion);
}

function imprimir(int $numero, string $operacion)
{
    echo "\n-----------| $operacion |------------\n";
    echo "\n El resultado es: $numero \n";
    echo "\n-----------------------------------\n";
}

<?php

require 'crawler/crawlerPcComponentes.php';
require 'lib/storage.php';

const HIGH_PRIORITY = 1;
const MID_PRIORITY  = 2;
const LOW_PRIORITY  = 3;

const HIGH_PRIORITY_TIMER = 30;
const MID_PRIORITY_TIMER  = 240;
const LOW_PRIORITY_TIMER  = 3600;

const MAX_SEARCH_RESULT   = 5;

$list = storageReadAllProduct();

$highPriority = array_filter($list, function ($product) {
    return $product['priority'] == HIGH_PRIORITY;
});

$midPriority = array_filter($list, function ($product) {
    return $product['priority'] == MID_PRIORITY;
});

$lowPriority = array_filter($list, function ($product) {
    return $product['priority'] == LOW_PRIORITY;
});

$numHighPriority = count($highPriority);

$interval = $numHighPriority / HIGH_PRIORITY_TIMER;

foreach ($highPriority as $id => $product) {

    $search = array_slice(crawlerPcComponentes($product['product']), 0, MAX_SEARCH_RESULT);

    $list[$id]['PcComponentes'] = $search;

    saveRaw($list);

    /* Dormimos x tiempo antes de volver a pedir como los locos */
    sleep($interval);
}

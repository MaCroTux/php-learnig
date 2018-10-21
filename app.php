<?php

const FIlE_NAME = 'data.dat';

$action     = $argv[1] ?? '';
$name       = $argv[2];
$address    = $argv[3];
$telephone  = $argv[4];

regUser(FIlE_NAME, $action, $name, $address, $telephone);

function regUser($fileName, $action, $name, $address, $telephone) {

    if ($action === 'get') {

        $dataRaw = file_get_contents($fileName);
        print_r(json_decode($dataRaw));
        die('Fin de registro');

    }

    if ($action === 'put') {

        $dataRaw    = file_get_contents($fileName);
        $list       = json_decode($dataRaw, true);
        $id         = count($list)+1;

        $list[$id]['id']        = $id;
        $list[$id]['Name']      = $name;
        $list[$id]['Address']   = $address;
        $list[$id]['Telephone'] = $telephone;

        $dataRaw = json_encode($list);
        file_put_contents($fileName, $dataRaw);

    }
}

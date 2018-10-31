<?php

function table($data, $head = []) {

    $data = array_merge($head, $data);

    // Find longest string in each column
    $columns = [];
    foreach ($data as $row_key => $row) {
        foreach ($row as $cell_key => $cell) {
            $length = strlen($cell);
            if (empty($columns[$cell_key]) || $columns[$cell_key] < $length) {
                $columns[$cell_key] = $length;
            }
        }
    }

    // Output table, padding columns
    $table = '';
    foreach ($data as $row_key => $row) {
        foreach ($row as $cell_key => $cell)
            $table .= str_pad($cell, $columns[$cell_key]) . '   ';
        $table .= PHP_EOL;
    }
    return "\n-----------------------------------------------------------------------\n".
        $table.
        "-----------------------------------------------------------------------\n";

}

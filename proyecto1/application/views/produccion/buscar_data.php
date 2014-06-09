<?php

$j = 0;

if ($results) {
    $records = [];
    foreach ($results as $result) {
        $records[$j] = array('id' => $result->PROD_CODIGO,
            'label' => $result->PROD_TITULO,
            'value' => $result->PROD_TITULO
        );
        $j++;
    }
    echo json_encode($records);
}


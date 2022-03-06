<?php

function outputJson(array $data) {
    header("Content-Type: application/json");
    echo json_encode($data);
    exit();
}
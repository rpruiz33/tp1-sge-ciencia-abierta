<?php
header('Content-Type: application/json');

require 'openalex.php';

$doi = $_GET['doi'] ?? '';

if (!$doi) {
    echo json_encode(['error' => 'DOI vacío']);
    exit;
}

$data = obtenerDatosOpenAlex($doi);
echo json_encode($data);
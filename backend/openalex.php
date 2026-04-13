<?php
require '../config/config.php';
function limpiarDOI($doi) {
    $doi = trim($doi);
    return preg_replace('/(https?:\/\/doi\.org\/|doi:)/i', '', $doi);
}

function obtenerDatosOpenAlex($doi) {
    $doi = limpiarDOI($doi);
    $url = "https://api.openalex.org/works/https://doi.org/" . urlencode($doi);

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_HTTPHEADER => [
        'User-Agent: ' . OPENALEX_EMAIL
        ]
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200 || !$response) {
        return ['error' => true];
    }

    $data = json_decode($response, true);
    if (!$data) {
        return ['error' => true];
    }

    return [
        'error' => false,
        'title' => $data['title'] ?? 'Sin título',
        'year' => $data['publication_year'] ?? '',
        'type' => $data['type'] ?? 'Desconocido',
        'cited_by_count' => $data['cited_by_count'] ?? 0,
        'referenced_works_count' => $data['referenced_works_count'] ?? 0,
        'open_access' => $data['open_access']['is_oa'] ?? false,
        'oa_type' => $data['open_access']['oa_status'] ?? 'unknown',
        'journal' => $data['primary_location']['source']['display_name'] ?? 'Desconocido',
        'authors' => array_map(fn($a) => $a['author']['display_name'], $data['authorships'] ?? []),
        'sources' => $data['counts_by_type'] ?? []
    ];
}
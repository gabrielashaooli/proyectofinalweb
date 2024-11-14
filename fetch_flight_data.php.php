<?php
define('API_KEY', '4ed61e0eff93e2c0ec5304a12bebab3e');

function fetchFlightData() {
    $url = "http://api.aviationstack.com/v1/flights?access_key=" . API_KEY;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $data = fetchFlightData();
    // Devuelve todos los datos sin aplicar filtros adicionales
    header('Content-Type: application/json');
    echo json_encode(['data' => $data['data']]);
}
?>

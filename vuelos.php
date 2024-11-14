<?php
define('API_KEY', '4ed61e0eff93e2c0ec5304a12bebab3e');

function fetchFlightData($origin, $destination, $departureDate) {
    $url = "http://api.aviationstack.com/v1/flights?access_key=" . API_KEY . "&dep_iata=$origin&arr_iata=$destination&flight_date=$departureDate";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['origin']) && isset($_GET['destination']) && isset($_GET['departureDate'])) {
    $origin = $_GET['origin'];
    $destination = $_GET['destination'];
    $departureDate = $_GET['departureDate'];

    $data = fetchFlightData($origin, $destination, $departureDate);
    header('Content-Type: application/json');
    echo json_encode($data);
}
?>

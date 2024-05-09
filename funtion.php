<?php

// Obtener los datos de entrada del formulario
$moneda_one = $_POST['moneda_one'];
$moneda_two = $_POST['moneda_two'];
$cantidad_one = $_POST['cantidad_one'];

// Hacer la solicitud a la API de cambio de moneda
$url = "https://api.exchangerate-api.com/v4/latest/{$moneda_one}";
$response = file_get_contents($url);
$data = json_decode($response, true);

// Obtener la tasa de cambio de la respuesta
$tasa = $data['rates'][$moneda_two];

// Calcular la cantidad en la segunda moneda
$cantidad_two = $cantidad_one * $tasa;

// Construir la respuesta JSON
$response = [
    'cambio' => "1 {$moneda_one} = {$tasa} {$moneda_two}",
    'cantidad_two' => number_format($cantidad_two, 2),
];

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);

?>

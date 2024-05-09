<?php

// Obtener los datos de entrada del formulario
$moneda_one = $_GET['moneda-uno'];
$moneda_two = $_GET['moneda-dos'];
$cantidad_one = $_GET['cantidad-uno'];

// Hacer la solicitud a la API de cambio de moneda
$url = "https://api.exchangerate-api.com/v4/latest/{$moneda_one}";
$response = file_get_contents($url);

// Verificar si la solicitud fue exitosa
if ($response === false) {
    echo json_encode(['error' => 'No se pudo conectar a la API de cambio de moneda']);
    exit;
}

// Decodificar la respuesta JSON
$data = json_decode($response, true);

// Verificar si la decodificación fue exitosa
if ($data === null) {
    echo json_encode(['error' => 'Error al decodificar la respuesta JSON de la API de cambio de moneda']);
    exit;
}

// Verificar si la moneda de origen está en la respuesta
if (!isset($data['rates'][$moneda_one])) {
    echo json_encode(['error' => 'La moneda de origen no está disponible en la respuesta de la API de cambio de moneda']);
    exit;
}

// Obtener la tasa de cambio
$tasa = $data['rates'][$moneda_two];

// Verificar si la moneda de destino está en la respuesta
if (!isset($data['rates'][$moneda_two])) {
    echo json_encode(['error' => 'La moneda de destino no está disponible en la respuesta de la API de cambio de moneda']);
    exit;
}

// Calcular la cantidad en la segunda moneda
$cantidad_two = $cantidad_one * $tasa;

// Construir la respuesta JSON
$response = [ 
    'cambio' => "1 {$moneda_one} = {$tasa} {$moneda_two}",
    'cantidad-dos' => number_format($cantidad_two, 2),
];        

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);

?>



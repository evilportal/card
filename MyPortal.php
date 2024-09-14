<?php
class MyPortal {
    private $dataFile = 'data_private/user_data.txt';

    public function registrarDatos($nombre, $direccion, $codigo_postal, $delegacion, $numero) {
        // Crear el contenido a escribir
        $data = "Nombre: $nombre\n";
        $data .= "Dirección: $direccion\n";
        $data .= "Código Postal: $codigo_postal\n";
        $data .= "Delegación: $delegacion\n";
        $data .= "Número Telefónico: $numero\n";
        $data .= "Fecha: " . date('Y-m-d H:i:s') . "\n";
        $data .= "------------------------\n";

        // Asegurarse de que el directorio existe
        $dir = dirname($this->dataFile);
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0755, true)) {
                throw new Exception("No se pudo crear el directorio $dir");
            }
        }

        // Intentar escribir en el archivo
        if (file_put_contents($this->dataFile, $data, FILE_APPEND | LOCK_EX) === false) {
            throw new Exception("No se pudo escribir en el archivo {$this->dataFile}");
        }

        return true;
    }
}
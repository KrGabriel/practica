<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "alumno";
$password = "alumno";
$database = "CRUD";

// Crear una conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Establecer la codificación de caracteres a UTF-8
$conn->set_charset("utf8");
?>
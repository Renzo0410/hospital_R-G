<?php
$servername = "localhost"; // o la IP del servidor de base de datos
$username = "root"; // tu usuario
$password = ""; // tu contraseña
$dbname = "hospital"; // tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

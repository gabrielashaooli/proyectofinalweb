<?php
$conexion = new mysqli('localhost', 'root', 'root', 'travel_agent');

if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$usuario = $_POST['usuario'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Encriptar la contraseña
$rol = $_POST['rol'];

// Validar que el nombre de usuario solo contenga letras
if (!preg_match("/^[A-Za-z]+$/", $usuario)) {
    die("Error: El nombre de usuario solo puede contener letras.");
}
// Usar Prepared Statements
$query = $conexion->prepare("INSERT INTO usuarios (nombre, apellido, usuario, email, password, rol) VALUES (?, ?, ?, ?, ?, ?)");

$query->bind_param("ssssss", $nombre, $apellido, $usuario, $email, $password, $rol);

if ($query->execute()) {
    echo "Registro exitoso. <a href='login.html'>Inicia sesión</a>";
} else {
    echo "Error: " . $query->error;
}

$query->close();
$conexion->close();
?>

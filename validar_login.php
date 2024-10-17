<?php
session_start();

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "root", "travel_agent");

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Verificar credenciales
$query = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verificar contraseña
    if (password_verify($password, $user['password'])) {
        
        $_SESSION['id'] = $user['id']; 
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['apellido'] = $user['apellido'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['rol'] = $user['rol']; 

    if ($user['rol'] === 'administrador') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: mi_perfil.php");
        }
        exit();
    } else {
        echo "Contraseña incorrecta";
    }
} else {
    echo "Usuario no encontrado";
}

$conn->close();
?>
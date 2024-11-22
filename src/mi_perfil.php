<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../views/login.html");
    exit();
}
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: ../views/login.html");
    exit();
}

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "root", "travel_agent");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Travel Agent</title>
    <link rel="stylesheet" href="../estilos/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<header>
    <nav>
        <ul class="menu">
            <li><a href="../src/mi_perfil.php" class="active">Perfil</a></li>
            <li><a href="../views/plan.html">Plan</a></li>
            <li><a href="../src/reservas.php">Mis Reservas</a></li>
            <li><a href="../views/servicios.html">Servicios</a></li>
        </ul>
    </nav>
</header>

<main class="container mt-5">
    <div class="card shadow-lg p-5">
        <h2 class="text-center mb-4 text-primary">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h2>

        <div class="row mb-5">
            <div class="col-md-6">
                <h3 class="text-primary">Información del Usuario</h3>
                <p><strong>Nombre:</strong> <?php echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'No disponible'; ?></p>
                <p><strong>Apellido:</strong> <?php echo isset($_SESSION['apellido']) ? htmlspecialchars($_SESSION['apellido']) : 'No disponible'; ?></p>
                <p><strong>Nombre de Usuario:</strong> <?php echo htmlspecialchars($_SESSION['usuario']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
            </div>
            <div class="col-md-6">
                <h3 class="text-primary">Configuración</h3>
                <ul class="list-group">
                    <li class="list-group-item"><a href="#">Cambiar Contraseña</a></li>
                    <li class="list-group-item"><a href="#">Métodos de Pago</a></li>
                    <li class="list-group-item"><a href="#">Editar Información</a></li>
                    <li class="list-group-item"><a href="logout.php" class="text-danger">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </div>
</main>

<footer class="bg-dark text-white text-center py-3 mt-5">
    &copy; 2024 Travel Agent. Todos los derechos reservados.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
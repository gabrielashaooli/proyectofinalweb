<?php
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
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
    <title>Panel de Administración - Elitescapes</title>
    <link rel="stylesheet" href="../estilos/styleservicios.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">Elitescapes</a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../src/admin_dashboard.php">Mi perfil</a></li>
                <li class="nav-item"><a class="nav-link" href="../src/crear_itinerario.php">Crear itinerario</a></li>
            </ul>
        </div>
    </nav>
</header>

<main class="container mt-5">
    <div class="card shadow-lg p-5">
        <h2 class="text-center mb-4 text-info">Bienvenido Administrador, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h2>

        <div class="row mb-5">
            <div class="col-md-6">
                <h4 class="text-info mb-3"><i class="bi bi-person-circle me-2"></i>Información del Administrador</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Nombre:</strong> <?php echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'No disponible'; ?></li>
                    <li class="list-group-item"><strong>Apellido:</strong> <?php echo isset($_SESSION['apellido']) ? htmlspecialchars($_SESSION['apellido']) : 'No disponible'; ?></li>
                    <li class="list-group-item"><strong>Nombre de Usuario:</strong> <?php echo htmlspecialchars($_SESSION['usuario']); ?></li>
                    <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></li>
                </ul>
            </div>
            <div class="col-md-6">
                <h4 class="text-info mb-3"><i class="bi bi-gear me-2"></i>Configuración</h4>
                <ul class="list-group">
                    <li class="list-group-item"><a href="#" class="text-decoration-none"><i class="bi bi-lock me-2"></i>Cambiar Contraseña</a></li>
                    <li class="list-group-item"><a href="#" class="text-decoration-none"><i class="bi bi-pencil-square me-2"></i>Editar Información</a></li>
                    <li class="list-group-item"><a href="logout.php" class="text-danger text-decoration-none"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </div>
</main>

<footer class="text-center py-3 bg-light mt-4">
    <p>&copy; 2024 Elitescapes. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>

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

$reservas = $conn->prepare("
    SELECT destinos.nombre AS destino, 
           reservas.fecha_inicio, 
           reservas.fecha_fin, 
           reservas.num_personas, 
           reservas.total, 
           reservas.metodo_pago, 
           reservas.comentarios, 
           reservas.estado 
    FROM reservas 
    JOIN destinos ON reservas.id_destino = destinos.id 
    WHERE reservas.id_usuario = ?
");
$reservas->bind_param("i", $_SESSION['id']); 
$reservas->execute();
$result = $reservas->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Travel Agent</title>
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
                        <li class="nav-item"><a class="nav-link" href="../src/mi_perfil.php">Mi perfil</a></li>
                        <li class="nav-item"><a class="nav-link" href="../views/plan.html">Travel Assistant</a></li>
                        <li class="nav-item"><a class="nav-link active" href="../src/reservas.php">Reservas</a></li>
                        <li class="nav-item"><a class="nav-link " href="../views/servicios.html">Servicios</a></li>
                        <li class="nav-item"><a class="nav-link" href="../views/mapa.html">Mapa</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5">
    <h3 class="text-info text-center mb-4"><i class="bi bi-calendar-check me-2"></i>Mis Reservas</h3>
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Destino</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Fin</th>
                    <th>Número de Personas</th>
                    <th>Total (USD)</th>
                    <th>Método de Pago</th>
                    <th>Comentarios</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($reserva = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reserva['destino']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['fecha_inicio']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['fecha_fin']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['num_personas']); ?></td>
                        <td><?php echo number_format($reserva['total'], 2); ?> USD</td>
                        <td><?php echo htmlspecialchars($reserva['metodo_pago']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['comentarios']); ?></td>
                        <td>
                            <span class="badge 
                                <?php 
                                    if ($reserva['estado'] === 'confirmado') echo 'badge-confirmado';
                                    elseif ($reserva['estado'] === 'pendiente') echo 'badge-pendiente';
                                    elseif ($reserva['estado'] === 'cancelado') echo 'badge-cancelado';
                                ?>">
                                <?php echo ucfirst(htmlspecialchars($reserva['estado'])); ?>
                            </span>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>

<footer class="text-center py-3 mt-4 bg-light">
        <p>&copy; 2024 Travel Agent. Todos los derechos reservados.</p>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$reservas->close();
$conn->close();
?>

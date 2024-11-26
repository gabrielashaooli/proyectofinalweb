<?php
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: ../views/login.html");
    exit();
}

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "root", "travel_agent");

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_POST['usuario'];
    $id_destino = $_POST['destino'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $num_personas = $_POST['num_personas'];
    $total = $_POST['total'];
    $metodo_pago = $_POST['metodo_pago'];
    $estado = $_POST['estado'];
    $comentarios = $_POST['comentarios'];

    $query = $conn->prepare("INSERT INTO reservas (id_usuario, id_destino, fecha_inicio, fecha_fin, num_personas, total, metodo_pago, estado, comentarios) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $query->bind_param("iissidsss", $id_usuario, $id_destino, $fecha_inicio, $fecha_fin, $num_personas, $total, $metodo_pago, $estado, $comentarios);

    if ($query->execute()) {
        echo "<div class='alert alert-success'>Itinerario creado exitosamente.</div>";
        header("Refresh: 2; URL=admin_dashboard.php");
    } else {
        echo "<div class='alert alert-danger'>Error al crear el itinerario: " . $query->error . "</div>";
    }

    $query->close();
    $conn->close();
    exit();
}

$query_usuarios = $conn->query("SELECT id, email FROM usuarios WHERE rol = 'cliente'");
$query_destinos = $conn->query("SELECT id, nombre FROM destinos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../estilos/styleservicios.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <title>Crear Itinerario - Travel Agent</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
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
    <h2 class="text-center text-info mb-4">Crear Itinerario</h2>
    <form action="crear_itinerario.php" method="POST" class="shadow p-4 bg-white rounded">
        <div class="mb-3">
            <label for="usuario" class="form-label">Seleccionar Usuario</label>
            <select id="usuario" name="usuario" class="form-control" required>
                <?php while ($usuario = $query_usuarios->fetch_assoc()) { ?>
                    <option value="<?php echo $usuario['id']; ?>"><?php echo $usuario['email']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="destino" class="form-label">Seleccionar Destino</label>
            <select id="destino" name="destino" class="form-control" required>
                <?php while ($destino = $query_destinos->fetch_assoc()) { ?>
                    <option value="<?php echo $destino['id']; ?>"><?php echo $destino['nombre']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required />
        </div>

        <div class="mb-3">
            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required />
        </div>

        <div class="mb-3">
            <label for="num_personas" class="form-label">Número de Personas</label>
            <input type="number" id="num_personas" name="num_personas" class="form-control" value="1" min="1" required />
        </div>

        <div class="mb-3">
            <label for="total" class="form-label">Total (USD)</label>
            <input type="number" id="total" name="total" class="form-control" step="0.01" required />
        </div>

        <div class="mb-3">
            <label for="metodo_pago" class="form-label">Método de Pago</label>
            <input type="text" id="metodo_pago" name="metodo_pago" class="form-control" required />
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select id="estado" name="estado" class="form-control" required>
                <option value="confirmada">Confirmada</option>
                <option value="pendiente">Pendiente</option>
                <option value="cancelada">Cancelada</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="comentarios" class="form-label">Comentarios</label>
            <textarea id="comentarios" name="comentarios" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-outline-info w-100">Crear Itinerario</button>
    </form>
</main>

<footer class="text-center py-3 bg-light mt-4">
    <p>&copy; 2024 Elitescapes. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

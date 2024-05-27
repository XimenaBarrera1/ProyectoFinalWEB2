<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Agregar nuevo escenario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $id_nivel = $_POST['id_nivel'];
    $stmt = $conn->prepare("INSERT INTO escenario (nombre, descripcion, id_nivel) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $nombre, $descripcion, $id_nivel);
    $stmt->execute();
    $stmt->close();
}

// Eliminar escenario
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM escenario WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Obtener todos los escenarios
$result = $conn->query("SELECT * FROM escenario");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrar Escenarios</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Administrar Escenarios</h1>
        <form action="escenario.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del Escenario:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
            </div>
            <div class="form-group">
    <label for="id_nivel">ID del Nivel:</label>
    <select class="form-control" id="id_nivel" name="id_nivel" required>
        <?php
        // Obtener todos los niveles disponibles
        $sql_niveles = "SELECT * FROM nivel";
        $result_niveles = $conn->query($sql_niveles);
        if ($result_niveles->num_rows > 0) {
            while ($nivel = $result_niveles->fetch_assoc()) {
                echo '<option value="' . $nivel['id'] . '">' . $nivel['num_nivel'] . ' - ' . $nivel['descripcion'] . '</option>';
            }
        } else {
            echo '<option value="">No hay niveles disponibles</option>';
        }
        ?>
    </select>
</div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Agregar Escenario</button>
            </div>
        </form>

        <hr>

        <h2>Escenarios</h2>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>ID del Nivel</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['descripcion']; ?></td>
                            <td><?php echo $row['id_nivel']; ?></td>
                            <td>
                                <a href="editar_escenario.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning">Editar</a>
                                <a href="eliminar_escenario.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay escenarios disponibles.</p>
        <?php endif; ?>
    </div>
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</body>
</html>

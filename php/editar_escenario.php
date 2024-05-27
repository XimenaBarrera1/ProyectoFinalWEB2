<?php
include 'connection.php';

// Verificar si se envió el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $id_nivel = $_POST['id_nivel'];

    // Actualizar el escenario en la base de datos
    $stmt = $conn->prepare("UPDATE escenario SET nombre = ?, descripcion = ?, id_nivel = ? WHERE id = ?");
    $stmt->bind_param("ssii", $nombre, $descripcion, $id_nivel, $id);
    if ($stmt->execute()) {
        // Redirigir a la página de escenarios después de la edición
        header("Location: escenario.php");
        exit();
    } else {
        // Mostrar un mensaje de error si la actualización falla
        echo "<p class='alert alert-danger'>Error al actualizar el escenario: " . $conn->error . "</p>";
    }
}

// Obtener el ID del escenario a editar
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    // Obtener los datos del escenario a editar
    $sql = "SELECT * FROM escenario WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $escenario = $result->fetch_assoc();
    } else {
        // Mostrar un mensaje si el escenario no se encuentra
        echo "<p class='alert alert-danger'>Escenario no encontrado.</p>";
        exit();
    }
} else {
    // Mostrar un mensaje si no se proporciona un ID de escenario
    echo "<p class='alert alert-danger'>No se proporcionó un ID de escenario para editar.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Escenario</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Escenario</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $escenario['id']; ?>">
            <div class="form-group">
                <label>Nombre del Escenario:</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo $escenario['nombre']; ?>" required>
            </div>
            <div class="form-group">
                <label>Descripción:</label>
                <textarea name="descripcion" class="form-control"><?php echo $escenario['descripcion']; ?></textarea>
            </div>
            <div class="form-group">
                <label>ID del Nivel:</label>
                <select name="id_nivel" class="form-control" required>
                    <?php
                    // Obtener todos los niveles disponibles
                    $sql_niveles = "SELECT * FROM nivel";
                    $result_niveles = $conn->query($sql_niveles);
                    if ($result_niveles->num_rows > 0) {
                        while ($nivel = $result_niveles->fetch_assoc()) {
                            $selected = ($nivel['id'] == $escenario['id_nivel']) ? "selected" : "";
                            echo "<option value='" . $nivel['id'] . "' $selected>" . $nivel['num_nivel'] . " - " . $nivel['descripcion'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay niveles disponibles</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="escenario.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>

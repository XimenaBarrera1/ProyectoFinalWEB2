<?php
include 'connection.php';

// Verificar si se ha proporcionado un ID de contexto para editar
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    // Obtener los detalles del contexto con el ID proporcionado
    $sql = "SELECT * FROM contexto WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p class='alert alert-danger'>El contexto no existe.</p>";
        exit(); // Salir del script si no se encontró el contexto
    }
} else {
    echo "<p class='alert alert-danger'>No se proporcionó un ID de contexto para editar.</p>";
    exit(); // Salir del script si no se proporcionó un ID de contexto
}

// Verificar si se ha enviado el formulario para actualizar el contexto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descripcion = $_POST['descripcion'];
    // Actualizar el contexto en la base de datos
    $sql = "UPDATE contexto SET descripcion = '$descripcion' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='alert alert-success'>Contexto actualizado correctamente</p>";
    } else {
        echo "<p class='alert alert-danger'>Error al actualizar el contexto: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Contexto</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Contexto</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" class="form-control"><?php echo $row['descripcion']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="contexto.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</body>
</html>

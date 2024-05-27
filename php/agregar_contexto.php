<?php
include 'connection.php';

// Obtener la lista de escenarios disponibles
$sql_escenarios = "SELECT id, nombre FROM escenario";
$result_escenarios = $conn->query($sql_escenarios);
$escenarios = [];
if ($result_escenarios->num_rows > 0) {
    while ($row = $result_escenarios->fetch_assoc()) {
        $escenarios[$row['id']] = $row['nombre'];
    }
}

// Verificar si se ha enviado el formulario para agregar un nuevo contexto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar los datos del formulario
    $descripcion = $_POST['descripcion'];
    $img = $_POST['img'];
    $id_escenario = $_POST['id_escenario'];

    // Insertar el nuevo contexto en la base de datos
    $sql = "INSERT INTO contexto (descripcion, img, id_escenarios) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $descripcion, $img, $id_escenario);
    if ($stmt->execute()) {
        echo "<p class='alert alert-success'>Contexto agregado correctamente</p>";
    } else {
        echo "<p class='alert alert-danger'>Error al agregar el contexto: " . $conn->error . "</p>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Contexto</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Agregar Contexto</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="img">Imagen:</label>
                <input type="text" name="img" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="id_escenario">Escenario:</label>
                <select name="id_escenario" class="form-control" required>
                    <option value="">Selecciona un escenario</option>
                    <?php foreach ($escenarios as $id => $nombre) : ?>
                        <option value="<?php echo $id; ?>"><?php echo $nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
            <a href="contexto.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</body>
</html>

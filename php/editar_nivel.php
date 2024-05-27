<?php include('connection.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Nivel</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Nivel</h2>
        <?php

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    // Ahora puedes usar $id para buscar el nivel correspondiente en la base de datos y mostrar su información en el formulario de edición.
}

        // Verifica si se proporciona un ID de nivel para editar
        if (isset($_GET['edit'])) {
            $id = $_GET['edit'];
            
            // Prepara la consulta SQL utilizando una instrucción preparada para evitar inyección de SQL
            $sql = "SELECT * FROM nivel WHERE id=?";
            $stmt = $conn->prepare($sql);
            
            // Vincula el parámetro y ejecuta la consulta
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
            // Obtiene el resultado de la consulta
            $result = $stmt->get_result();
            
            // Verifica si se encontraron resultados y asigna $row si es así
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } else {
                echo "<p class='alert alert-danger'>El nivel no existe.</p>";
            }
        } else {
            echo "<p class='alert alert-danger'>No se proporcionó un ID de nivel para editar.</p>";
        }

        // Verifica si se está procesando el formulario y si $row está definido
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($row)) {
            $id = $_POST['id'];
            $num_nivel = $_POST['num_nivel'];
            $descripcion = $_POST['descripcion'];

            // Prepara y ejecuta la consulta de actualización
            $sql = "UPDATE nivel SET num_nivel=?, descripcion=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isi", $num_nivel, $descripcion, $id);
            
            if ($stmt->execute()) {
                echo "<p class='alert alert-success'>Nivel actualizado correctamente</p>";
            } else {
                echo "<p class='alert alert-danger'>Error al actualizar el nivel: " . $conn->error . "</p>";
            }
        }
        ?>
        <!-- Muestra el formulario solo si $row está definido -->
        <?php if (isset($row)): ?>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label>Numero de Nivel</label>
                <input type="number" name="num_nivel" class="form-control" value="<?php echo $row['num_nivel']; ?>" required>
            </div>
            <div class="form-group">
                <label>Descripcion</label>
                <textarea name="descripcion" class="form-control"><?php echo $row['descripcion']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
        <?php endif; ?>
        <!-- Enlace para cancelar la edición y volver a la página de niveles -->
        <a href="nivel.php" class="btn btn-secondary">Cancelar</a>
    </div>
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</body>
</html>

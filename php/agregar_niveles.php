<?php include('connection.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Nivel</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Agregar Nivel</h2>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $num_nivel = $_POST['num_nivel'];
            $descripcion = $_POST['descripcion'];

            $sql = "INSERT INTO nivel (num_nivel, descripcion) VALUES ('$num_nivel', '$descripcion')";
            if ($conn->query($sql) === TRUE) {
                echo "<p class='alert alert-success'>Nuevo nivel agregado correctamente</p>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>Numero de Nivel</label>
                <input type="number" name="num_nivel" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Descripcion</label>
                <textarea name="descripcion" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
            <a href="nivel.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>

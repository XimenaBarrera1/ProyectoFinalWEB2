<?php include('connection.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD Niveles</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Niveles</h2>
        <a href="agregar_niveles.php" class="btn btn-success mb-3">Agregar Nivel</a>
        <?php
        // Leer niveles
        $sql = "SELECT * FROM nivel";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered">';
            echo '<tr><th>ID</th><th>Numero de Nivel</th><th>Descripcion</th><th>Acciones</th></tr>';
            while($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>'.$row['id'].'</td>';
                echo '<td>'.$row['num_nivel'].'</td>';
                echo '<td>'.$row['descripcion'].'</td>';
                echo '<td>
                    <a href="editar_nivel.php?edit=' . $row['id'] . '" class="btn btn-warning">Editar</a>
                    <a href="eliminar_nivel.php?delete=' . $row['id'] . '" class="btn btn-danger">Eliminar</a>
                  </td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No hay niveles disponibles</p>';
        }
        ?>
    </div>
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</body>
</html>

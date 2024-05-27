<?php
include 'connection.php';

// Verificar si se ha enviado una solicitud de eliminación de contexto
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM contexto WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        // Redirigir a esta misma página después de eliminar el contexto
        header("Location: contexto.php");
        exit();
    } else {
        echo "<p class='alert alert-danger'>Error al eliminar el contexto: " . $conn->error . "</p>";
    }
}

// Obtener todos los contextos de la base de datos
$sql = "SELECT * FROM contexto";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lista de Contextos</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Lista de Contextos</h2>
        <a href="agregar_contexto.php" class="btn btn-success mb-3">Agregar Contexto</a>
        <?php
        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered">';
            echo '<tr><th>ID</th><th>Descripción</th><th>Acciones</th></tr>';
            while($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>'.$row['id'].'</td>';
                echo '<td>'.$row['descripcion'].'</td>';
                echo '<td>
                    <a href="editar_contexto.php?edit=' . $row['id'] . '" class="btn btn-warning">Editar</a>
                    <a href="contexto.php?delete=' . $row['id'] . '" class="btn btn-danger">Eliminar</a>
                  </td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No hay contextos disponibles</p>';
        }
        ?>
    </div>
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</body>
</html>

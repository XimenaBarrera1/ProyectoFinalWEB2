<?php
include('connection.php');

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM nivel WHERE id= $id";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='alert alert-success'>Nivel eliminado correctamente</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    // Redirige de vuelta a la página de niveles después de eliminar
    header("Location: nivel.php");
    // Asegúrate de que no haya más procesamiento después de la redirección
    die();
}
?>

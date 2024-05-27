<?php
require_once("connection.php");

$id_estudiante = $_POST['id_estudiante_eliminar'];

$sql = "DELETE FROM estudiante WHERE id = $id_estudiante";

if ($conn->query($sql) === TRUE) {
    echo "estudiante eliminado correctamente";
} else {
    echo "error al eliminar estudiante: " . $conn->error;
}

$conn->close();
?>
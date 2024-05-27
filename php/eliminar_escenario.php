<?php
include 'connection.php';

// Verificar si se proporcionó un ID de escenario para eliminar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar el escenario de la base de datos
    $sql = "DELETE FROM escenario WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        // Redirigir a la página de escenarios después de la eliminación
        header("Location: escenario.php");
        exit();
    } else {
        // Mostrar un mensaje de error si la eliminación falla
        echo "<p class='alert alert-danger'>Error al eliminar el escenario: " . $conn->error . "</p>";
        exit();
    }
} else {
    // Mostrar un mensaje si no se proporciona un ID de escenario para eliminar
    echo "<p class='alert alert-danger'>No se proporcionó un ID de escenario para eliminar.</p>";
    exit();
}
?>

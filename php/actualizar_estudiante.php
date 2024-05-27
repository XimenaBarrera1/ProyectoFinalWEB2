<?php
require_once ("connection.php");

$id_estudiante = $_POST['id_estudiante_actualizar'];
$nuevo_nombre = $_POST['nuevo_nombre'];
$nuevos_apellidos = $_POST['nuevos_apellidos'];
$nuevo_email = $_POST['nuevo_email'];
$nueva_edad = $_POST['nueva_edad'];
$nuevo_username = $_POST['nuevo_username'];
$nueva_password = $_POST['nueva_password'];
$nuevo_id_nivel = $_POST['nuevo_id_nivel'];

$campos_actualizar = [];

if (!empty($nuevo_nombre)) {
    $campos_actualizar[] = "nombre = '$nuevo_nombre'";
}
if (!empty($nuevos_apellidos)) {
    $campos_actualizar[] = "apellidos = '$nuevos_apellidos'";
}
if (!empty($nuevo_email)) {
    $campos_actualizar[] = "email = '$nuevo_email'";
}
if (!empty($nueva_edad)) {
    $campos_actualizar[] = "edad = '$nueva_edad'";
}
if (!empty($nuevo_username)) {
    $campos_actualizar[] = "username = '$nuevo_username'";
}
if (!empty($nueva_password)) {
    $hash_password = password_hash($nueva_password, PASSWORD_DEFAULT);
    $campos_actualizar[] = "password = '$hash_password'";
}
if (!empty($nuevo_id_nivel)) {
    $campos_actualizar[] = "id_nivel = '$nuevo_id_nivel'";
}

if (count($campos_actualizar) > 0) {
    $sql = "UPDATE estudiante SET " . implode(', ', $campos_actualizar) . " WHERE id = $id_estudiante";

    if ($conn->query($sql) === TRUE) {
        echo "Datos del estudiante actualizados correctamente";
    } else {
        echo "Error al actualizar datos del estudiante: " . $conn->error;
    }
} else {
    echo "No se han proporcionado datos para actualizar.";
}

$conn->close();
?>

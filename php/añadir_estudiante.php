<?php
require_once("connection.php");

$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$email = $_POST['email'];
$fecha_edad = $_POST['edad'];
$username = $_POST['username'];
$password = $_POST['password'];
$id_nivel = $_POST['id_nivel'];

function calcularEdad($fecha_edad) {
    $fecha_nacimiento = new DateTime($fecha_edad);
    $hoy = new DateTime();
    $edad = $hoy->diff($fecha_nacimiento)->y;
    return $edad;
}

$edad = calcularEdad($fecha_edad);

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO estudiante (nombre, apellidos, email, edad, username, password, id_nivel) VALUES 
            ('$nombre', '$apellidos', '$email', '$edad', '$username', '$password_hash', '$id_nivel')";

if ($conn->query($sql) === TRUE) {
    echo "Nuevo estudiante añadido correctamente";
} else {
    echo "Error al añadir estudiante: " . $conn->error;
}

$conn->close();
?>
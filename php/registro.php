<?php
require_once("connection.php");

$name = $_POST['nombre'];
$last_name = $_POST['apellido'];
$email = $_POST['email'];
$birth_date = $_POST['fecha_nacimiento'];
$password = $_POST['password'];

function calcularEdad($birth_date) {
    $fecha_nacimiento = new DateTime($birth_date);
    $hoy = new DateTime();
    $edad = $hoy->diff($fecha_nacimiento)->y;
    return $edad;
}

$edad = calcularEdad($birth_date);

$name = $conn->real_escape_string($name);
$last_name = $conn->real_escape_string($last_name);
$email = $conn->real_escape_string($email);
$birth_date = $conn->real_escape_string($birth_date);

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$id_nivel = 1;

$sql = "INSERT INTO estudiante (nombre, apellidos, email, edad, password, id_nivel) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

$stmt->bind_param("sssisi", $name, $last_name, $email, $edad, $password_hash, $id_nivel);

if ($stmt->execute()) {
    echo "Registro exitoso";
} else {
    echo "Error al registrar el usuario: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

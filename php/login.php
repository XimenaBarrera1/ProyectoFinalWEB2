<?php

session_start();
require_once ("connection.php");

$email = $_POST['email'];
$password = $_POST['password'];

$email = $conn->real_escape_string($email);
$password = $conn->real_escape_string($password);

$sql = "SELECT password FROM estudiante WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stored_password = $row['password'];

    if (password_verify($password, $stored_password)) {
        header('Location: ../index.html');
        exit();
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
} else {
    $error = "Correo o contraseña incorrectos.";
}

$stmt->close();
$conn->close();

header("Location: ../html/login.html?error=" . urlencode($error));
exit();
?>

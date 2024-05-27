<?php
require_once ("connection.php");

$username = $_POST['username'];
$password = $_POST['password'];

$username = $conn->real_escape_string($username);
$password = $conn->real_escape_string($password);

$sql = "SELECT password FROM admin WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stored_password = $row['password'];

    if (password_verify($password, $stored_password)) {
        header('Location: ../php/dashboard.php');
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
} else {
    $error = "Usuario o contraseña incorrectos.";
}

$stmt->close();
$conn->close();

header("Location: ../html/login_admin.html?error=" . urlencode($error));
exit();
?>

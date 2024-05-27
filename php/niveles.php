<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}
include 'connection.php';

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM nivel";
$result = $conn->query($query);
$niveles = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $niveles[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Niveles</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Seleccione un Nivel</h1>
        <ul class="list-group mt-3">
            <?php foreach ($niveles as $nivel): ?>
                <li class="list-group-item"><a href="escenarios.php?nivel_id=<?= $nivel['id'] ?>"><?= $nivel['num_nivel'] ?>: <?= $nivel['descripcion'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
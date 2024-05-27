<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}
include '../php/connection.php';

$escenario_id = intval($_GET['escenario_id']);
$nivel_id = intval($_GET['nivel_id']);
$query = "SELECT * FROM contexto WHERE id_escenarios = $escenario_id";
$result = $conn->query($query);
$contextos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contextos[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contextos</title>
    <link href="../cssj2/nivel1.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Seleccione un Contexto</h1>
        <ul class="list-group mt-3">
            <?php foreach ($contextos as $contexto): ?>
                <li class="list-group-item"><a href="preguntas.php?contexto_id=<?= $contexto['id'] ?>&nivel_id=<?= $nivel_id ?>"><?= $contexto['descripcion'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
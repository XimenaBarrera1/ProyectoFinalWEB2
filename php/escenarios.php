<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}
include 'connection.php';

$nivel_id = intval($_GET['nivel_id']);
$query = "SELECT * FROM escenario WHERE id_nivel = $nivel_id";
$result = $conn->query($query);
$escenarios = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $escenarios[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escenarios</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Seleccione un Escenario</h1>
        <ul class="list-group mt-3">
            <?php foreach ($escenarios as $escenario): ?>
                <li class="list-group-item"><a href="contextos.php?escenario_id=<?= $escenario['id'] ?>&nivel_id=<?= $nivel_id ?>"><?= $escenario['nombre'] ?>: <?= $escenario['descripcion'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

include '../php/connection.php';

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
   <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
    <style>
        /* Estilos adicionales si es necesario */
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="lilita-one-regular mt-5">Seleccione un Escenario</h1>
            </div>
        </div>
        <div class="row mt-4">
            <?php foreach ($escenarios as $escenario): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $escenario['nombre'] ?></h5>
                            <p class="card-text"><?= $escenario['descripcion'] ?></p>
                            <a href="contextos.php?escenario_id=<?= $escenario['id'] ?>&nivel_id=<?= $nivel_id ?>" class="btn btn-primary">Ir al Escenario</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
</body>
</html>

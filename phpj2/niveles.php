<?php
session_start();

// Verifica si la sesión del usuario no está iniciada
if (!isset($_SESSION['user_id'])) {
    header('Location: ../html/login.html'); // Redirige al usuario a la página de inicio de sesión
    exit(); // Detiene la ejecución del resto del código
}

// Incluye el archivo de conexión a la base de datos
include '../php/connection.php';

// Obtiene el ID del usuario de la sesión
$user_id = $_SESSION['user_id'];

// Realiza la consulta para obtener los niveles
$query = "SELECT * FROM nivel";
$result = $conn->query($query);

// Verifica si se encontraron resultados
if ($result->num_rows > 0) {
    // Inicializa un array para almacenar los niveles
    $niveles = [];
    
    // Itera sobre los resultados y los agrega al array de niveles
    while ($row = $result->fetch_assoc()) {
        $niveles[] = $row;
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../cssj2/juego2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
    <title>Niveles</title>
</head>
<body>
    <section id="nuestros-juegos">
        <div class="container">
            <h2>Niveles</h2>
            <div class="juegos" id="niveles-container">
                <?php if (!empty($niveles)): ?>
                    <?php foreach ($niveles as $nivel): ?>
                        <div class="juego1">
                            <a href="escenarios.php?nivel_id=<?= $nivel['id'] ?>"><?= $nivel['num_nivel'] ?>: <?= $nivel['descripcion'] ?></a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay niveles disponibles.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>
</html>

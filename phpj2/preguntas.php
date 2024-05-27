<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}
include '../php/connection.php';

$contexto_id = intval($_GET['contexto_id']);
$nivel_id = intval($_GET['nivel_id']); // Asegúrate de pasar el nivel_id en la URL

$query = "SELECT * FROM pregunta WHERE id_contexto = $contexto_id";
$result = $conn->query($query);
$preguntas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pregunta_id = $row['id'];
        $query_respuestas = "SELECT * FROM respuesta WHERE pregunta_id = $pregunta_id";
        $result_respuestas = $conn->query($query_respuestas);
        $respuestas = [];

        if ($result_respuestas->num_rows > 0) {
            while ($row_respuesta = $result_respuestas->fetch_assoc()) {
                $respuestas[] = $row_respuesta;
            }
        }
        $row['respuestas'] = $respuestas;
        $preguntas[] = $row;
    }
} else {
    echo "No se encontraron preguntas para este contexto.";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Responda las preguntas</h1>
        <form id="formulario-preguntas" method="POST" action="verificar_respuesta.php?nivel_id=<?= $nivel_id ?>" class="mt-3">
            <?php foreach ($preguntas as $pregunta): ?>
                <div class="mb-4">
                    <h4><?= htmlspecialchars($pregunta['pregunta']) ?></h4>
                    <?php foreach ($pregunta['respuestas'] as $respuesta): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="respuesta-<?= $respuesta['id'] ?>" name="pregunta-<?= $pregunta['id'] ?>" value="<?= $respuesta['id'] ?>">
                            <label class="form-check-label" for="respuesta-<?= $respuesta['id'] ?>"><?= htmlspecialchars($respuesta['descripcion_respuesta']) ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary btn-block">Enviar</button>
        </form>
    </div>
</body>
</html>
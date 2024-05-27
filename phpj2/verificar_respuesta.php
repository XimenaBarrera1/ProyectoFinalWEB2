<?php

session_start();
include '../php/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = date('Y-m-d H:i:s');
    $user_id = $_SESSION['user_id'];
    $nivel_id = intval($_GET['nivel_id']);

    if (!$nivel_id) {
        die("Error: nivel_id no definido");
    }

    $total_puntos = 0;
    $puntos_ganados = 0;
    $puntos_totales = 0;
    $num_intentos = 0;

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'pregunta-') === 0) {
            $pregunta_id = intval(str_replace('pregunta-', '', $key));
            $respuesta_id = intval($value);

            $query = "SELECT * FROM respuesta WHERE id = $respuesta_id AND pregunta_id = $pregunta_id";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $indicador_respuesta = $row['indicador_respuesta'];
                $descripcion_respuesta = $row['descripcion_respuesta'];

                $puntos = $indicador_respuesta == 1 ? 10 : 0;
                $puntos_totales += 10;

                // Insertar en la tabla puntos
                $query_insert_puntos = "INSERT INTO puntos (cantidad_puntos, id_estudiante) VALUES ($puntos, $user_id)";
                if ($conn->query($query_insert_puntos) === TRUE) {
                    $puntos_id = $conn->insert_id;

                    // Insertar en historial_de_respuestas con puntos_id
                    $query_insert_historial = "INSERT INTO historial_de_respuestas (fecha, id_respuesta, puntos_id) VALUES ('$fecha', $respuesta_id, $puntos_id)";
                    if ($conn->query($query_insert_historial) === TRUE) {
                        $historial_id = $conn->insert_id;
                        $id_respuesta_correcta = "NULL";

                        if ($indicador_respuesta == 1) {
                            // La respuesta es correcta, guardarla en respuestascorrectas
                            $query_insert_correctas = "INSERT INTO respuestascorrectas (respuesta, id_respuesta, id_historial_De_Respuestas) VALUES ('$descripcion_respuesta', $respuesta_id, $historial_id)";
                            if ($conn->query($query_insert_correctas) === TRUE) {
                                $id_respuesta_correcta = $conn->insert_id;
                                $puntos_ganados += 10;
                            } else {
                                echo "Error al guardar respuesta correcta: " . $conn->error;
                            }
                        }

                        // Insertar en historial_de_puntos
                        $query_insert_historial_puntos = "INSERT INTO historial_de_puntos (fecha, id_estudiante, id_nivel, id_puntos, id_respuestaCorrecta) VALUES ('$fecha', $user_id, $nivel_id, $puntos_id, $id_respuesta_correcta)";
                        if ($conn->query($query_insert_historial_puntos) !== TRUE) {
                            echo "Error al guardar en el historial de puntos: " . $conn->error;
                        }
                    } else {
                        echo "Error al guardar en el historial de respuestas: " . $conn->error;
                    }
                } else {
                    echo "Error al guardar en la tabla de puntos: " . $conn->error;
                }
            } else {
                echo "Respuesta no encontrada para la pregunta $pregunta_id.";
            }
        }
    }

    // Insertar en registro_intentos
    $query_insert_intentos = "INSERT INTO registro_intentos (num_intentos, fecha, id_nivel, id_historial_De_Respuestas, id_estudiante) VALUES ($num_intentos, '$fecha', $nivel_id, $historial_id, $user_id)";
    if ($conn->query($query_insert_intentos) !== TRUE) {
        echo "Error al guardar en el registro de intentos: " . $conn->error;
    }

    // Verificar si el estudiante puede avanzar al siguiente nivel
    if ($puntos_ganados >= ($puntos_totales * 0.5)) {
        echo "¡Felicidades! Has avanzado al siguiente nivel.";
        // Aquí podrías redirigir al estudiante al siguiente nivel
    } else {
        echo "Lo siento, no has conseguido suficientes puntos para avanzar al siguiente nivel.";
    }
}
$conn->close();
?>

<?php
include 'connection.php';

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_GET['nivel_id'])) {
    $nivelId = intval($_GET['nivel_id']);
    $sqlNivel = "SELECT * FROM nivel WHERE id = $nivelId";
    $resultNivel = $conn->query($sqlNivel);

    if ($resultNivel->num_rows > 0) {
        $rowNivel = $resultNivel->fetch_assoc();
        $sqlEscenarios = "SELECT * FROM escenario WHERE id_nivel = $nivelId";
        $resultEscenarios = $conn->query($sqlEscenarios);

        $escenarios = array();
        if ($resultEscenarios->num_rows > 0) {
            while ($rowEscenario = $resultEscenarios->fetch_assoc()) {
                $escenarioId = $rowEscenario['id'];
                $sqlContexto = "SELECT * FROM contexto WHERE id_escenarios = $escenarioId";
                $resultContexto = $conn->query($sqlContexto);

                $contextos = array();
                if ($resultContexto->num_rows > 0) {
                    while ($rowContexto = $resultContexto->fetch_assoc()) {
                        $contextoId = $rowContexto['id'];
                        $sqlPregunta = "SELECT * FROM pregunta WHERE id_contexto = $contextoId";
                        $resultPregunta = $conn->query($sqlPregunta);

                        $preguntas = array();
                        if ($resultPregunta->num_rows > 0) {
                            while ($rowPregunta = $resultPregunta->fetch_assoc()) {
                                $preguntaId = $rowPregunta['id'];
                                $sqlRespuesta = "SELECT * FROM respuesta WHERE pregunta_id = $preguntaId";
                                $resultRespuesta = $conn->query($sqlRespuesta);

                                $respuestas = array();
                                if ($resultRespuesta->num_rows > 0) {
                                    while ($rowRespuesta = $resultRespuesta->fetch_assoc()) {
                                        $respuestas[] = $rowRespuesta;
                                    }
                                }
                                $rowPregunta['respuestas'] = $respuestas;
                                $preguntas[] = $rowPregunta;
                            }
                        }
                        $rowContexto['preguntas'] = $preguntas;
                        $contextos[] = $rowContexto;
                    }
                    $rowEscenario['contextos'] = $contextos;
                } else {
                    $rowEscenario['contextos'] = [];
                }
                $escenarios[] = $rowEscenario;
            }
        }
        $rowNivel['escenarios'] = $escenarios;
        $nivel = $rowNivel;
    } else {
        $nivel = null;
    }

    $conn->close();
    header('Content-Type: application/json');
    echo json_encode($nivel);
} elseif (isset($_GET['escenario_id'])) {
    $escenarioId = intval($_GET['escenario_id']);
    $sqlContexto = "SELECT * FROM contexto WHERE id_escenarios = $escenarioId";
    $resultContexto = $conn->query($sqlContexto);

    $contextos = array();
    if ($resultContexto->num_rows > 0) {
        while ($rowContexto = $resultContexto->fetch_assoc()) {
            $contextoId = $rowContexto['id'];
            $sqlPregunta = "SELECT * FROM pregunta WHERE id_contexto = $contextoId";
            $resultPregunta = $conn->query($sqlPregunta);

            $preguntas = array();
            if ($resultPregunta->num_rows > 0) {
                while ($rowPregunta = $resultPregunta->fetch_assoc()) {
                    $preguntaId = $rowPregunta['id'];
                    $sqlRespuesta = "SELECT * FROM respuesta WHERE pregunta_id = $preguntaId";
                    $resultRespuesta = $conn->query($sqlRespuesta);

                    $respuestas = array();
                    if ($resultRespuesta->num_rows > 0) {
                        while ($rowRespuesta = $resultRespuesta->fetch_assoc()) {
                            $respuestas[] = $rowRespuesta;
                        }
                    }
                    $rowPregunta['respuestas'] = $respuestas;
                    $preguntas[] = $rowPregunta;
                }
            }
            $rowContexto['preguntas'] = $preguntas;
            $contextos[] = $rowContexto;
        }
    }

    $conn->close();
    header('Content-Type: application/json');
    echo json_encode($contextos);
} else {
    $sqlNiveles = "SELECT * FROM nivel";
    $resultNiveles = $conn->query($sqlNiveles);

    $niveles = array();
    if ($resultNiveles->num_rows > 0) {
        while ($rowNivel = $resultNiveles->fetch_assoc()) {
            $nivelId = $rowNivel['id'];
            $sqlEscenarios = "SELECT * FROM escenario WHERE id_nivel = $nivelId";
            $resultEscenarios = $conn->query($sqlEscenarios);

            $escenarios = array();
            if ($resultEscenarios->num_rows > 0) {
                while ($rowEscenario = $resultEscenarios->fetch_assoc()) {
                    $escenarioId = $rowEscenario['id'];
                    $sqlContexto = "SELECT * FROM contexto WHERE id_escenarios = $escenarioId";
                    $resultContexto = $conn->query($sqlContexto);

                    $contextos = array();
                    if ($resultContexto->num_rows > 0) {
                        while ($rowContexto = $resultContexto->fetch_assoc()) {
                            $contextoId = $rowContexto['id'];
                            $sqlPregunta = "SELECT * FROM pregunta WHERE id_contexto = $contextoId";
                            $resultPregunta = $conn->query($sqlPregunta);

                            $preguntas = array();
                            if ($resultPregunta->num_rows > 0) {
                                while ($rowPregunta = $resultPregunta->fetch_assoc()) {
                                    $preguntaId = $rowPregunta['id'];
                                    $sqlRespuesta = "SELECT * FROM respuesta WHERE pregunta_id = $preguntaId";
                                    $resultRespuesta = $conn->query($sqlRespuesta);

                                    $respuestas = array();
                                    if ($resultRespuesta->num_rows > 0) {
                                        while ($rowRespuesta = $resultRespuesta->fetch_assoc()) {
                                            $respuestas[] = $rowRespuesta;
                                        }
                                    }
                                    $rowPregunta['respuestas'] = $respuestas;
                                    $preguntas[] = $rowPregunta;
                                }
                            }
                            $rowContexto['preguntas'] = $preguntas;
                            $contextos[] = $rowContexto;
                        }
                        $rowEscenario['contextos'] = $contextos;
                    } else {
                        $rowEscenario['contextos'] = [];
                    }
                    $escenarios[] = $rowEscenario;
                }
            }
            $rowNivel['escenarios'] = $escenarios;
            $niveles[] = $rowNivel;
        }
    }

    $conn->close();
    header('Content-Type: application/json');
    echo json_encode($niveles);
}
?>

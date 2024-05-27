<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<script src="../js/admin.js"></script>
<body>
    <div class="sidebar">
        <ul>
            <li><a href="#">Panel</a></li>
            <li><a href="dashboard.php">Estudiantes</a></li>
            <li><a href="admin.php" >Juego2</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="header">
            <h2>Panel de Administrador</h2>
            <button>Cerrar sesión</button>
        </div>

        <div class="main">
            <div class="container">
                <h2>Lista de Estudiantes</h2>
                <?php
                require_once ('connection.php');

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
                    $delete_id = intval($_POST['delete_id']);

                    $sql_delete = "DELETE FROM estudiante WHERE id = $delete_id";
                    if ($conn->query($sql_delete) === TRUE) {
                        echo "Estudiante eliminado con éxito.";
                    } else {
                        echo "Error eliminando estudiante: " . $conn->error;
                    }
                    header("Location: {$_SERVER['PHP_SELF']}");
                    exit();
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
                    $update_id = intval($_POST['update_id']);
                    $nombre = $_POST['nombre'];
                    $apellidos = $_POST['apellidos'];
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $edad = intval($_POST['edad']);
                    $id_nivel = intval($_POST['id_nivel']);

                    $sql_update = "UPDATE estudiante SET 
                       nombre='$nombre', apellidos='$apellidos', username='$username', 
                       email='$email', password='$password', edad=$edad, id_nivel=$id_nivel 
                       WHERE id = $update_id";
                    if ($conn->query($sql_update) === TRUE) {
                        echo "Estudiante actualizado con éxito.";
                    } else {
                        echo "Error actualizando estudiante: " . $conn->error;
                    }
                    header("Location: {$_SERVER['PHP_SELF']}");
                    exit();
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
                    $nombre = $_POST['nombre'];
                    $apellidos = $_POST['apellidos'];
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $edad = intval($_POST['edad']);
                    $id_nivel = intval($_POST['id_nivel']);

                    $sql_insert = "INSERT INTO estudiante (nombre, apellidos, username, email, password, edad, id_nivel) 
                       VALUES ('$nombre', '$apellidos', '$username', '$email', '$password', $edad, $id_nivel)";
                    if ($conn->query($sql_insert) === TRUE) {
                        echo "Estudiante añadido con éxito.";
                    } else {
                        echo "Error añadiendo estudiante: " . $conn->error;
                    }
                    header("Location: {$_SERVER['PHP_SELF']}");
                    exit();
                }

                $sql = "SELECT * FROM estudiante";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Edad</th>
                    <th>ID Nivel</th>
                    <th>Acción</th>
                </tr>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr id='row_" . $row["id"] . "'>
                    <form method='POST'>
                        <td>" . $row["id"] . "</td>
                        <td><input type='text' name='nombre' value='" . $row["nombre"] . "' disabled></td>
                        <td><input type='text' name='apellidos' value='" . $row["apellidos"] . "' disabled></td>
                        <td><input type='text' name='username' value='" . $row["username"] . "' disabled></td>
                        <td><input type='text' name='email' value='" . $row["email"] . "' disabled></td>
                        <td><input type='password' name='password' value='" . $row["password"] . "' disabled></td>
                        <td><input type='number' name='edad' value='" . $row["edad"] . "' disabled></td>
                        <td><input type='number' name='id_nivel' value='" . $row["id_nivel"] . "' disabled></td>
                        <td>
                            <input type='hidden' name='update_id' value='" . $row["id"] . "'>
                            <input type='button' value='Actualizar' onclick='enableEditing(" . $row["id"] . ")'>
                            <input type='submit' value='Guardar' style='display:none' id='save_" . $row["id"] . "'>
                            <input type='button' value='Eliminar' onclick='confirmDeletion(" . $row["id"] . ")'>
                        </td>
                    </form>
                  </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "0 resultados";
                }
                ?>

                <button onclick="showAddStudentForm()">Añadir</button>

                <form method='POST' onsubmit='return validateNewStudentForm();' id='add_student_form'>
                    <h3 class="form-title">Añadir nuevo estudiante</h3>
                    <table>
                        <tr>
                            <td>Nombre:</td>
                            <td><input type='text' name='nombre' id='new_nombre'></td>
                        </tr>
                        <tr>
                            <td>Apellidos:</td>
                            <td><input type='text' name='apellidos' id='new_apellidos'></td>
                        </tr>
                        <tr>
                            <td>Username:</td>
                            <td><input type='text' name='username' id='new_username'></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><input type='text' name='email' id='new_email'></td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><input type='password' name='password' id='new_password'></td>
                        </tr>
                        <tr>
                            <td>Edad:</td>
                            <td><input type='number' name='edad' id='new_edad'></td>
                        </tr>
                        <tr>
                            <td>ID Nivel:</td>
                            <td><input type='number' name='id_nivel' id='new_id_nivel'></td>
                        </tr>
                    </table>
                    <input type='hidden' name='add_student' value='1'>
                    <input type='submit' value='Guardar' id='add_student_btn' disabled>
                </form>
            </div>

            <script>
                function enableEditing(id) {
                    document.querySelectorAll("#row_" + id + " input[type='text'], #row_" + id + " input[type='number'], #row_" + id + " input[type='email'], #row_" + id + " input[type='password']").forEach(function (input) {
                        input.disabled = false;
                    });
                    document.getElementById("save_" + id).style.display = "inline";
                }

                function confirmDeletion(id) {
                    if (confirm("¿Está seguro de que desea eliminar este estudiante?")) {
                        var form = document.createElement("form");
                        form.method = "POST";
                        form.innerHTML = "<input type='hidden' name='delete_id' value='" + id + "'>";
                        document.body.appendChild(form);
                        form.submit();
                    }
                }

                function showAddStudentForm() {
                    document.getElementById("add_student_form").style.display = "block";
                }

                document.getElementById('add_student_form').addEventListener('input', function () {
                    var nombre = document.getElementById('new_nombre').value;
                    var apellidos = document.getElementById('new_apellidos').value;
                    var username = document.getElementById('new_username').value;
                    var email = document.getElementById('new_email').value;
                    var password = document.getElementById('new_password').value;
                    var edad = document.getElementById('new_edad').value;
                    var id_nivel = document.getElementById('new_id_nivel').value;

                    var addStudentBtn = document.getElementById('add_student_btn');
                    if (nombre && apellidos && username && email && password && edad && id_nivel) {
                        addStudentBtn.disabled = false;
                    } else {
                        addStudentBtn.disabled = true;
                    }
                });
            </script>
        </div>
    </div>
</body>

</html>
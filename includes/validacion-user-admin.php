<?php
include('../config/db.php');
?>

<div class="error-form">

    <?php
    // Verificar si el usuario es un administrador
    if ($_SESSION['rol'] !== 'admin') {
        header("Location: login.php");
        exit();
    }

    // Lógica para crear y eliminar usuarios
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        if ($accion === 'crear') {
            // Validar y procesar la creación de un usuario
            $nombre = $_POST['nombre'] ?? '';
            $apellidos = $_POST['apellidos'] ?? '';
            $email = $_POST['email'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $sexo = $_POST['sexo'] ?? '';
            $passw1 = $_POST['passw1'] ?? '';
            $passw2 = $_POST['passw2'] ?? '';
            $rol = $_POST['rol'] ?? '';  // Recoger el rol desde el formulario

            // Validar los campos obligatorios
            if (empty($nombre) || empty($apellidos) || empty($email) || empty($telefono) || empty($fecha_nacimiento) || empty($direccion) || empty($sexo) || empty($passw1) || empty($passw2) || empty($rol)) {
                echo "<p class='container alert alert-danger'>Todos los campos son obligatorios.</p>";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<p class='container alert alert-danger'>El email es inválido.</p>";
            } elseif ($passw1 !== $passw2) {
                echo "<p class='container alert alert-danger'>Las contraseñas no coinciden.</p>";
            } // Validar requisitos de la contraseña
            elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/", $passw1)) {
                echo "<p class='container alert alert-danger'>La contraseña debe tener al menos 8 caracteres, incluir una mayúscula, una minúscula, un número y un carácter especial.</p>";
            } else {
                // Verificar si el email ya existe en la base de datos
                $emailCheckQuery = $conn->prepare("SELECT * FROM users_login WHERE usuario = ?");
                $emailCheckQuery->bind_param("s", $email);
                $emailCheckQuery->execute();
                $result = $emailCheckQuery->get_result();

                if ($result->num_rows > 0) {
                    echo "<p class='container alert alert-danger'>El email ya está registrado.</p>";
                } else {
                    // Insertar el nuevo usuario en la tabla `USERS_DATA`
                    $sql = $conn->prepare("INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $sql->bind_param("sssssss", $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo);

                    if ($sql->execute()) {
                        // Obtener el último ID generado para el nuevo usuario
                        $idUser = $conn->insert_id;

                        // Insertar las credenciales en la tabla `USERS_LOGIN`
                        $hashed_password = password_hash($passw1, PASSWORD_DEFAULT);
                        $sqlUser = $conn->prepare("INSERT INTO users_login (idUser, usuario, password, rol) VALUES (?, ?, ?, ?)");
                        $sqlUser->bind_param("isss", $idUser, $email, $hashed_password, $rol);

                        if ($sqlUser->execute()) {
                            echo "<p class='container alert alert-success'>Usuario creado con éxito.</p>";
                        } else {
                            echo "<p class='container alert alert-danger'>Error al registrar el usuario en USERS_LOGIN: " . $sqlUser->error . "</p>";
                        }

                        $sqlUser->close();
                    } else {
                        echo "<p class='container alert alert-danger'>Error al crear el usuario en USERS_DATA: " . $sql->error . "</p>";
                    }

                    $sql->close();
                }

                $emailCheckQuery->close();
            }
        } elseif ($accion === 'eliminar') {
            // Validar y procesar la eliminación de un usuario
            $email = $_POST['email'] ?? '';

            if (empty($email)) {
                echo "<p class='container alert alert-danger'>El email es obligatorio para eliminar un usuario.</p>";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<p class='container alert alert-danger'>El email es inválido.</p>";
            } else {
                // Verificar si el usuario existe
                $emailCheckQuery = $conn->prepare("SELECT * FROM users_data WHERE email = ?");
                $emailCheckQuery->bind_param("s", $email);
                $emailCheckQuery->execute();
                $result = $emailCheckQuery->get_result();

                if ($result->num_rows > 0) {
                    // Eliminar el usuario
                    $deleteUserQuery = $conn->prepare("DELETE FROM users_data WHERE email = ?");
                    $deleteUserQuery->bind_param("s", $email);

                    if ($deleteUserQuery->execute()) {
                        echo "<p class='container alert alert-success'>Usuario eliminado con éxito.</p>";
                    } else {
                        echo "<p class='container alert alert-danger'>Error al eliminar el usuario: " . $deleteUserQuery->error . "</p>";
                    }

                    $deleteUserQuery->close();
                } else {
                    echo "<p class='container alert alert-danger'>El usuario no existe.</p>";
                }

                $emailCheckQuery->close();
            }
        } elseif ($accion === 'editar') {
            // Capturar los datos del formulario de edición
            $idUser = $_POST['idUser'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $apellidos = $_POST['apellidos'] ?? '';
            $email = $_POST['email'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $sexo = $_POST['sexo'] ?? '';

            // Validar los datos
            if (empty($nombre) || empty($apellidos) || empty($email)) {
                echo "<p class='container alert alert-danger'>Todos los campos son obligatorios.</p>";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<p class='container alert alert-danger'>El email es inválido.</p>";
            } else {
                // Actualizar el usuario en la base de datos
                $sql = $conn->prepare("UPDATE users_data SET nombre = ?, apellidos = ?, email = ?, telefono = ?, fecha_nacimiento = ?, direccion = ?, sexo = ? WHERE idUser = ?");
                $sql->bind_param("sssssssi", $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $idUser);
                if ($sql->execute()) {
                    echo "<p class='container alert alert-success'>Usuario actualizado con éxito.</p>";
                } else {
                    echo "<p class='container alert alert-danger'>Error al actualizar el usuario: " . $sql->error . "</p>";
                }
                $sql->close();
            }
        }
    }
    ?>

</div>
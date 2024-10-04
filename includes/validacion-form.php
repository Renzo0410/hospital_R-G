<?php include('../config/db.php'); ?>

<div class="container error-form">
    <?php

    // Obtener la acción del formulario
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';

    if (isset($_POST['submit'])) {
        $errorMessage = ''; // Variable para almacenar mensajes de error

        if ($accion === 'registrar') {
            // DATOS PERSONALES
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
            $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
            $fechaNacimiento = isset($_POST['fechaNacimiento']) ? $_POST['fechaNacimiento'] : '';
            $paisNac = isset($_POST['paisnac']) ? $_POST['paisnac'] : 'select';
            $tipoDocumento = isset($_POST['tipodocumento']) ? $_POST['tipodocumento'] : '';
            $numDocumento = isset($_POST['numDocumento']) ? $_POST['numDocumento'] : '';
            $sexo = isset($_POST['sexo']) ? $_POST['sexo'] : '';

            // DATOS DE CONTACTO
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $numPhone = isset($_POST['numPhone']) ? $_POST['numPhone'] : '';
            $via = isset($_POST['via']) ? $_POST['via'] : '';
            $nameVia = isset($_POST['nameVia']) ? $_POST['nameVia'] : '';
            $numVia = isset($_POST['numVia']) ? $_POST['numVia'] : '';
            $numPisoVia = isset($_POST['numPisoVia']) ? $_POST['numPisoVia'] : '';
            $letraVia = isset($_POST['letraVia']) ? $_POST['letraVia'] : '';
            $paisRes = isset($_POST['paisres']) ? $_POST['paisres'] : '';
            $codigoPostal = isset($_POST['codigoPostal']) ? $_POST['codigoPostal'] : '';
            $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : '';
            $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : '';

            // PASSWORD
            $passw1 = isset($_POST['passw1']) ? $_POST['passw1'] : '';
            $passw2 = isset($_POST['passw2']) ? $_POST['passw2'] : '';

            // CONSENTIMIENTO
            $consentimiento = isset($_POST['consentimiento']) ? $_POST['consentimiento'] : '';

            //------------------------------------------------------

            // DATOS PERSONALES
            if (empty($nombre) || empty($apellidos) || empty($fechaNacimiento) || empty($paisNac) || empty($tipoDocumento) || empty($numDocumento) || empty($sexo) || empty($email) || empty($numPhone) || empty($via) || empty($nameVia) || empty($numVia) || empty($paisRes) || empty($codigoPostal) || empty($localidad) || empty($provincia) || empty($passw1) || empty($passw2) || !isset($_POST['consentimiento'])) {
                $errorMessage = "<div class='container alert alert-danger'>Los campos con *(asterisco) son OBLIGATORIOS.</div>";
            } else {
                // Validar nombre
                if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
                    $errorMessage = "<div class='container alert alert-danger'>El nombre solo debe contener letras y espacios.</div>";
                }

                // Validar apellidos
                elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $apellidos)) {
                    $errorMessage = "<div class='container alert alert-danger'>Los apellidos solo deben contener letras y espacios.</div>";
                }

                // Validar email
                elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errorMessage = "<div class='container alert alert-danger'>El email es inválido.</div>";
                }

                // Validar contraseñas
                elseif ($passw1 !== $passw2) {
                    $errorMessage = "<div class='container alert alert-danger'>Las contraseñas no coinciden.</div>";
                }

                // Validar requisitos de la contraseña
                elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/", $passw1)) {
                    $errorMessage = "<div class='container alert alert-danger'>La contraseña debe tener al menos 8 caracteres, incluir una mayúscula, una minúscula, un número y un carácter especial.</div>";
                }

                // Si todas las validaciones son correctas
                else {

                    if (empty($errorMessage)) {
                        // Verificar si la conexión es exitosa
                        if ($conn->connect_error) {
                            die("Conexión fallida: " . $conn->connect_error);
                        }

                        // Convertir el valor de sexo a "M", "F" o "OTRO"
                        switch ($sexo) {
                            case 'masculino':
                                $sexo = 'M';
                                break;
                            case 'femenino':
                                $sexo = 'F';
                                break;
                            case 'otro':
                                $sexo = 'OTRO';
                                break;
                            default:
                                $sexo = 'OTRO';
                                break;
                        }

                        // Capturar los datos del formulario (previniendo SQL Injection)
                        $nombre = $conn->real_escape_string($_POST['nombre']);
                        $apellidos = $conn->real_escape_string($_POST['apellidos']);
                        $email = $conn->real_escape_string($_POST['email']);
                        $telefono = $conn->real_escape_string($_POST['numPhone']);
                        $fecha_nacimiento = $conn->real_escape_string($_POST['fechaNacimiento']);
                        $direccion = $conn->real_escape_string($_POST['nameVia'] . ' ' . $_POST['numVia'] . ' ' . $_POST['numPisoVia'] . ' ' . $_POST['letraVia']);

                        // Verificar si el email ya existe
                        $emailCheckQuery = $conn->prepare("SELECT * FROM users_data WHERE email = ?");
                        $emailCheckQuery->bind_param("s", $email);
                        $emailCheckQuery->execute();
                        $result = $emailCheckQuery->get_result();

                        if ($result->num_rows > 0) {
                            $errorMessage = "<div class='container alert alert-danger'>El email ya está registrado. Por favor, utilice otro correo.</div>";
                        } else {
                            // Insertar en la tabla USERS_DATA
                            $sql = $conn->prepare("INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) VALUES (?, ?, ?, ?, ?, ?, ?)");
                            $sql->bind_param("sssssss", $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo);

                            if ($sql->execute()) {
                                // Obtener el último id insertado en USERS_DATA
                                $idUser = $conn->insert_id;

                                // Encriptar la contraseña
                                $passwordHash = password_hash($passw1, PASSWORD_DEFAULT);
                                $rol = "user"; // Asignar un rol por defecto, puede ser dinámico si lo necesitas

                                // Insertar en la tabla USERS_LOGIN
                                $loginSql = $conn->prepare("INSERT INTO users_login (idUser, usuario, password, rol) VALUES (?, ?, ?, ?)");
                                $loginSql->bind_param("isss", $idUser, $email, $passwordHash, $rol);

                                if ($loginSql->execute()) {
                                    // Mensaje de éxito en registro
                                    echo '
                                <div class="alert alert-success" role="alert" id="success-message">
                                    ¡Usuario registrado con éxito!...
                                </div>
                                <script>
                                    // Mostrar el mensaje por 5 segundos y luego redirigir al login
                                    setTimeout(function() {
                                        window.location.href = "login.php";
                                    }, 5000); // 5000 milisegundos = 5 segundos
                                </script>';
                                } else {
                                    $errorMessage = "Error al registrar el usuario en USERS_LOGIN: " . $loginSql->error;
                                }

                                $loginSql->close();
                            } else {
                                $errorMessage = "Error al registrar datos personales: " . $sql->error;
                            }

                            $sql->close();
                        }

                        $emailCheckQuery->close();
                    }
                }
            }
        }
    }
    ?>
</div>
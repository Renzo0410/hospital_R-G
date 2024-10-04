<div class="container error-form">
    <?php
    // Verificar si el usuario es un administrador
    if ($_SESSION['rol'] !== 'admin') {
        header("Location: login.php");
        exit();
    }

    // Obtener la fecha actual en formato YYYY-MM-DD
    $fecha_actual = date('Y-m-d');

    // Procesar agregar cita
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
        // Obtener el ID del usuario seleccionado desde el formulario
        $idUser = $conn->real_escape_string($_POST['id_usuario']); // Cambiado aquí
        $fecha_cita = $conn->real_escape_string($_POST['fecha_cita']);
        $motivo_cita = $conn->real_escape_string($_POST['motivo_cita']);

        // Verificar que la fecha_cita no sea anterior a la fecha actual
        if ($fecha_cita < $fecha_actual) {
            echo "Error: No se pueden agendar citas en fechas pasadas.";
        } else {
            $query = "INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES ('$idUser', '$fecha_cita', '$motivo_cita')";

            if ($conn->query($query) === TRUE) {
                // Redirigir para evitar duplicación (Patrón PRG)
                header("Location: citas-administracion.php");
                exit(); // Asegurarse de detener la ejecución del script tras la redirección
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }

    // Procesar eliminación de cita
    if (isset($_POST['eliminar'])) {
        $idCita = $conn->real_escape_string($_POST['idCita']);
        $query = "DELETE FROM citas WHERE idCita = '$idCita'";

        if ($conn->query($query) === TRUE) {
            // Redirigir para evitar duplicación (Patrón PRG)
            header("Location: citas-administracion.php");
            exit();
        } else {
            echo "Error al eliminar la cita: " . $conn->error;
        }
    }

    // Procesar edición de cita
    if (isset($_POST['guardarEdicion'])) {
        $idCita = $conn->real_escape_string($_POST['idCita']);
        $fecha_cita = $conn->real_escape_string($_POST['fecha_cita']);
        $motivo_cita = $conn->real_escape_string($_POST['motivo_cita']);

        // Verificar que la fecha_cita no sea anterior a la fecha actual
        if ($fecha_cita < $fecha_actual) {
            echo "Error: No se pueden editar citas a fechas pasadas.";
        } else {
            $query = "UPDATE citas SET fecha_cita='$fecha_cita', motivo_cita='$motivo_cita' WHERE idCita='$idCita'";

            if ($conn->query($query) === TRUE) {
                // Redirigir para evitar duplicación (Patrón PRG)
                header("Location: citas-administracion.php");
                exit();
            } else {
                echo "Error al actualizar la cita: " . $conn->error;
            }
        }
    }

    // Obtener todas las citas con el nombre del usuario al que pertenecen
    $query = "SELECT c.idCita, c.fecha_cita, c.motivo_cita, u.nombre AS usuario 
    FROM citas c 
    JOIN users_data u ON c.idUser = u.idUser 
    ORDER BY c.fecha_cita";
    $result = $conn->query($query);

    ?>
</div>
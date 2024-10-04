<div class="container error-form">
    <?php
    // Mostrar mensajes de éxito o error
    if (isset($_GET['success'])) {
        echo '<div class="alert alert-success">Cita agendada exitosamente.</div>';
    }

    if (isset($_GET['deleted'])) {
        echo '<div class="alert alert-success">Cita eliminada exitosamente.</div>';
    }

    if (isset($_GET['updated'])) {
        echo '<div class="alert alert-success">Cita actualizada exitosamente.</div>';
    }

    // Procesar agendar cita
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agendar'])) {
        $fecha_cita = $conn->real_escape_string($_POST['fecha_cita']);
        $motivo_cita = $conn->real_escape_string($_POST['motivo_cita']);

        // Verificar que la fecha_cita no sea anterior a la fecha actual
        if ($fecha_cita < $fecha_actual) {
            echo "Error: No se pueden agendar citas en fechas pasadas.";
        } else {
            $query = "INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES ('$idUser', '$fecha_cita', '$motivo_cita')";

            if ($conn->query($query) === TRUE) {
                // Después de agendar la cita, redirigir para evitar duplicación en caso de recarga
                header("Location: citas.php?success=true");
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }

    // Procesar eliminación de cita
    if (isset($_POST['eliminar'])) {
        $idCita = $conn->real_escape_string($_POST['idCita']);
        $query = "DELETE FROM citas WHERE idCita = '$idCita' AND idUser = '$idUser'";  // Asegurar que solo elimina sus propias citas

        if ($conn->query($query) === TRUE) {
            header("Location: citas.php?deleted=true");
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
            $query = "UPDATE citas SET fecha_cita='$fecha_cita', motivo_cita='$motivo_cita' WHERE idCita='$idCita' AND idUser = '$idUser'";  // Asegurar que solo edita sus propias citas

            if ($conn->query($query) === TRUE) {
                header("Location: citas.php?updated=true");
                exit();
            } else {
                echo "Error al actualizar la cita: " . $conn->error;
            }
        }
    }

    // Obtener las citas del usuario logueado
    $query = "SELECT * FROM citas 
    WHERE idUser = '$idUser' 
    ORDER BY fecha_cita";
    $result = $conn->query($query);
    ?>
</div>
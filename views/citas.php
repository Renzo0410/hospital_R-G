<?php
require('../layout/header.php');
include('../config/db.php');

// Obtener el ID del usuario logueado
$idUser = $_SESSION['idUser'];

// Obtener la fecha actual en formato YYYY-MM-DD
$fecha_actual = date('Y-m-d');
?>

<?php
include('../includes/validacion-citas.php');
?>

<main class="container">
    <hr>
    <h1>Citas</h1>
    <hr>

    <form action="citas.php" method="POST">
        <div class="mb-3">
            <label for="fecha_cita" class="form-label">Fecha de la Cita</label>
            <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" required min="<?php echo $fecha_actual; ?>">
        </div>
        <div class="mb-3">
            <label for="motivo_cita" class="form-label">Motivo de la Cita</label>
            <input type="text" class="form-control" id="motivo_cita" name="motivo_cita" required>
        </div>
        <button type="submit" class="btn btn-primary" name="agendar">Agendar Cita</button>
    </form>

    <hr>

    <h3>Tus Citas</h3>
    <div class="list-group">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="list-group-item">
                    <h5><?php echo htmlspecialchars($row['motivo_cita']); ?></h5>
                    <p>Fecha: <?php echo date("d/m/Y", strtotime($row['fecha_cita'])); ?></p>

                    <!-- Formulario para eliminar cita -->
                    <form action="citas.php" method="POST" style="display:inline;">
                        <input type="hidden" name="idCita" value="<?php echo $row['idCita']; ?>">
                        <button type="submit" class="btn btn-danger" name="eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta cita?');">Eliminar</button>
                    </form>

                    <!-- Botón para abrir el modal de edición -->
                    <button type="button" class="btn btn-warning" onclick="openEditModal(<?php echo $row['idCita']; ?>, '<?php echo htmlspecialchars($row['motivo_cita']); ?>', '<?php echo date('Y-m-d', strtotime($row['fecha_cita'])); ?>')">Editar</button>
                </div>
        <?php
            }
        } else {
            echo "<p>No tienes citas agendadas.</p>";
        }
        ?>

        <!-- Modal para editar cita -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="citas.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Editar Cita</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="idCita" id="editIdCita" value="">
                            <div class="mb-3">
                                <label for="edit_fecha_cita" class="form-label">Fecha de la Cita</label>
                                <input type="date" class="form-control" id="edit_fecha_cita" name="fecha_cita" required min="<?php echo $fecha_actual; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="edit_motivo_cita" class="form-label">Motivo de la Cita</label>
                                <input type="text" class="form-control" id="edit_motivo_cita" name="motivo_cita" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" name="guardarEdicion">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require('../layout/footer.php'); ?>
    <?php
    require('../layout/header.php');
    include('../config/db.php');
    ?>

    <?php
    include('../includes/validacion-citas-admin.php');
    ?>

    <div class="container">

        <hr>
        <h2>Citas a otros usuarios</h2>
        <hr>

        <?php
        // Consulta para obtener todos los usuarios
        $sqlUsuarios = "SELECT idUser, nombre FROM users_data";
        $resultUsuarios = $conn->query($sqlUsuarios);
        ?>

        <form action="citas-administracion.php" method="POST">
            <div class="mb-3">
                <label for="id_usuario" class="form-label">Seleccionar Usuario</label>
                <select class="form-control" id="id_usuario" name="id_usuario" required>
                    <option value="">Selecciona un usuario</option>
                    <?php while ($rowUsuario = $resultUsuarios->fetch_assoc()) { ?>
                        <option value="<?php echo $rowUsuario['idUser']; ?>"><?php echo htmlspecialchars($rowUsuario['nombre']); ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha_cita" class="form-label">Fecha de la Cita</label>
                <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" required min="<?php echo $fecha_actual; ?>">
            </div>
            <div class="mb-3">
                <label for="motivo_cita" class="form-label">Motivo de la Cita</label>
                <input type="text" class="form-control" id="motivo_cita" name="motivo_cita" required>
            </div>
            <button type="submit" class="btn btn-primary" name="agregar">Agregar Cita</button>
        </form>

        <hr>
        <h3>Listado de Citas</h3>
        <hr>

        <div class="list-group">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="list-group-item">
                        <h5><?php echo htmlspecialchars($row['motivo_cita']); ?></h5>
                        <!-- Mostrar el nombre del usuario al que pertenece la cita -->
                        <p>Fecha: <?php echo date("d/m/Y", strtotime($row['fecha_cita'])); ?> | Usuario: <?php echo htmlspecialchars($row['usuario']); ?></p>

                        <!-- Formulario para eliminar cita -->
                        <form action="citas-administracion.php" method="POST" style="display:inline;">
                            <input type="hidden" name="idCita" value="<?php echo $row['idCita']; ?>">
                            <button type="submit" class="btn btn-danger" name="eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta cita?');">Eliminar</button>
                        </form>

                        <!-- Formulario para editar cita -->
                        <form action="citas-administracion.php" method="POST" style="display:inline;">
                            <input type="hidden" name="idCita" value="<?php echo $row['idCita']; ?>">
                            <input type="hidden" name="motivo_cita" value="<?php echo htmlspecialchars($row['motivo_cita']); ?>">
                            <input type="hidden" name="fecha_cita" value="<?php echo date("Y-m-d", strtotime($row['fecha_cita'])); ?>">
                            <button type="button" class="btn btn-warning" onclick="openEditModal(<?php echo $row['idCita']; ?>, '<?php echo htmlspecialchars($row['motivo_cita']); ?>', '<?php echo date('Y-m-d', strtotime($row['fecha_cita'])); ?>')">Editar</button>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo "<p>No hay citas disponibles.</p>";
            }
            ?>
        </div>


    </div>

    <!-- Modal para editar cita -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="citas-administracion.php" method="POST">
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

    <?php require('../layout/footer.php') ?>
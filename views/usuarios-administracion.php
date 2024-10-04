<?php
include '../config/db.php';
require('../layout/header.php');
?>

<?php
include('../includes/validacion-user-admin.php');
?>

<div class="container c-admin-user">

    <hr>
    <h2>Administración De Usuarios</h2>
    <hr>

    <!-- Formulario para crear usuario -->
    <div class="form-create-user">
        <h5>Crear usuarios nuevos</h5>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <input type="hidden" name="accion" value="crear">
            <div class="row">
                <div class="col-md-6 col-12">
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php echo isset($nombre) ? htmlspecialchars($nombre) : ''; ?>">
                </div>
                <div class="col-md-6 col-12">
                    <input type="text" class="form-control" name="apellidos" placeholder="Apellidos" value="<?php echo isset($apellidos) ? htmlspecialchars($apellidos) : ''; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-12">
                    <input type="tel" class="form-control" name="telefono" placeholder="Teléfono" value="<?php echo isset($telefono) ? htmlspecialchars($telefono) : ''; ?>">
                </div>
                <div class="col-md-6 col-12">
                    <input type="date" class="form-control" name="fecha_nacimiento" placeholder="Fecha de Nacimiento" value="<?php echo isset($fecha_nacimiento) ? htmlspecialchars($fecha_nacimiento) : ''; ?>">
                </div>
            </div>
            <input type="text" class="form-control" name="direccion" placeholder="Dirección" value="<?php echo isset($direccion) ? htmlspecialchars($direccion) : ''; ?>">
            <input type="email" class="form-control" name="email" placeholder="Correo electrónico" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="input-group">
                        <input type="password" class="form-control" name="passw1" id="passw1" placeholder="Contraseña" value="<?php echo isset($passw1) ? htmlspecialchars($passw1) : ''; ?>">
                        <button class="form-control btn btn-outline-secondary" type="button" id="togglePassw1">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="input-group">
                        <input type="password" class="form-control" name="passw2" id="passw2" placeholder="Repetir contraseña" value="<?php echo isset($passw2) ? htmlspecialchars($passw2) : ''; ?>">
                        <button class="form-control btn btn-outline-secondary" type="button" id="togglePassw2">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-6">
                    <select class="form-control" name="sexo">
                        <option value="M" <?php echo isset($sexo) && $sexo == 'M' ? 'selected' : ''; ?>>Masculino</option>
                        <option value="F" <?php echo isset($sexo) && $sexo == 'F' ? 'selected' : ''; ?>>Femenino</option>
                        <option value="O" <?php echo isset($sexo) && $sexo == 'O' ? 'selected' : ''; ?>>Otro</option>
                    </select>
                </div>
                <div class="col-md-4 col-6">
                    <select class="select-rol" name="rol">
                        <option value="user" <?php echo isset($rol) && $rol == 'user' ? 'selected' : ''; ?>>Usuario</option>
                        <option value="admin" <?php echo isset($rol) && $rol == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                    </select>
                </div>
                <div class="col-md-4 col-12">
                    <button class="btn btn-primary" type="submit">Crear Usuario</button>
                </div>
            </div>
        </form>
    </div>

    <hr>

    <!-- Formulario para eliminar usuario -->
    <div class="form-delete-user">
        <h5>Eliminar usuarios</h5>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <input type="hidden" name="accion" value="eliminar">
            <div class="row">
                <div class="col-md-8 col-12">
                    <input class="form-control" type="email" name="email" placeholder="Correo electrónico del usuario a eliminar">
                </div>
                <div class="col-md-4 col-12">
                    <button class="btn btn-primary" type="submit">Eliminar Usuario</button>
                </div>
            </div>
        </form>
    </div>

    <hr>

    <!-- Edición de usuarios -->
    <div class="container container-edit-user">
        <h5>Edición de usuarios</h5>
        <div class="edit-user">
            <!-- Encabezado de la tabla -->
            <div class="table-user row">
                <div class="list-users fila-user-edit title-list-users col-6">Nombre</div>
                <div class="list-users fila-user-edit title-list-users col-6">Acción</div>
            </div>
            <?php
            include('../includes/edicion-user-admin.php');
            ?>
        </div>
    </div>


</div>

<?php require('../layout/footer.php'); ?>
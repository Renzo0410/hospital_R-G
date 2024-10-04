<?php
include '../config/db.php';
require('../layout/header.php');

// Obtener el ID del usuario logueado desde la sesión
$idUser = $_SESSION['idUser'];

// Obtener los datos del usuario desde la base de datos
$stmt = $conn->prepare("SELECT * FROM users_data WHERE idUser = ?");
$stmt->bind_param("i", $idUser);
$stmt->execute();
$userData = $stmt->get_result()->fetch_assoc();

// Formatear la fecha de nacimiento si es necesario
$fechaNacimiento = date('Y-m-d', strtotime($userData['fecha_nacimiento']));

// Ruta de la imagen de perfil
$profileImage = !empty($userData['profile_image']) ? '../img/avatar/' . $userData['profile_image'] : '../img/avatar/default.jpg';
?>

<main class="container container-perfil">
    <hr>
    <h2>Perfil de Usuario</h2>
    <hr>

    <?php
    include('../includes/validacion-perfil.php');
    ?>

    <!-- Mostrar la imagen de perfil -->
    <div class="row">
        <!-- c-img-p = Container Img Perfil -->
        <div class="col-lg-4 col-12 mb-3 text-center c-img-p">
            <img class="img-perfil img-fluid" src="<?php echo htmlspecialchars($profileImage); ?>" alt="Imagen de Perfil">
        </div>
        <div class="container-info-perfil col-lg-8 col-12">
            <form action="../includes/update_profile.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <!-- Campo para subir nueva imagen de perfil -->
                    <label for="profileImage">Actualizar Imagen de Perfil</label>
                    <input type="file" class="form-control" id="profileImage" name="profileImage">

                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($userData['nombre']); ?>">

                    <label for="apellidos">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($userData['apellidos']); ?>">

                    <label for="fechanacimiento">Fecha de nacimiento</label>
                    <input type="date" class="form-control" id="fechanacimiento" name="fechaNacimiento" value="<?php echo htmlspecialchars($fechaNacimiento); ?>">

                    <label for="email">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" readonly>

                    <label for="telefono">Teléfono móvil</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($userData['telefono']); ?>">

                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($userData['direccion']); ?>">

                    <!-- Campos para cambiar la contraseña -->
                    <hr>
                    <h4>Cambiar Contraseña</h4>
                    <label for="currentPassword">Contraseña Actual</label>
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword">

                    <label for="newPassword">Nueva Contraseña</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword">

                    <label for="confirmPassword">Confirmar Nueva Contraseña</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                </div>
                <button type="submit" class="btn btn-primary">Actualizar datos</button>
            </form>
        </div>
    </div>
</main>

<?php require('../layout/footer.php'); ?>
<?php include('../config/db.php'); ?>
<?php require('../layout/header.php') ?>

<?php include('../includes/validacion-form.php'); ?>

<!-- c_form = Container Fomulario -->
<main class="container c_form">

    <hr>
    <h2>Registro de nuevos usuarios en el portal del paciente</h2>
    <hr>

    <!-- text1-r = Texto 1 Registro -->
    <p class="text1-r">Regístrese para gestionar sus citas online y disfrute de las ventajas de ser usuario de R&G Salud</p>

    <!-- text2-r = Texto 2 Registro -->
    <p class="text2-r"><i class="bi bi-exclamation-circle-fill"></i> Los campos marcados con <span>*</span>(asterisco) son <span>obligatorios</span></p>


    <?php
    if (isset($errorMessage) && !empty($errorMessage)) {
        echo $errorMessage;
    }
    ?>

    <!-- form_r = Formulario Registro -->
    <form id="registroForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="row g-3 form_r">

        <h4 class="opacity-75">Datos personales</h4>
        <hr>

        <!-- Campo oculto para la acción -->
        <input type="hidden" name="accion" value="registrar">

        <div class="col-lg-4 col-12">
            <label for="nombre">Nombre<span>*</span></label>
            <input type="text" class="form-control" id="nombre" value="<?php if (isset($nombre)) echo $nombre ?>" name="nombre" placeholder="NOMBRE">
        </div>

        <div class="col-lg-8 col-12">
            <label for="apellidos">Apellidos<span>*</span></label>
            <input type="text" class="form-control" id="apellidos" value="<?php if (isset($apellidos)) echo $apellidos ?>" name="apellidos" placeholder="APELLIDOS">
        </div>

        <div class="col-sm-6 col-lg-4 col-12">
            <label for="fechanacimiento">Fecha de nacimiento<span>*</span></label>
            <input type="date" class="form-control" id="fechanacimiento" value="<?php echo htmlspecialchars($userData['fecha_nacimiento']); ?>" name="fechaNacimiento" placeholder="dd/mm/aa">
        </div>

        <div class="col-sm-6 col-lg-4 col-12">
            <label for="paisnac">País de nacimiento<span>*</span></label>
            <!-- select_p = Select País -->
            <select id="paisnac" name="paisnac" class="select_p"></select>
        </div>

        <?php $tipoDocumentoSeleccionado = isset($_POST['tipodocumento']) ? $_POST['tipodocumento'] : ''; ?>
        <!-- c_s-in = Container Select Inputs -->
        <div class="col-lg-2 col-4 c_s-in">
            <label for="tipodocumento">Documento<span>*</span></label>
            <select id="tipodocumento" name="tipodocumento">
                <option value="dni" <?php echo ($tipoDocumentoSeleccionado === 'dni') ? 'selected' : ''; ?>>DNI</option>
                <option value="nie" <?php echo ($tipoDocumentoSeleccionado === 'nie') ? 'selected' : ''; ?>>NIE</option>
                <option value="pasaporte" <?php echo ($tipoDocumentoSeleccionado === 'pasaporte') ? 'selected' : ''; ?>>PASAPORTE</option>
            </select>
        </div>

        <div class="col-lg-2 col-8">
            <label for="numdocumento">Nro<span>*</span></label>
            <input class="form-control" value="<?php if (isset($numDocumento)) echo $numDocumento ?>" type="text" id="numdocumento" name="numDocumento">
        </div>

        <?php $sexoSeleccionado = isset($_POST['sexo']) ? $_POST['sexo'] : ''; ?>
        <!-- con_sx = Container Sexo -->
        <div class="col-lg-2 col-4 c_s-in">
            <label for="sexo">Sexo<span>*</span></label>
            <select id="sexo" name="sexo">
                <option value="masculino" <?php echo ($sexoSeleccionado === 'masculino') ? 'selected' : ''; ?>>Masculino</option>
                <option value="femenino" <?php echo ($sexoSeleccionado === 'femenino') ? 'selected' : ''; ?>>Femenino</option>
                <option value="otro" <?php echo ($sexoSeleccionado === 'otro') ? 'selected' : ''; ?>>Otro</option>
            </select>
        </div>


        <h4 class="opacity-75">Datos de contacto</h4>
        <hr>

        <div class="col-sm-8 col-12">
            <label for="email">Correo electrónico<span>*</span></label>
            <input type="email" value="<?php if (isset($email)) echo $email ?>" class="form-control" id="email" name="email" placeholder="example@gmail.com">
        </div>

        <div class="col-sm-4 col-12">
            <label for="phone">Teléfono móvil<span>*</span></label>
            <input type="number" value="<?php if (isset($numPhone)) echo $numPhone ?>" class="form-control" id="phone" name="numPhone" placeholder="TELÉFONO MÓVIL">
        </div>

        <div class="col-lg-2 col-3">
            <label for="via">Vía<span>*</span></label>
            <!-- select_via = Select Vía -->
            <select id="via" name="via" class="select_via"></select>
        </div>

        <div class="col-lg-4 col-9">
            <label for="nomVia">Nombre de la vía<span>*</span></label>
            <input type="text" value="<?php if (isset($nameVia)) echo $nameVia ?>" class="form-control" id="nomVia" name="nameVia" placeholder="NOMBRE DE LA VÍA">
        </div>

        <div class="col-sm-2 col-4">
            <label for="munvia">N°<span>*</span></label>
            <input type="number" value="<?php if (isset($numVia)) echo $numVia ?>" name="numVia" class="form-control" id="munvia" placeholder="-">
        </div>

        <div class="col-sm-2 col-4">
            <label for="numpiso">Piso<span>*</span></label>
            <input type="number" value="<?php if (isset($numPisoVia)) echo $numPisoVia ?>" name="numPisoVia" class="form-control" id="numpiso" placeholder="-">
        </div>

        <div class="col-sm-2 col-4">
            <label for="letra">Letra<span>*</span></label>
            <input type="text" value="<?php if (isset($letraVia)) echo $letraVia ?>" name="letraVia" class="form-control" id="letra" placeholder="-">
        </div>

        <div class="col-sm-6 col-lg-4 col-12">
            <label for="paisres">País de residencia<span>*</span></label>
            <select id="paisres" name="paisres" class="select_p"></select>
        </div>

        <div class="col-sm-4 col-lg-2 col-12">
            <label for="codigopostal">Código postal<span>*</span></label>
            <input type="number" value="<?php if (isset($codigoPostal)) echo $codigoPostal ?>" name="codigoPostal" class="form-control" id="codigopostal" placeholder="-">
        </div>

        <div class="col-sm-4 col-lg-3 col-12">
            <label for="localidad">Localidad<span>*</span></label>
            <input type="text" value="<?php if (isset($localidad)) echo $localidad ?>" name="localidad" class="form-control" id="localidad" placeholder="LOCALIDAD">
        </div>

        <div class="col-sm-4 col-lg-3 col-12">
            <label for="provincia">Provincia<span>*</span></label>
            <select id="provincia" name="provincia" class="select_p"></select>
        </div>

        <h4 class="opacity-75">Clave de acceso</h4>
        <hr>

        <div class="col-md-6 col-12">
            <label for="password1">Contraseña<span>*</span></label>
            <input type="password" value="<?php if (isset($passw1)) echo $passw1 ?>" name="passw1" class="form-control" id="password1" placeholder="Contraseña">
        </div>

        <div class="col-md-6 col-12">
            <label for="password2">Repetir contraseña<span>*</span></label>
            <input type="password" value="<?php if (isset($passw2)) echo $passw2 ?>" name="passw2" class="form-control" id="password2" placeholder="Repetir contraseña">
        </div>

        <!-- text2-r-pass = Text2 Registro Password -->
        <p class="text2-r-pass"><i class="bi bi-exclamation-circle-fill"></i> Por seguridad introducir 8 caracteres como mínimo y, como mínimo, una mayúscula, minúscula y un número</p>

        <hr>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="consentimiento" value="1" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Declaro haber leído y consiento <a href="../views/politicas-privacidad.php">el tratamiento de datos</a> en los términos expuestos.<span>*</span>
            </label>
        </div>

        <hr>

        <!-- c_submit = Container Submit -->
        <div class="container mx-auto text-center c_submit">
            <div class="container mx-auto text-center c_submit">
                <label for="btn"></label>
                <input class="btn btn-primary" type="submit" Value="REGISTRARSE" name="submit">
            </div>
        </div>

    </form>

</main>


<?php require('../layout/footer.php') ?>
<?php
require('../layout/header.php');
include '../config/db.php';
?>

<?php
ob_start(); // Inicia el almacenamiento en búfer de salida
?>

<?php
include('../includes/validacion-login.php');
?>

<!-- c_login = Container Login -->
<main class="container c_login">
    <div class="row">
        <!-- div_right = Div Right -->
        <div class="div_right col-md-6 col-12">
            <div class="text-center">
                <h3>¿Ya eres usuario?</h3>
            </div>
            <!-- text_s = Text Sugerencia -->
            <div class="text-center text_s">
                <span>Si desea acceder al área del paciente introduzca su usuario y contraseña.</span>
            </div>
            <?php if (isset($error)) echo "<p>$error</p>"; ?>
            <form action="" method="post" class="g-3 form_r">
                <!-- c_user = Container User -->
                <div class="c_user">
                    <label for="user">Usuario</label>
                    <input type="text" required name="usuario" class="form-control" id="user" placeholder="Email">
                </div>
                <!-- c_pass = Container Password -->
                <div class="c_pass">
                    <label for="pass_user">Contraseña</label>
                    <input type="password" required name="password" class="form-control" id="pass_user" placeholder="Contraseña">
                </div>
                <!-- c_btn = Container Button -->
                <div class="c_btn text-center">
                    <button type="submit" class="btn_acceso btn">Acceder</button>
                </div>
            </form>
        </div>

        <!-- div_left = Div Left -->
        <div class="div_left col-md-6 col-12">
            <div class="text-center">
                <h3>¿Aún no eres usuario?</h3>
            </div>
            <!-- c_img-l = Container Image Login -->
            <div class="c_img-l text-center">
                <img src="../img/login/usuario.png" alt="Img User">
            </div>
            <!-- c_btn_a-u = Container Button Hacerse User -->
            <div class="c_btn_h-u text-center">
                <a href="./registro.php" class="btn_h-u btn">Hacerse usuario</a>
            </div>
        </div>
    </div>
</main>

<?php require('../layout/footer.php') ?>

<?php
ob_end_flush(); // Envía el contenido del búfer al navegador
?>
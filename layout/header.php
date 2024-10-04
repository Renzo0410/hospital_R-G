<?php
session_start();
include("../config/db.php");
ob_start(); // Inicia el almacenamiento en búfer de salida
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabajo final</title>
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/aside.css">
    <link rel="stylesheet" href="/css/registro.css">
    <link rel="stylesheet" href="/css/noticias.css">
    <link rel="stylesheet" href="/css/servicios.css">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/politicas.css">
    <link rel="stylesheet" href="/css/perfil.css">
    <link rel="stylesheet" href="/css/administracion.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
</head>

<body>
    <!-- c_h = Container Header -->
    <div class="container-md c_h">
        <header class="row">
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <!-- title_h -->
                    <a class="title_h navbar-brand" href="./index.php">R&G Salud</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <!-- INICIO -->
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="./index.php">Inicio</a>
                            </li>
                            <!-- NOTICIAS -->
                            <li class="nav-item">
                                <a class="nav-link" href="./noticias.php">Noticias</a>
                            </li>
                            <?php
                            // Verificar si hay sesión iniciada y el rol del usuario
                            if (isset($_SESSION['rol'])) {
                                if ($_SESSION['rol'] == 'user') {
                                    // Menú para usuarios comunes
                                    echo '<li><a class="nav-link" href="./citas.php">Citaciones</a></li>';
                                    echo '<li><a class="nav-link" href="./perfil.php">Perfil</a></li>';
                                    echo '<li><a class="nav-link" href="../includes/logout.php">Cerrar Sesión</a></li>';
                                } elseif ($_SESSION['rol'] == 'admin') {
                                    // Menú para administradores
                                    echo '<li><a class="nav-link" href="./noticias-administracion.php">Admin. Noticias</a></li>';
                                    echo '<li><a class="nav-link" href="./usuarios-administracion.php">Admin. Usuarios</a></li>';
                                    echo '<li><a class="nav-link" href="./citas.php">Citaciones</a></li>';
                                    echo '<li><a class="nav-link" href="./citas-administracion.php">Admin. Citas</a></li>';
                                    echo '<li><a class="nav-link" href="./perfil.php">Perfil</a></li>';
                                    echo '<li><a class="nav-link" href="../includes/logout.php">Cerrar Sesión</a></li>';
                                }
                            } else {
                                // Menú para usuarios no registrados
                            ?>
                                <!-- SERVICIOS -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Servicios destacados
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="./servicios-cardiologia.php">Cardiología</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="./servicios-vacunacion.php">Vacunación</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="./servicios-pedriatria.php">Pediatría</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="./servcios-neumologia.php">Neumología</a></li>
                                    </ul>
                                </li>
                                <!-- REGISTRO -->
                                <li class="nav-item">
                                    <a class="nav-link" href="./registro.php">Registro</a>
                                </li>
                                <!-- LOGIN -->
                                <li class="nav-item">
                                    <a class="nav-link" href="./login.php">Login</a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    </div>
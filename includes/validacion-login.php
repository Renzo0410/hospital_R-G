<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Consulta para obtener los datos del usuario
    $stmt = $conn->prepare("SELECT * FROM users_login WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Iniciar sesión y redirigir según el rol
        $_SESSION['idUser'] = $user['idUser']; // Al iniciar sesión
        $_SESSION['rol'] = $user['rol']; // Guarda el rol (usuario o admin)
        header("Location: " . ($user['rol'] == 'admin' ? "index.php" : "index.php"));
        exit();
    } else {
        $error = "<div class='error-form'>Usuario o contraseña incorrectos.</div>";
    }
}

?>

<!--  -->
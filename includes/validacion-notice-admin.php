<div class="container error-form">
    <?php
    if ($_SESSION['rol'] !== 'admin') {
        header("Location: login.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Procesar agregar noticia
        if (isset($_POST['submit'])) {
            $titulo = $conn->real_escape_string($_POST['titulo']);
            $texto = $conn->real_escape_string($_POST['texto']);
            $fecha = date("Y-m-d");
            $idUser = $_SESSION['idUser']; // Usa el ID del usuario desde la sesión

            // Manejo de la subida de imagen
            $imagen = $_FILES['imagen']['name'];
            $target_dir = "../img/noticias/";
            $target_file = $target_dir . basename($imagen);

            // Validar el tipo de archivo
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (!in_array($imageFileType, $allowed_types)) {
                echo "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
            } elseif ($_FILES['imagen']['size'] > 2000000) {
                echo "El archivo es demasiado grande. Máximo 2MB.";
            } else {
                // Validar y mover archivo
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
                    $query = "INSERT INTO noticias (titulo, imagen, texto, fecha, idUser) VALUES ('$titulo', '$imagen', '$texto', '$fecha', '$idUser')";
                    if ($conn->query($query) === TRUE) {
                        echo "Noticia agregada exitosamente.";
                    } else {
                        echo "Error: " . $conn->error;
                    }
                } else {
                    echo "Error al subir la imagen.";
                }
            }
        }

        // Procesar eliminación de noticias
        if (isset($_POST['eliminar'])) {
            $idNoticia = $conn->real_escape_string($_POST['idNoticia']);
            $query = "DELETE FROM noticias WHERE idNoticia = '$idNoticia'";

            if ($conn->query($query) === TRUE) {
                echo "Noticia eliminada exitosamente.";
            } else {
                echo "Error al eliminar la noticia: " . $conn->error;
            }
        }

        // Procesar la edición de noticias
        if (isset($_POST['guardarEdicion'])) {
            $idNoticia = $conn->real_escape_string($_POST['idNoticia']);

            // Verificar si los campos existen antes de acceder a ellos
            $titulo = isset($_POST['titulo']) ? $conn->real_escape_string($_POST['titulo']) : '';
            $texto = isset($_POST['texto']) ? $conn->real_escape_string($_POST['texto']) : '';

            $fecha = date("Y-m-d");

            // Mantener la imagen actual si no se sube una nueva
            if (!empty($_FILES['imagen']['tmp_name'])) {
                $imagen = $_FILES['imagen']['name'];
                $target_dir = "../img/noticias/";
                $target_file = $target_dir . basename($imagen);
                move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file);
            } else {
                // Si no hay una nueva imagen, usar la imagen actual que ya está almacenada
                $imagen = isset($_POST['imagenActual']) ? $_POST['imagenActual'] : ''; // Validar si 'imagenActual' existe
            }

            // Actualizar la noticia
            if (!empty($titulo) && !empty($texto)) {
                $query = "UPDATE noticias SET titulo='$titulo', imagen='$imagen', texto='$texto', fecha='$fecha' WHERE idNoticia='$idNoticia'";

                if ($conn->query($query) === TRUE) {
                    echo "Noticia actualizada exitosamente.";
                } else {
                    echo "Error al actualizar la noticia: " . $conn->error;
                }
            } else {
                echo "Error: El título y el texto son obligatorios.";
            }
        }
    }

    // Obtener todas las noticias, ahora incluyendo el nombre del autor
    $query = "SELECT n.*, u.nombre AS autor 
        FROM noticias n
        LEFT JOIN users_data u ON n.idUser = u.idUser 
        ORDER BY n.fecha DESC";
    $result = $conn->query($query);
    ?>
</div>
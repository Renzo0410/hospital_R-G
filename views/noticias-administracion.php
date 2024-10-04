<?php
require('../layout/header.php');
include '../config/db.php';
?>

<?php
include('../includes/validacion-notice-admin.php');
?>

<main class="container">
    <hr>
    <h2>Agregar Nueva Noticia</h2>
    <hr>
    <form action="noticias-administracion.php" method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen" required>
        </div>
        <div class="mb-3">
            <label for="texto" class="form-label">Texto</label>
            <textarea class="form-control" id="texto" name="texto" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Agregar Noticia</button>
    </form>
</main>

<main class="container" id="edit-section">
    <!-- Sección de administración de noticias -->
    <hr>
    <h2>Administrar Noticias</h2>

    <div class="container c-admin-notice">
        <div class="row">
            <div class="col-6 title-notice">Titulo</div>
            <div class="col-6 title-notice">Acciones</div>
        </div>
        <div>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Detectar si se está editando esta noticia
                    $isEditing = isset($_POST['editando']) && $_POST['editando'] == $row['idNoticia'];
            ?>
                    <div class="row text-center">
                        <!-- Título -->
                        <div class="<?php echo $isEditing ? 'col-12' : 'col-md-6'; ?> notice-edit_delete ">
                            <?php if ($isEditing) { ?>
                                <!-- Formulario de edición -->
                                <form action="noticias-administracion.php#edit-section" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="idNoticia" value="<?php echo $row['idNoticia']; ?>">
                                    <div class="row container-edit">
                                        <h5>Información</h5>
                                        <hr>
                                        <!-- Campo de Título y Texto de la noticia -->
                                        <div class="col-lg-6 col-12">
                                            <div class="mb-3">
                                                <input type="text" class="form-control" name="titulo" value="<?php echo htmlspecialchars($row['titulo']); ?>" required>
                                            </div>
                                            <!-- Campo de texto -->
                                            <div class="mb-3">
                                                <textarea class="form-control" name="texto" rows="10" required><?php echo htmlspecialchars($row['texto']); ?></textarea>
                                            </div>
                                        </div>
                                        <!-- Campo de imagen y fecha de publicación -->
                                        <div class="c-img-date row col-lg-6 col-12">
                                            <!-- Mostrar imagen actual -->
                                            <div class="col-sm-6 col-12 mb-3 c-img">
                                                <div>
                                                    <h6>Imagen actual:</h6>
                                                </div>
                                                <hr>
                                                <div>
                                                    <img src="../img/noticias/<?php echo htmlspecialchars($row['imagen']); ?>" alt="Imagen actual" class="img-fluid">
                                                    <input type="file" class="form-control mt-2" name="imagen">
                                                    <input type="hidden" name="imagenActual" value="<?php echo htmlspecialchars($row['imagen']); ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-12">
                                                <!-- Autor -->
                                                <div class="row c-date">
                                                    <div>
                                                        <h6>Autor de la noticia:</h6>
                                                    </div>
                                                    <hr>
                                                    <div>
                                                        <p><?php echo isset($row['autor']) ? htmlspecialchars($row['autor']) : 'Autor desconocido'; ?></p>
                                                    </div>
                                                </div>
                                                <!-- Fecha -->
                                                <div class="row c-date">
                                                    <div>
                                                        <h6>Fecha de publicación:</h6>
                                                    </div>
                                                    <hr>
                                                    <div>
                                                        <?php echo date("d/m/Y", strtotime($row['fecha'])); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Botones Guardar Cambios y Cancelar juntos en el mismo formulario -->
                                        <div class="col-12">
                                            <button type="submit" class="btn-g-c btn btn-success" name="guardarEdicion">Guardar Cambios</button>
                                            <button type="submit" class="btn-g-c btn btn-secondary" name="cancelar" formaction="noticias-administracion.php#edit-section">Cancelar</button>
                                        </div>
                                    </div>
                                </form>
                            <?php } else { ?>
                                <!-- Mostrar el título cuando no se está editando -->
                                <?php echo htmlspecialchars($row['titulo']); ?>
                            <?php } ?>
                        </div>

                        <!-- Columna de Editar/Eliminar (oculta en modo edición) -->
                        <?php if (!$isEditing) { ?>
                            <div class="col-md-6 col-12 notice-edit_delete">
                                <!-- Botón para iniciar la edición -->
                                <form action="noticias-administracion.php#edit-section" method="POST">
                                    <input type="hidden" name="idNoticia" value="<?php echo $row['idNoticia']; ?>">
                                    <input type="hidden" name="editando" value="<?php echo $row['idNoticia']; ?>">
                                    <button type="submit" class="btn btn-warning" name="editar">Editar</button>
                                </form>

                                <!-- Botón para eliminar -->
                                <form action="noticias-administracion.php" method="POST" style="display:inline-block;">
                                    <input type="hidden" name="idNoticia" value="<?php echo $row['idNoticia']; ?>">
                                    <button type="submit" class="btn btn-danger" name="eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta noticia?');">Eliminar</button>
                                </form>
                            </div>
                        <?php } ?>
                    </div>
            <?php
                }
            } else {
                echo "<tr><td colspan='3'>No hay noticias disponibles.</td></tr>";
            }
            ?>
        </div>
    </div>
</main>


<?php require('../layout/footer.php') ?>
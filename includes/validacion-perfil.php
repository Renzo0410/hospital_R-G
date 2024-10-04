<!-- Mostrar mensajes de éxito o error -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success">
        <?php
        echo $_SESSION['success_message'];
        unset($_SESSION['success_message']); // Eliminar el mensaje después de mostrarlo
        ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger">
        <?php
        echo $_SESSION['error_message'];
        unset($_SESSION['error_message']); // Eliminar el mensaje después de mostrarlo
        ?>
    </div>
<?php endif; ?>
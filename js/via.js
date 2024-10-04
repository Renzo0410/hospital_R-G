document.addEventListener('DOMContentLoaded', function() {
    // Definir las opciones disponibles para "Vía"
    const vias = [
        "Avenida", "Calle", "Camino", "Carretera", "Glorieta", "Paseo", "Plaza", "Pasaje", "Rambla", "Ronda"
    ];

    // Obtener el select de vía y el valor seleccionado desde PHP
    const selectVia = document.getElementById('via');
    var viaSeleccionada = "<?php echo isset($viaSeleccionada) ? $viaSeleccionada : ''; ?>";

    // Generar las opciones del select
    vias.forEach(via => {
        const option = document.createElement('option');
        option.value = via;
        option.textContent = via;

        // Marcar la opción seleccionada si coincide con la selección previa
        if (via === viaSeleccionada) {
            option.selected = true;
        }

        selectVia.appendChild(option);
    });
});

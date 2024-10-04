const provincias = [
    "A Coruña", "Álava", "Albacete","Alicante","Almería","Asturias","Ávila","Badajoz","Baleares","Barcelona","Burgos","Cáceres","Cádiz","Cantabria","Castellón","Ciudad Real","Córdoba","Cuenca","Girona","Granada","Guadalajara","Gipuzkoa","Huelva","Huesca","Jaén","La Rioja","Las Palmas","León","Lérida","Lugo","Madrid","Málaga","Murcia","Navarra","Ourense","Palencia","Pontevedra","Salamanca","Segovia","Sevilla","Soria","Tarragona","Santa Cruz de Tenerife","Teruel","Toledo","Valencia","Valladolid","Vizcaya","Zamora","Zaragoza", "Residente fuera de España", "Desconocido"
];

const selectProvincia = document.getElementById('provincia');
var provinciaSeleccionada = "<?php echo $provinciaSeleccionada; ?>";

provincias.forEach(provincia => {
    const option = document.createElement('option');
    option.value = provincia;
    option.textContent = provincia;

    // Si el país coincide con el valor seleccionado previamente, se marca como seleccionado
    if (provincia === provinciaSeleccionada) {
        option.selected = true;
    }

    selectProvincia.appendChild(option);
});
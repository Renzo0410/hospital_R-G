document.querySelector('#registroForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Evitar el envío del formulario de manera tradicional

    const formData = new FormData(this);

    // Enviar los datos al backend usando fetch
    fetch('includes/validacion-form.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // Convertir la respuesta a JSON
    .then(data => {
        const messageElement = document.createElement('p');
        messageElement.classList.add(data.status === 'success' ? 'success-form' : 'error-form');
        messageElement.textContent = data.message;
        document.querySelector('.form-container').appendChild(messageElement);

        if (data.status === 'success') {
            // Redirigir al usuario al login después de unos segundos
            setTimeout(() => {
                window.location.href = 'login.php';
            }, 3000); // Redirigir después de 3 segundos
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Manejo de errores en el cliente si ocurre algún problema
        const messageElement = document.createElement('p');
        messageElement.classList.add('error-form');
        messageElement.textContent = 'Error en la solicitud. Por favor, intenta de nuevo.';
        document.querySelector('.form-container').appendChild(messageElement);
    });
});

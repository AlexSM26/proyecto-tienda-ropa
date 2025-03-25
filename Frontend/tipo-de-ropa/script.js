document.addEventListener('DOMContentLoaded', function () {
    const apiUrl = 'http://localhost/proyecto/API/public/index.php/api/tipo_de_ropa';

    fetch(apiUrl)
        .then(response => response.json())
        .then(tiposRopa => {
            const tipoRopaLista = document.getElementById('tipo-ropa-lista');
            tipoRopaLista.innerHTML = '';

            tiposRopa.forEach(tipo => {
                const tipoDiv = document.createElement('div');
                tipoDiv.className = 'tipo-ropa';

                tipoDiv.innerHTML = `
                    <h2>${tipo.nombre}</h2>
                    <p><strong>Marca:</strong> ${tipo.marca_id}</p>
                    <p><strong>Precio:</strong> $${tipo.precio}</p>
                    <p><strong>Stock:</strong> ${tipo.stock}</p>
                `;

                tipoRopaLista.appendChild(tipoDiv);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            const tipoRopaLista = document.getElementById('tipo-ropa-lista');
            tipoRopaLista.innerHTML = '<p>Error al cargar los tipos de ropa. Inténtalo de nuevo más tarde.</p>';
        });
});
document.addEventListener('DOMContentLoaded', function () {
    const apiUrl = 'http://localhost/proyecto/API/public/index.php/api/marcas';

    fetch(apiUrl)
        .then(response => response.json())
        .then(marcas => {
            const marcasLista = document.getElementById('marcas-lista');
            marcasLista.innerHTML = '';

            marcas.forEach(marca => {
                const marcaDiv = document.createElement('div');
                marcaDiv.className = 'marca';

                marcaDiv.innerHTML = `
                    <h2>${marca.nombre}</h2>
                `;

                marcasLista.appendChild(marcaDiv);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            const marcasLista = document.getElementById('marcas-lista');
            marcasLista.innerHTML = '<p>Error al cargar las marcas. Inténtalo de nuevo más tarde.</p>';
        });
});
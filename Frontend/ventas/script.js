document.addEventListener('DOMContentLoaded', function () {
    const apiUrl = 'http://localhost/proyecto/API/public/index.php/api/ventas';

    fetch(apiUrl)
        .then(response => response.json())
        .then(ventas => {
            const ventasLista = document.getElementById('ventas-lista');
            ventasLista.innerHTML = '';

            ventas.forEach(venta => {
                const ventaDiv = document.createElement('div');
                ventaDiv.className = 'venta';

                ventaDiv.innerHTML = `
                    <h2>Venta ID: ${venta.id}</h2>
                    <p><strong>Fecha:</strong> ${venta.fecha_venta}</p>
                `;

                ventasLista.appendChild(ventaDiv);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            const ventasLista = document.getElementById('ventas-lista');
            ventasLista.innerHTML = '<p>Error al cargar las ventas. Inténtalo de nuevo más tarde.</p>';
        });
});
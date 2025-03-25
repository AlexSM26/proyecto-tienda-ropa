document.addEventListener('DOMContentLoaded', function () {
    const apiUrl = 'http://localhost/proyecto/API/public/index.php/api/detalle_ventas';

    fetch(apiUrl)
        .then(response => response.json())
        .then(detallesVentas => {
            const detalleVentasLista = document.getElementById('detalle-ventas-lista');
            detalleVentasLista.innerHTML = '';

            detallesVentas.forEach(detalle => {
                const detalleDiv = document.createElement('div');
                detalleDiv.className = 'detalle-venta';

                detalleDiv.innerHTML = `
                    <h2>Detalle ID: ${detalle.id}</h2>
                    <p><strong>Venta ID:</strong> ${detalle.venta_id}</p>
                    <p><strong>Tipo de Ropa ID:</strong> ${detalle.tipo_de_ropa_id}</p>
                    <p><strong>Cantidad:</strong> ${detalle.cantidad}</p>
                    <p><strong>Precio Unitario:</strong> $${detalle.precio_unitario}</p>
                `;

                detalleVentasLista.appendChild(detalleDiv);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            const detalleVentasLista = document.getElementById('detalle-ventas-lista');
            detalleVentasLista.innerHTML = '<p>Error al cargar los detalles de ventas. Inténtalo de nuevo más tarde.</p>';
        });
});
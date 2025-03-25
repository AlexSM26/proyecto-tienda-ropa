document.addEventListener('DOMContentLoaded', function () {
    const apiUrl = 'http://localhost/proyecto/API/public/index.php/api/clientes';

    fetch(apiUrl)
        .then(response => response.json())
        .then(clientes => {
            const clientesLista = document.getElementById('clientes-lista');
            clientesLista.innerHTML = '';

            clientes.forEach(cliente => {
                const clienteDiv = document.createElement('div');
                clienteDiv.className = 'cliente';

                clienteDiv.innerHTML = `
                    <h2>${cliente.nombre}</h2>
                    <p><strong>Email:</strong> ${cliente.email}</p>
                    <p><strong>Teléfono:</strong> ${cliente.telefono}</p>
                    <p><strong>Dirección:</strong> ${cliente.direccion}</p>
                `;

                clientesLista.appendChild(clienteDiv);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            const clientesLista = document.getElementById('clientes-lista');
            clientesLista.innerHTML = '<p>Error al cargar los clientes. Inténtalo de nuevo más tarde.</p>';
        });
});
$(document).ready(function() {
    // Configuración base
    const API_BASE_URL = 'http://localhost/proyecto/API/public/index.php/api';
    
    // Cargar todos los reportes
    cargarMarcasConVentas();
    cargarPrendasVendidasStock();
    cargarTop5MarcasVendidas();

    // Función para mostrar carga
    function mostrarCarga(selector) {
        $(selector).html('<tr><td colspan="3" class="text-center"><div class="spinner-border"></div> Cargando...</td></tr>');
    }

    // Función para mostrar error
    function mostrarError(selector, mensaje) {
        $(selector).html(`<tr><td colspan="3" class="text-danger">${mensaje}</td></tr>`);
    }

    // 1. Marcas con ventas
    function cargarMarcasConVentas() {
        mostrarCarga('#tabla-marcas tbody');
        
        $.ajax({
            url: `${API_BASE_URL}/reportes/marcas-con-ventas`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data && response.data.length > 0) {
                    let html = '';
                    response.data.forEach(marca => {
                        html += `<tr><td>${marca.marca || 'No disponible'}</td></tr>`;
                    });
                    $('#tabla-marcas tbody').html(html);
                } else {
                    mostrarError('#tabla-marcas tbody', response.error || 'No hay marcas con ventas');
                }
            },
            error: function(xhr) {
                let errorMsg = 'Error al cargar datos';
                try {
                    const err = JSON.parse(xhr.responseText);
                    errorMsg = err.error || errorMsg;
                } catch (e) {}
                mostrarError('#tabla-marcas tbody', errorMsg);
            }
        });
    }

    // 2. Prendas vendidas y stock
    function cargarPrendasVendidasStock() {
        mostrarCarga('#tabla-prendas tbody');
        
        $.ajax({
            url: `${API_BASE_URL}/reportes/prendas-vendidas-stock`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data && response.data.length > 0) {
                    let html = '';
                    response.data.forEach(prenda => {
                        html += `
                        <tr>
                            <td>${prenda.prenda || 'No disponible'}</td>
                            <td>${prenda.vendidas || 0}</td>
                            <td>${prenda.stock || 0}</td>
                        </tr>`;
                    });
                    $('#tabla-prendas tbody').html(html);
                } else {
                    mostrarError('#tabla-prendas tbody', response.error || 'No hay prendas vendidas');
                }
            },
            error: function(xhr) {
                let errorMsg = 'Error al cargar datos';
                try {
                    const err = JSON.parse(xhr.responseText);
                    errorMsg = err.error || errorMsg;
                } catch (e) {}
                mostrarError('#tabla-prendas tbody', errorMsg);
            }
        });
    }

    // 3. Top 5 marcas
    function cargarTop5MarcasVendidas() {
        mostrarCarga('#tabla-top5 tbody');
        
        $.ajax({
            url: `${API_BASE_URL}/reportes/top-5-marcas-vendidas`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data && response.data.length > 0) {
                    let html = '';
                    response.data.forEach(marca => {
                        html += `
                        <tr>
                            <td>${marca.marca || 'No disponible'}</td>
                            <td>${marca.total_vendido || 0}</td>
                        </tr>`;
                    });
                    $('#tabla-top5 tbody').html(html);
                } else {
                    mostrarError('#tabla-top5 tbody', response.error || 'No hay suficientes datos');
                }
            },
            error: function(xhr) {
                let errorMsg = 'Error al cargar datos';
                try {
                    const err = JSON.parse(xhr.responseText);
                    errorMsg = err.error || errorMsg;
                } catch (e) {}
                mostrarError('#tabla-top5 tbody', errorMsg);
            }
        });
    }
});
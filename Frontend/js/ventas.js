$(document).ready(function() {
    // Cargar todas las ventas al iniciar
    cargarVentas();

    // Manejar envío del formulario
    $('#venta-form').submit(function(e) {
        e.preventDefault();
        guardarVenta();
    });

    // Manejar cancelar edición
    $('#cancelar-edicion').click(function() {
        resetForm();
    });
});

// Función para cargar todas las ventas
function cargarVentas() {
    $.ajax({
        url: `http://localhost/proyecto/API/public/index.php/api/ventas`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                let ventas = response.data;
                let tbody = '';
                ventas.forEach(venta => {
                    tbody += `
                    <tr>
                        <td>${venta.id}</td>
                        <td>${venta.fecha_venta}</td>
                        <td>
                            <button class="btn btn-sm btn-warning me-2" onclick="editarVenta(${venta.id})">Editar</button>
                            <button class="btn btn-sm btn-danger" onclick="eliminarVenta(${venta.id})">Eliminar</button>
                        </td>
                    </tr>`;
                });
                $('#tabla-ventas tbody').html(tbody);
            } else {
                $('#tabla-ventas tbody').html('<tr><td colspan="3">No se pudieron cargar las ventas</td></tr>');
            }
        },
        error: function(error) {
            console.error('Error al cargar ventas:', error);
            $('#tabla-ventas tbody').html('<tr><td colspan="3">Error al cargar las ventas</td></tr>');
        }
    });
}

// Función para guardar una venta (crear o actualizar)
function guardarVenta() {
    const formData = {
        id: $('#venta-id').val(),
        fecha_venta: $('#fecha_venta').val()
    };

    if (!formData.fecha_venta) {
        return alert('Por favor complete la fecha de venta');
    }

    const isEdit = !!formData.id;
    const request = {
        url: `http://localhost/proyecto/API/public/index.php/api/ventas/${formData.id || ''}`,
        type: isEdit ? 'PUT' : 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ fecha_venta: formData.fecha_venta }),
        success: (response) => {
            alert(isEdit ? 'Venta actualizada' : 'Venta creada');
            resetForm();
            cargarVentas();
        },
        error: (xhr) => {
            const error = xhr.responseJSON?.error || 'Error desconocido';
            alert(`Error: ${error}`);
        }
    };

    $.ajax(request);
}

// Función para editar una venta
function editarVenta(id) {
    $.ajax({
        url: `http://localhost/proyecto/API/public/index.php/api/ventas/${id}`,
        type: 'GET',
        dataType: 'json',
        success: function(venta) {
            $('#venta-id').val(venta.id);
            $('#fecha_venta').val(venta.fecha_venta);
            $('#form-title').text('Editar Venta');
            $('#cancelar-edicion').show();
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        },
        error: function(error) {
            console.error('Error al cargar venta:', error);
            alert('Error al cargar los datos de la venta');
        }
    });
}

// Función para eliminar una venta
function eliminarVenta(id) {
    if (confirm('¿Está seguro de que desea eliminar esta venta?')) {
        $.ajax({
            url: `http://localhost/proyecto/API/public/index.php/api/ventas/${id}`,
            type: 'DELETE',
            success: function(response) {
                alert('Venta eliminada correctamente');
                cargarVentas();
            },
            error: function(error) {
                console.error('Error al eliminar venta:', error);
                alert('Error al eliminar la venta');
            }
        });
    }
}

// Función para resetear el formulario
function resetForm() {
    $('#venta-id').val('');
    $('#venta-form')[0].reset();
    $('#form-title').text('Agregar Nueva Venta');
    $('#cancelar-edicion').hide();
}
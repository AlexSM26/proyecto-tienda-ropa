$(document).ready(function() {
    // Cargar detalles de ventas al iniciar
    cargarDetalles();

    // Manejar envío del formulario
    $('#detalle-form').submit(function(e) {
        e.preventDefault();
        guardarDetalle();
    });

    // Manejar cancelar edición
    $('#cancelar-edicion').click(function() {
        resetForm();
    });
});

// Función para cargar todos los detalles de venta
function cargarDetalles() {
    $.ajax({
        url: `http://localhost/proyecto/API/public/index.php/api/detalle_ventas`,
        type: 'GET',
        dataType: 'json',
        success: function(detalles) {
            let tbody = '';
            detalles.forEach(detalle => {
                tbody += `
                <tr>
                    <td>${detalle.id}</td>
                    <td>${detalle.venta_id}</td>
                    <td>${detalle.tipo_de_ropa_id}</td>
                    <td>${detalle.cantidad}</td>
                    <td>₡${parseFloat(detalle.precio_unitario).toFixed(2)}</td>
                    <td>
                        <button class="btn btn-sm btn-warning me-2" onclick="editarDetalle(${detalle.id})">Editar</button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarDetalle(${detalle.id})">Eliminar</button>
                    </td>
                </tr>`;
            });
            $('#tabla-detalle-ventas tbody').html(tbody);
        },
        error: function(error) {
            console.error('Error al cargar detalles:', error);
            $('#tabla-detalle-ventas tbody').html('<tr><td colspan="6">Error al cargar los detalles de ventas</td></tr>');
        }
    });
}

// Función para guardar un detalle (crear o actualizar)
function guardarDetalle() {
    const formData = {
        id: $('#detalle-id').val(),
        venta_id: $('#venta_id').val(),
        tipo_de_ropa_id: $('#tipo_de_ropa_id').val(),
        cantidad: $('#cantidad').val(),
        precio_unitario: $('#precio_unitario').val()
    };

    if (!formData.venta_id || !formData.tipo_de_ropa_id || !formData.cantidad || !formData.precio_unitario) {
        return alert('Por favor complete todos los campos');
    }

    const isEdit = !!formData.id;
    const request = {
        url: `http://localhost/proyecto/API/public/index.php/api/detalle_ventas/${formData.id || ''}`,
        type: isEdit ? 'PUT' : 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            venta_id: Number(formData.venta_id),
            tipo_de_ropa_id: Number(formData.tipo_de_ropa_id),
            cantidad: Number(formData.cantidad),
            precio_unitario: Number(formData.precio_unitario)
        }),
        success: function(response) {
            alert(isEdit ? 'Detalle actualizado' : 'Detalle creado');
            resetForm();
            cargarDetalles();
        },
        error: function(xhr) {
            const error = xhr.responseJSON?.error || 'Error desconocido';
            alert(`Error: ${error}`);
        }
    };

    $.ajax(request);
}

// Función para editar un detalle
function editarDetalle(id) {
    $.ajax({
        url: `http://localhost/proyecto/API/public/index.php/api/detalle_ventas/${id}`,
        type: 'GET',
        dataType: 'json',
        success: function(detalle) {
            $('#detalle-id').val(detalle.id);
            $('#venta_id').val(detalle.venta_id);
            $('#tipo_de_ropa_id').val(detalle.tipo_de_ropa_id);
            $('#cantidad').val(detalle.cantidad);
            $('#precio_unitario').val(detalle.precio_unitario);

            $('#form-title').text('Editar Detalle de Venta');
            $('#cancelar-edicion').show();
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        },
        error: function(error) {
            console.error('Error al cargar detalle:', error);
            alert('Error al cargar el detalle');
        }
    });
}

// Función para eliminar un detalle
function eliminarDetalle(id) {
    if (confirm('¿Está seguro de eliminar este detalle?')) {
        $.ajax({
            url: `http://localhost/proyecto/API/public/index.php/api/detalle_ventas/${id}`,
            type: 'DELETE',
            success: function(response) {
                alert('Detalle eliminado correctamente');
                cargarDetalles();
            },
            error: function(error) {
                console.error('Error al eliminar detalle:', error);
                alert('Error al eliminar el detalle');
            }
        });
    }
}

// Función para resetear el formulario
function resetForm() {
    $('#detalle-id').val('');
    $('#detalle-form')[0].reset();
    $('#form-title').text('Agregar Nuevo Detalle de Venta');
    $('#cancelar-edicion').hide();
}
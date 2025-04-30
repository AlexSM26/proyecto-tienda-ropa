$(document).ready(function() {
    // Cargar todos los clientes al iniciar
    cargarClientes();

    // Manejar envío del formulario
    $('#cliente-form').submit(function(e) {
        e.preventDefault();
        guardarCliente();
    });

    // Manejar cancelar edición
    $('#cancelar-edicion').click(function() {
        resetForm();
    });
});

// Función para cargar todos los clientes
function cargarClientes() {
    $.ajax({
        url: 'http://localhost/proyecto/API/public/index.php/api/clientes/',
        type: 'GET',
        dataType: 'json',
        success: function(clientes) {
            let tbody = '';
            clientes.forEach(cliente => {
                tbody += `
                <tr>
                    <td>${cliente.id}</td>
                    <td>${cliente.nombre}</td>
                    <td>${cliente.email}</td>
                    <td>${cliente.telefono}</td>
                    <td>${cliente.direccion}</td>
                    <td>
                        <button class="btn btn-sm btn-warning me-2" onclick="editarCliente(${cliente.id})">Editar</button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarCliente(${cliente.id})">Eliminar</button>
                    </td>
                </tr>`;
            });
            $('#tabla-clientes tbody').html(tbody);
        },
        error: function(error) {
            console.error('Error al cargar clientes:', error);
            $('#tabla-clientes tbody').html(
                '<tr><td colspan="6">Error al cargar los clientes</td></tr>'
            );
        }
    });
}

// Función para guardar un cliente (crear o actualizar)
function guardarCliente() {
    // Obtener valores del formulario
    const formData = {
        id: $('#cliente-id').val(),
        nombre: $('#nombre').val().trim(),
        email: $('#email').val().trim(),
        telefono: $('#telefono').val().trim(),
        direccion: $('#direccion').val().trim()
    };

    // Validación básica
    if (!formData.nombre || !formData.email || !formData.telefono || !formData.direccion) {
        return alert('Por favor complete todos los campos');
    }

    const isEdit = !!formData.id;
    const request = {
        url: `http://localhost/proyecto/API/public/index.php/api/clientes/${formData.id || ''}`,
        type: isEdit ? 'PUT' : 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            nombre: formData.nombre,
            email: formData.email,
            telefono: formData.telefono,
            direccion: formData.direccion
        }),
        success: (response) => {
            alert(isEdit ? 'Cliente actualizado' : 'Cliente creado');
            resetForm();
            cargarClientes();
        },
        error: (xhr) => {
            const error = xhr.responseJSON?.error || 'Error desconocido';
            alert(`Error: ${error}`);
        }
    };

    $.ajax(request);
}

// Función para editar un cliente
function editarCliente(id) {
    $.ajax({
        url: `http://localhost/proyecto/API/public/index.php/api/clientes/${id}`,
        type: 'GET',
        dataType: 'json',
        success: function(cliente) {
            $('#cliente-id').val(cliente.id);
            $('#nombre').val(cliente.nombre);
            $('#email').val(cliente.email);
            $('#telefono').val(cliente.telefono);
            $('#direccion').val(cliente.direccion);

            $('#form-title').text('Editar Cliente');
            $('#cancelar-edicion').show();

            $('html, body').animate({ scrollTop: 0 }, 'slow');
        },
        error: function(error) {
            console.error('Error al cargar cliente:', error);
            alert('Error al cargar los datos del cliente');
        }
    });
}

// Función para eliminar un cliente
function eliminarCliente(id) {
    if (confirm('¿Está seguro de que desea eliminar este cliente?')) {
        $.ajax({
            url: `http://localhost/proyecto/API/public/index.php/api/clientes/${id}`,
            type: 'DELETE',
            success: function(response) {
                alert('Cliente eliminado correctamente');
                cargarClientes();
            },
            error: function(error) {
                console.error('Error al eliminar cliente:', error);
                alert('Error al eliminar el cliente');
            }
        });
    }
}

// Función para resetear el formulario
function resetForm() {
    $('#cliente-id').val('');
    $('#cliente-form')[0].reset();
    $('#form-title').text('Agregar Nuevo Cliente');
    $('#cancelar-edicion').hide();
}
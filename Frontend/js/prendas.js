$(document).ready(function() {
    // Cargar marcas para el select
    cargarMarcas();
    
    // Cargar todas las prendas al iniciar
    cargarPrendas();
    
    // Manejar envío del formulario
    $('#prenda-form').submit(function(e) {
        e.preventDefault();
        guardarPrenda();
    });
    
    // Manejar cancelar edición
    $('#cancelar-edicion').click(function() {
        resetForm();
    });
});

// Función para cargar las marcas en el select
function cargarMarcas() {
    $.ajax({
        url: 'http://localhost/proyecto/API/public/index.php/api/marcas/',
        type: 'GET',
        dataType: 'json',
        success: function(marcas) {
            let options = '<option value="">Seleccione una marca</option>';
            marcas.forEach(marca => {
                options += `<option value="${marca.id}">${marca.nombre}</option>`;
            });
            $('#marca_id').html(options);
        },
        error: function(error) {
            console.error('Error al cargar marcas:', error);
            alert('Error al cargar las marcas');
        }
    });
}

// Función para cargar todas las prendas
function cargarPrendas() {
    $.ajax({
        url: `http://localhost/proyecto/API/public/index.php/api/tipo_de_ropa`,
        type: 'GET',
        dataType: 'json',
        success: function(prendas) {
            let tbody = '';
            prendas.forEach(prenda => {
                tbody += `
                <tr>
                    <td>${prenda.id}</td>
                    <td>${prenda.nombre}</td>
                    <td>${prenda.marca_nombre || 'Sin marca'}</td>
                    <td>₡${parseFloat(prenda.precio).toFixed(2)}</td>
                    <td>${prenda.stock}</td>
                    <td>
                        <button class="btn btn-sm btn-warning me-2" onclick="editarPrenda(${prenda.id})">Editar</button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarPrenda(${prenda.id})">Eliminar</button>
                    </td>
                </tr>`;
            });
            $('#tabla-prendas tbody').html(tbody);
        },
        error: function(error) {
            console.error('Error al cargar prendas:', error);
            $('#tabla-prendas tbody').html(
                '<tr><td colspan="6">Error al cargar las prendas</td></tr>'
            );
        }
    });
}

// Función para guardar una prenda (crear o actualizar)
function guardarPrenda() {
    // Obtener valores del formulario
    const formData = {
        id: $('#prenda-id').val(),
        nombre: $('#nombre').val().trim(),
        marca_id: $('#marca_id').val(),
        precio: $('#precio').val(),
        stock: $('#stock').val()
    };

    // Validación básica
    if (!formData.nombre || !formData.marca_id || !formData.precio || !formData.stock) {
        return alert('Por favor complete todos los campos');
    }

    // Configurar la petición
    const isEdit = !!formData.id;
    const request = {
        url: `http://localhost/proyecto/API/public/index.php/api/tipo_de_ropa/${formData.id || ''}`,
        type: isEdit ? 'PUT' : 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            nombre: formData.nombre,
            marca_id: Number(formData.marca_id),
            precio: Number(formData.precio),
            stock: Number(formData.stock)
        }),
        success: (response) => {
            alert(isEdit ? 'Prenda actualizada' : 'Prenda creada');
            resetForm();
            cargarPrendas();
        },
        error: (xhr) => {
            const error = xhr.responseJSON?.error || 'Error desconocido';
            alert(`Error: ${error}`);
        }
    };

    // Enviar petición
    $.ajax(request);
}

// Función para editar una prenda
function editarPrenda(id) {
    // Cargar datos de la prenda
    $.ajax({
        url: `http://localhost/proyecto/API/public/index.php/api/tipo_de_ropa/${id}`,
        type: 'GET',
        dataType: 'json',
        success: function(prenda) {
            // Llenar formulario con datos existentes
            $('#prenda-id').val(prenda.id);
            $('#nombre').val(prenda.nombre);
            $('#marca_id').val(prenda.marca_id);
            $('#precio').val(prenda.precio);
            $('#stock').val(prenda.stock);
            
            // Cambiar título del formulario
            $('#form-title').text('Editar Prenda');
            $('#cancelar-edicion').show();
            
            // Desplazar al formulario
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        },
        error: function(error) {
            console.error('Error al cargar prenda:', error);
            alert('Error al cargar los datos de la prenda');
        }
    });
}

// Función para eliminar una prenda
function eliminarPrenda(id) {
    if (confirm('¿Está seguro de que desea eliminar esta prenda?')) {
        $.ajax({
            url: `http://localhost/proyecto/API/public/index.php/api/tipo_de_ropa/${id}`,
            type: 'DELETE',
            success: function(response) {
                alert('Prenda eliminada correctamente');
                cargarPrendas();
            },
            error: function(error) {
                console.error('Error al eliminar prenda:', error);
                alert('Error al eliminar la prenda');
            }
        });
    }
}

// Función para resetear el formulario
function resetForm() {
    $('#prenda-id').val('');
    $('#prenda-form')[0].reset();
    $('#form-title').text('Agregar Nueva Prenda');
    $('#cancelar-edicion').hide();
}
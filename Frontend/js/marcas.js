$(document).ready(function() {
    // Configuración base
    const API_BASE_URL = 'http://localhost/proyecto/API/public/index.php/api';
    
    // Cargar todas las marcas al iniciar
    cargarMarcas();

    // Función para mostrar carga
    function mostrarCarga() {
        $('#tabla-marcas tbody').html('<tr><td colspan="3" class="text-center"><div class="spinner-border"></div> Cargando...</td></tr>');
    }

    // Función para mostrar error
    function mostrarError(mensaje) {
        $('#tabla-marcas tbody').html(`<tr><td colspan="3" class="text-danger">${mensaje}</td></tr>`);
    }

    // Cargar todas las marcas
    function cargarMarcas() {
        mostrarCarga();
        
        $.ajax({
            url: `${API_BASE_URL}/marcas`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response && response.length > 0) {
                    renderizarMarcas(response);
                } else {
                    mostrarError('No hay marcas registradas');
                }
            },
            error: function(xhr) {
                let errorMsg = 'Error al cargar las marcas';
                try {
                    const err = JSON.parse(xhr.responseText);
                    errorMsg = err.message || errorMsg;
                } catch (e) {}
                mostrarError(errorMsg);
            }
        });
    }

    // Renderizar las marcas en la tabla
    function renderizarMarcas(marcas) {
        let html = '';
        marcas.forEach(marca => {
            html += `
            <tr data-id="${marca.id}">
                <td>${marca.id}</td>
                <td>${marca.nombre}</td>
                <td>
                    <button class="btn btn-sm btn-warning editar-marca">Editar</button>
                    <button class="btn btn-sm btn-danger eliminar-marca">Eliminar</button>
                </td>
            </tr>`;
        });
        $('#tabla-marcas tbody').html(html);
    }

    // Enviar formulario (crear/actualizar)
    $('#marca-form').on('submit', function(e) {
        e.preventDefault();
        
        const id = $('#marca-id').val();
        const nombre = $('#nombre').val();
        
        if (!nombre) {
            alert('El nombre es requerido');
            return;
        }

        const data = { nombre };
        const metodo = id ? 'PUT' : 'POST';
        const url = id ? `${API_BASE_URL}/marcas/${id}` : `${API_BASE_URL}/marcas`;

        $.ajax({
            url: url,
            type: metodo,
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: 'json',
            success: function(response) {
                if (id) {
                    alert('Marca actualizada correctamente');
                } else {
                    alert('Marca creada correctamente');
                    $('#marca-form')[0].reset();
                }
                cargarMarcas();
                $('#cancelar-edicion').hide();
                $('#form-title').text('Agregar Nueva Marca');
                $('#marca-id').val('');
            },
            error: function(xhr) {
                let errorMsg = 'Error al guardar la marca';
                try {
                    const err = JSON.parse(xhr.responseText);
                    errorMsg = err.message || errorMsg;
                } catch (e) {}
                alert(errorMsg);
            }
        });
    });

    // Editar marca
    $(document).on('click', '.editar-marca', function() {
        const fila = $(this).closest('tr');
        const id = fila.data('id');
        const nombre = fila.find('td:nth-child(2)').text();
        
        $('#marca-id').val(id);
        $('#nombre').val(nombre);
        $('#form-title').text('Editar Marca');
        $('#cancelar-edicion').show();
        $('html, body').animate({ scrollTop: 0 }, 'slow');
    });

    // Cancelar edición
    $('#cancelar-edicion').on('click', function() {
        $('#marca-form')[0].reset();
        $('#marca-id').val('');
        $('#form-title').text('Agregar Nueva Marca');
        $(this).hide();
    });

    // Eliminar marca
    $(document).on('click', '.eliminar-marca', function() {
        if (!confirm('¿Estás seguro de eliminar esta marca?')) {
            return;
        }
        
        const id = $(this).closest('tr').data('id');
        
        $.ajax({
            url: `${API_BASE_URL}/marcas/${id}`,
            type: 'DELETE',
            dataType: 'json',
            success: function(response) {
                alert('Marca eliminada correctamente');
                cargarMarcas();
            },
            error: function(xhr) {
                let errorMsg = 'Error al eliminar la marca';
                try {
                    const err = JSON.parse(xhr.responseText);
                    errorMsg = err.message || errorMsg;
                } catch (e) {}
                alert(errorMsg);
            }
        });
    });
});
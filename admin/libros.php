<?php 
include 'header.php'; 
include '../db.php'; // Conexión a la base de datos

session_start();

// Verificar si el usuario está autenticado y si es admin
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] !== 'Admin') {
    header("Location: ../index.php");
    exit();
}

// Inicializar el array de libros
$libros = [];

// Consulta a la base de datos para obtener los libros
$query = "SELECT * FROM libro";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $libros[] = $row;
    }
} else {
    echo "No se encontraron libros en la base de datos.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Libros</title>

    <!-- Cargar jQuery y SweetAlert -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .contenedor { width: 80%; margin: 0 auto; }
        .foto-libro { width: 100px; height: 150px; object-fit: cover; }
        .acciones { display: flex; justify-content: center; gap: 0.5rem; }
        .tabla-centrada td, .tabla-centrada th { text-align: center; vertical-align: middle; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2 class="titulo" style="font-family: 'Lilita One', cursive;">Gestión de Libros</h2>
    <button onclick="mostrarFormulario()" style="background-color: #F53756; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; margin-bottom: 1rem;">Agregar Libro</button>

    <table id="tablaLibros" class="tabla-centrada" style="width: 100%; border-collapse: collapse; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <thead style="background-color: #4CB8B3; color: white;">
            <tr>
                <th style="padding: 1rem;">Foto</th>
                <th style="padding: 1rem;">Título</th>
                <th style="padding: 1rem;">Cantidad</th>
                <th style="padding: 1rem;">Acciones</th>
            </tr>
        </thead>
        <tbody>
    <?php 
    if (!empty($libros)) { 
        foreach ($libros as $libro): ?>
            <tr id="fila-libro-<?php echo $libro['id']; ?>">
                <td style="padding: 1rem;">
                    <img src="../src/img/<?php echo htmlspecialchars($libro['imagen']); ?>" alt="Portada de <?php echo htmlspecialchars($libro['titulo']); ?>" class="foto-libro">
                </td>
                <td style="padding: 1rem;"><?php echo htmlspecialchars($libro['titulo']); ?></td>
                <td style="padding: 1rem;"><?php echo htmlspecialchars($libro['cantidad']); ?></td>
                <td style="padding: 1rem;">
                    <div class="acciones">
                        <button class="btnEditar" data-id="<?php echo $libro['id']; ?>" style="background-color: #4CB8B3; color: white; border: none; padding: 0.25rem 0.5rem; border-radius: 4px; cursor: pointer;">Editar</button>
                        <button class="btnEliminar" data-id="<?php echo $libro['id']; ?>" style="background-color: #F53756; color: white; border: none; padding: 0.25rem 0.5rem; border-radius: 4px; cursor: pointer;">Eliminar</button>
                    </div>
                </td>
            </tr>
        <?php endforeach;
    } else {
        echo "<tr><td colspan='4'>No hay libros disponibles</td></tr>";
    } ?>
    </tbody>
    </table>

    <!-- Formulario de Agregar/Editar -->
    <div id="formularioLibro" style="display: none; background-color: white; padding: 2rem; border-radius: 8px;">
        <h3>Agregar/Editar Libro</h3>
        <form id="formLibro" enctype="multipart/form-data">
        <input type="hidden" id="libroId" name="libroId">

    
    <!-- Campo para el título -->
    <div style="margin-bottom: 1rem;">
        <label for="titulo" style="display: block; margin-bottom: 0.5rem;">Título:</label>
        <input type="text" id="titulo" name="titulo" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <!-- Campo para la cantidad -->
    <div style="margin-bottom: 1rem;">
        <label for="cantidad" style="display: block; margin-bottom: 0.5rem;">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" required min="0" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <!-- Campo para el ID del autor -->
    <div style="margin-bottom: 1rem;">
        <label for="id_autor" style="display: block; margin-bottom: 0.5rem;">ID Autor:</label>
        <input type="number" id="id_autor" name="id_autor" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <!-- Campo para el ID de la editorial -->
    <div style="margin-bottom: 1rem;">
        <label for="id_editorial" style="display: block; margin-bottom: 0.5rem;">ID Editorial:</label>
        <input type="number" id="id_editorial" name="id_editorial" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <!-- Campo para el año de edición -->
    <div style="margin-bottom: 1rem;">
        <label for="anio_edicion" style="display: block; margin-bottom: 0.5rem;">Año de Edición:</label>
        <input type="date" id="anio_edicion" name="anio_edicion" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <!-- Campo para el número de páginas -->
    <div style="margin-bottom: 1rem;">
        <label for="num_pagina" style="display: block; margin-bottom: 0.5rem;">Número de Páginas:</label>
        <input type="number" id="num_pagina" name="num_pagina" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <!-- Campo para la descripción -->
    <div style="margin-bottom: 1rem;">
        <label for="descripcion" style="display: block; margin-bottom: 0.5rem;">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;"></textarea>
    </div>

    <!-- Campo para la foto del libro -->
    <div style="margin-bottom: 1rem;">
        <label for="foto" style="display: block; margin-bottom: 0.5rem;">Foto:</label>
        <input type="file" id="foto" name="foto" accept="image/*" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <!-- Previsualización de la imagen -->
    <div id="previewFoto" style="margin-bottom: 1rem; display: none;">
        <img id="fotoPreview" src="" alt="Vista previa de la foto" style="max-width: 200px; max-height: 300px;">
    </div>

    <!-- Botones de guardar y cancelar -->
    <button type="submit" style="background-color: #4CB8B3; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer;">Guardar</button>
    <button type="button" onclick="ocultarFormulario()" style="background-color: #ccc; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer;">Cancelar</button>
</form>

    </div>
</div>

<script>
// Función para mostrar el formulario de edición o agregar
function mostrarFormulario(id = null) {
    const form = document.getElementById('formLibro');
    const titulo = document.getElementById('formularioLibro').querySelector('h3');
    const previewFoto = document.getElementById('previewFoto');

    if (id) {
        $.ajax({
            url: '../apis/obtener_libros.php',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                console.log("Response from obtener_libros:", response);
                const libro = JSON.parse(response);
                titulo.textContent = 'Editar Libro';
                document.getElementById('libroId').value = libro.id;
                document.getElementById('titulo').value = libro.titulo;
                document.getElementById('cantidad').value = libro.cantidad;
                document.getElementById('fotoPreview').src = '../src/img/' + libro.imagen;
                previewFoto.style.display = 'block';
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener el libro:', xhr.responseText);
            }
        });
    } else {
        titulo.textContent = 'Agregar Libro';
        form.reset();
        document.getElementById('libroId').value = '';
        previewFoto.style.display = 'none';
    }
    document.getElementById('formularioLibro').style.display = 'block';
}

// Función para ocultar el formulario
function ocultarFormulario() {
    document.getElementById('formularioLibro').style.display = 'none';
}

// Función para eliminar un libro
function eliminarLibro(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esto",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../apis/eliminar_libro.php',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Eliminado!', response.message, 'success');
                        document.getElementById('fila-libro-' + id).remove();
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'Hubo un problema con la solicitud.', 'error');
                    console.error(xhr.responseText);
                }
            });
        }
    });
}

// Capturar evento de envío del formulario
$(document).ready(function() {
    $('#formLibro').on('submit', function(event) {
        event.preventDefault(); // Prevenir envío tradicional

        const formData = new FormData(this); // Recoger datos del formulario

        $.ajax({
            url: '../apis/editar_libro.php', // Cambia esto para llamar correctamente a tu API
            type: 'POST',
            data: formData,
            processData: false, // No procesar los datos automáticamente
            contentType: false, // No definir un tipo de contenido
            success: function(response) {
                console.log("Response from editar_libro:", response); // Verifica qué devuelve exactamente el servidor
                try {
                    const result = JSON.parse(response);
                    if (result.status === 'success') {
                        Swal.fire('Guardado!', result.message, 'success').then(() => {
                            location.reload(); // Recargar la página para mostrar cambios
                        });
                    } else {
                        Swal.fire('Error', result.message, 'error');
                    }
                } catch (e) {
                    console.error("Error al parsear el JSON: ", e, response);
                    Swal.fire('Error', 'La respuesta no es válida.', 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('Error', 'Hubo un problema con la solicitud.', 'error');
                console.error(xhr.responseText);
            }
        });
    });

    // Asociar el botón de editar al evento click
    $(document).on('click', '.btnEditar', function() {
        const id = $(this).data('id');
        mostrarFormulario(id);
    });

    // Asociar el botón de eliminar al evento click
    $(document).on('click', '.btnEliminar', function() {
        const id = $(this).data('id');
        eliminarLibro(id);
    });
});

// Previsualización de la imagen seleccionada
document.getElementById('foto').onchange = function(e) {
    const file = e.target.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        document.getElementById('fotoPreview').src = e.target.result;
        document.getElementById('previewFoto').style.display = 'block';
    }

    if (file) {
        reader.readAsDataURL(file);
    }
}
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>

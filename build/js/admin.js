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
            // Aquí debes enviar una solicitud AJAX para eliminar el libro
            $.ajax({
                url: 'eliminar_libro.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    Swal.fire('Eliminado!', 'El libro ha sido eliminado.', 'success');
                    location.reload(); // Recargar la página para actualizar la tabla
                }
            });
        }
    });
}
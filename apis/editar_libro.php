<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $libroId = isset($_POST['libroId']) ? $_POST['libroId'] : null;
    $titulo = $_POST['titulo'];
    $cantidad = $_POST['cantidad'];
    $id_autor = $_POST['id_autor'];
    $id_editorial = $_POST['id_editorial'];
    $anio_edicion = $_POST['anio_edicion'];
    $num_pagina = $_POST['num_pagina'];
    $descripcion = $_POST['descripcion'];
    
    // Procesar la imagen si se subió una
    $imagen = '';
    if (!empty($_FILES['foto']['name'])) {
        $imagen = $_FILES['foto']['name'];
        $ruta = '../src/img/' . $imagen;
        move_uploaded_file($_FILES['foto']['tmp_name'], $ruta);
    }

    // Si hay un libroId, actualizamos el libro
    if ($libroId) {
        if ($imagen) {
            $query = "UPDATE libro SET titulo=?, cantidad=?, id_autor=?, id_editorial=?, anio_edicion=?, num_pagina=?, descripcion=?, imagen=? WHERE id=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('siississi', $titulo, $cantidad, $id_autor, $id_editorial, $anio_edicion, $num_pagina, $descripcion, $imagen, $libroId);
        } else {
            $query = "UPDATE libro SET titulo=?, cantidad=?, id_autor=?, id_editorial=?, anio_edicion=?, num_pagina=?, descripcion=? WHERE id=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('siissisi', $titulo, $cantidad, $id_autor, $id_editorial, $anio_edicion, $num_pagina, $descripcion, $libroId);
        }
    } else {
        // Si no hay libroId, insertamos un nuevo libro
        $query = "INSERT INTO libro (titulo, cantidad, id_autor, id_editorial, anio_edicion, num_pagina, descripcion, imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('siississ', $titulo, $cantidad, $id_autor, $id_editorial, $anio_edicion, $num_pagina, $descripcion, $imagen);
    }

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Libro guardado correctamente']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al guardar el libro']);
    }

    $stmt->close();
    $conn->close();
}
?>

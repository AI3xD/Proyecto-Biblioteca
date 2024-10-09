<?php
include '../db.php'; // Incluir la conexión a la base de datos

header('Content-Type: application/json'); // Asegurarse de que el contenido devuelto sea JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si se ha recibido un ID
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado']);
        exit();
    }

    $id = $_POST['id']; // Obtener el ID enviado mediante AJAX

    // Eliminar los préstamos relacionados con este libro antes de eliminar el libro
    $queryPrestamo = "DELETE FROM prestamo WHERE id_libro = ?";
    $stmtPrestamo = $conn->prepare($queryPrestamo);
    $stmtPrestamo->bind_param('i', $id);

    if (!$stmtPrestamo->execute()) {
        echo json_encode(['status' => 'error', 'message' => 'Error al eliminar los préstamos relacionados']);
        exit();
    }

    // Ahora proceder con la eliminación del libro
    $query = "DELETE FROM libro WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta']);
        exit();
    }

    $stmt->bind_param('i', $id); // 'i' significa que el parámetro es un entero

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Libro eliminado correctamente']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el libro']);
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $stmtPrestamo->close();
    $conn->close();
} else {
    // Si no se ha enviado una solicitud POST
    echo json_encode(['status' => 'error', 'message' => 'Método de solicitud no válido']);
}
?>

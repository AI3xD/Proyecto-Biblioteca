<?php
include '../db.php'; // Asegúrate de incluir la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; // Obtener el ID del libro enviado mediante AJAX

    // Consulta para obtener los detalles del libro según su ID
    $query = "SELECT * FROM libro WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id); // 'i' indica que el parámetro es un entero
    $stmt->execute();
    
    // Obtener el resultado de la consulta
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $libro = $result->fetch_assoc(); // Obtener los datos del libro
        echo json_encode($libro); // Enviar los datos del libro como respuesta en JSON
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Libro no encontrado']);
    }

    $stmt->close();
    $conn->close();
}
?>

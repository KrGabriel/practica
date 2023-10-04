<?php
require_once("db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Obtener el ID del usuario a eliminar
    $userId = $_GET['id'];

    // Consulta SQL para eliminar un usuario por su ID
    $sql = "DELETE FROM usuarios WHERE id = ?";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Vincular el parámetro y ejecutar la consulta
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            // Usuario eliminado exitosamente
            echo "Usuario eliminado con éxito.";
        } else {
            // Error al eliminar el usuario
            echo "Error al eliminar el usuario: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        // Error en la preparación de la consulta
        echo "Error en la preparación de la consulta: " . $conn->error;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!-- Puedes agregar un formulario para seleccionar el usuario a eliminar si lo deseas -->
<!DOCTYPE html>
<html>
<head>
    <title>Eliminar Usuario</title>
</head>
<body>
    <h1>Eliminar Usuario</h1>
    <p>Ingrese el ID del usuario que desea eliminar:</p>
    <form method="get" action="delete_user.php">
        <input type="text" name="id" required>
        <input type="submit" value="Eliminar Usuario">
    </form>
</body>
</html>

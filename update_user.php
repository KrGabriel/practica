<?php
// Incluye el archivo de conexión a la base de datos
require_once("db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Obtener el ID del usuario a actualizar
    $userId = $_POST['id'];
    
    // Recoger los datos del formulario
    $newUsername = $_POST['new_username'];
    $newPassword = $_POST['new_password'];

    // Hash de la nueva contraseña (opcional)
    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Consulta SQL para actualizar un usuario
    $sql = "UPDATE usuarios SET nombre_usuario = ?, contraseña = ? WHERE id = ?";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Vincular los parámetros y ejecutar la consulta
        $stmt->bind_param("ssi", $newUsername, $hashedNewPassword, $userId);

        if ($stmt->execute()) {
            // Usuario actualizado exitosamente
            echo "Usuario actualizado con éxito.";
        } else {
            // Error al actualizar el usuario
            echo "Error al actualizar el usuario: " . $stmt->error;
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

<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Usuario</title>
</head>
<body>
    <h1>Actualizar Usuario</h1>
    <form method="post" action="update_user.php" onsubmit="return validateForm()">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"> 
        <label>Nombre de usuario:</label>
        <input type="text" name="new_username" required><br>
        <label>Nueva Contraseña:</label>
        <input type="password" name="new_password" id="new_password" required><br>
        <label>Confirmar Nueva Contraseña:</label>
        <input type="password" name="confirm_new_password" id="confirm_new_password" required><br>
        <input type="submit" value="Actualizar Usuario">
    </form>

    <script>
        function validateForm() {
            var newPassword = document.getElementById("new_password").value;
            var confirmNewPassword = document.getElementById("confirm_new_password").value;

            if (newPassword !== confirmNewPassword) {
                alert("Las contraseñas no coinciden.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
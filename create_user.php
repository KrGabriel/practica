<?php
require_once("db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash de la contraseña (se recomienda usar contraseñas seguras y almacenarlas de manera segura)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Consulta SQL para insertar un nuevo usuario
    $sql = "INSERT INTO usuarios (nombre_usuario, contraseña) VALUES (?, ?)";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Vincular los parámetros y ejecutar la consulta
        $stmt->bind_param("ss", $username, $hashedPassword);

        if ($stmt->execute()) {
            // Usuario creado exitosamente
            echo "Usuario creado exitosamente.";
        } else {
            // Error al crear el usuario
            echo "Error al crear el usuario: " . $stmt->error;
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
    <title>Crear Usuario</title>
</head>
<body>
    <h1>Crear Usuario</h1>
    <form method="post" action="create_user.php" onsubmit="return validateForm()">
        <label>Nombre de usuario:</label>
        <input type="text" name="username" required><br>
        <label>Contraseña:</label>
        <input type="password" name="password" id="password" required><br>
        <label>Confirmar Contraseña:</label>
        <input type="password" name="confirm_password" id="confirm_password" required><br>
        <input type="submit" value="Crear Usuario">
    </form>

    <script>
        function validateForm() {
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;

            if (password !== confirm_password) {
                alert("Las contraseñas no coinciden.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>


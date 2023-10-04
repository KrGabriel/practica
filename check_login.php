<?php
// Incluye el archivo de conexión a la base de datos
require_once("db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta SQL para obtener la contraseña almacenada del usuario
    $sql = "SELECT id, nombre_usuario, contraseña FROM usuarios WHERE nombre_usuario = ?";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Vincular el parámetro y ejecutar la consulta
        $stmt->bind_param("s", $username);
        $stmt->execute();
        
        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // El usuario existe en la base de datos
            $user = $result->fetch_assoc();
            
            // Verificar la contraseña
            if (password_verify($password, $user['contraseña'])) {
                // Contraseña válida, inicia la sesión
                session_start();
                $_SESSION['authenticated'] = true;
                $_SESSION['user_id'] = $user['id'];
                
                // Redirige al usuario a una página de inicio
                header("Location: index.php");
                exit();
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "Nombre de usuario no encontrado.";
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

<?php
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {

    include "../db.php"; // Incluir archivo de conexión a la base de datos
    include "func-validation.php"; // Incluir función auxiliar de validación

    // Obtener datos del formulario y almacenarlos en variables
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validación simple del formulario
    $text = "Correo electrónico";
    $location = "../login.php";
    $ms = "error";
    is_empty($email, $text, $location, $ms, "");

    $text = "Contraseña";
    is_empty($password, $text, $location, $ms, "");

    // Buscar el correo electrónico en la base de datos
    $sql = "SELECT * FROM admin WHERE email=? AND Rol != 'superadmin'"; // Excluir superadmin
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    // Si el correo electrónico existe
    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch();
        $user_id = $user['id'];
        $user_email = $user['email'];
        $user_password = $user['password'];
        $user_role = $user['Rol']; // Acceder al campo de rol

        if ($email === $user_email) {
            if (password_verify($password, $user_password)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_email'] = $user_email;

                // Redireccionar según el rol
                switch ($user_role) {
                    case 'admin':
                        header("Location: ../admin.php");
                        break;
                    case 'customer':
                        header("Location: ../index.php"); // Reemplazar con la sección de clientes
                        break;
                    default:
                        // Manejar roles inesperados
                        header("Location: ../login.php?error=Rol inválido");
                        exit;
                }
            } else {
                // Mensaje de error
                $em = "Correo electrónico o contraseña incorrectos";
                header("Location: ../login.php?error=$em");
                exit;
            }
        } else {
            // Mensaje de error
            $em = "Correo electrónico o contraseña incorrectos";
            header("Location: ../login.php?error=$em");
            exit;
        }
    } else {
        // Mensaje de error
        $em = "Correo electrónico o contraseña incorrectos";
        header("Location: ../login.php?error=$em");
        exit;
    }
} else {
    // Redireccionar a "../login.php"
    header("Location: ../login.php");
    exit;
}
?>
<?php 
session_start();

// En general se hacen validaciones para agregar a un autor

// Se comprueba si el administrador inició sesión
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    // Conexión base de datos
    include "../db.php";

    // Se comprueba si se pone el id de la categoría
    if (isset($_GET['id'])) {

        // Obtener datos de la solicitud GET y almacenarlos en variables
        $id = $_GET['id'];

        // Validación del formulario
        if (empty($id)) {
            $em = "Ha Ocurrido un Error";
            header("Location: ../admin.php?error=$em");
            exit;
        } else {
            // Eliminamos los libros de la base de datos
            $sql = "DELETE FROM categoria WHERE id=?";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$id]);

            // Verifica si no hay ningún error al eliminar los datos
            if ($res) {
                $sm = "Removido Correctamente";
                header("Location: ../admin.php?success=$sm");
                exit;
            } else {
                $em = "Ha Ocurrido un Error";
                header("Location: ../admin.php?error=$em");
                exit;
            }
        }
    } else {
        header("Location: ../admin.php");
        exit;
    }

} else {
    header("Location: ../login.php");
    exit;
}
?>
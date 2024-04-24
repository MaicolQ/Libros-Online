<?php 
session_start();

// En general se hacen validaciones para agregar a una categoría

// Se comprueba si el administrador inició sesión
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

    // Conexión a la base de datos
    include "../db.php";

    // Se comprueba si se envía el nombre de la categoría
    if (isset($_POST['nombre_categoria']) && isset($_POST['categoria_id'])) {

        // Obtener datos de la solicitud POST y almacenarlos en variables
        $nombre = $_POST['nombre_categoria'];
        $id = $_POST['categoria_id'];

        // Validación del formulario
        if (empty($nombre)){
            $em = "El nombre de la Categoría es Obligatorio";
            header("Location: ../editar_categoria.php?error=$em&id=$id");
            exit;
        } else {
            // Actualizamos datos en la base de datos
            $sql = "UPDATE categoria SET nombre=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$nombre, $id]);

            // Verifica que no haya errores mientras actualizamos los datos
            if ($res) {
                // Aparecerá mensaje de éxito al actualizar la categoría
                $sm = "Actualizado Correctamente";
                header("Location: ../editar_categoria.php?success=$sm&id=$id");
                exit;
            } else {
                // Aparecerá un mensaje de error si no se actualiza el dato correctamente
                $em = "Ha ocurrido un error";
                header("Location: ../editar_categoria.php?error=$em");
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
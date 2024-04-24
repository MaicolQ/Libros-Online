<?php 
session_start();

// En general se hacen validaciones para agregar a un autor

// Se comprueba si el administrador inició sesión
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

    // Conexión a la base de datos
    include "../db.php";

    // Se comprueba si se envía el nombre del autor
    if (isset($_POST['nombre_autor']) && isset($_POST['autor_id'])) {

        // Obtener datos de la solicitud POST y almacenarlos en variables
        $nombre = $_POST['nombre_autor'];
        $id = $_POST['autor_id'];

        // Validación del formulario
        if (empty($nombre)){
            $em = "El nombre del Autor es Obligatorio";
            header("Location: ../editar_autor.php?error=$em&id=$id");
            exit;
        } else {
            // Actualizamos datos en la base de datos
            $sql = "UPDATE autores SET nombre=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$nombre, $id]);

            // Verifica que no haya errores mientras actualizamos los datos
            if ($res) {
                // Aparecerá mensaje de éxito al actualizar la categoría
                $sm = "Actualizado Correctamente";
                header("Location: ../editar_autor.php?success=$sm&id=$id");
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
<?php
session_start();

// En general se hacen validaciones para agregar una categoría

// Se comprueba si el administrador inició sesión
if (
    isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])
) {

    // Conexión a la base de datos
    include "../db.php";

    // Se comprueba si se envió el nombre de la categoría
    if (isset($_POST['nombre_categoria'])) {

        // Obtener datos de la solicitud POST y guardarlo en una variable
        $nombre = $_POST['nombre_categoria'];

        // Validación del formulario
        if (empty($nombre)) {
            $em = "El nombre de la Categoría es Obligatorio";
            header("Location: ../agregar_categoria.php?error=$em");
            exit;
        } else {
            // Insertamos datos en la base de datos
            $sql = "INSERT INTO categoria (nombre) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$nombre]);

            // Verifica que no haya errores mientras insertamos los datos
            if ($res) {
                // Aparecerá mensaje de éxito insertando una categoría agregada
                $sm = "Creado Correctamente";
                header("Location: ../agregar_categoria.php?success=$sm");
                exit;
            } else {
                // Aparecerá un mensaje de error si no se inserta un dato correctamente
                $em = "Ha ocurrido un error";
                header("Location: ../agregar_categoria.php?error=$em");
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
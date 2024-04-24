<<?php
session_start();

// En general se hace validaciones para agregar a un autor

// Se comprueba si el administrador inició sesión
if (
    isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])
) {

    // Conexión a la base de datos
    include "../db.php";

    // Se comprueba si se envió el nombre del autor
    if (isset($_POST['nombre_autor'])) {

        // Obtener datos de la solicitud POST y guardarlo en una variable
        $nombre = $_POST['nombre_autor'];

        // Validación del formulario
        if (empty($nombre)) {
            $em = "El nombre de Autor es obligatorio";
            header("Location: ../agregar_autor.php?error=$em");
            exit;
        } else {
            // Insertamos datos en la base de datos
            $sql = "INSERT INTO autores (nombre) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$nombre]);

            // Verifica que no haya errores mientras insertamos los datos
            if ($res) {
                // Aparecerá mensaje de éxito insertando un autor correctamente
                $sm = "Creado Correctamente";
                header("Location: ../agregar_autor.php?success=$sm");
                exit;
            } else {
                // Aparecerá un mensaje de error si no se inserta un dato correctamente
                $em = "Ha ocurrido un error";
                header("Location: ../agregar_autor.php?error=$em");
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
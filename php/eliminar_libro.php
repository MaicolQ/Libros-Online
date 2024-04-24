<?php 
session_start();

/**En general se hace validaciones para agregar a un autor**/

# se comprueba si el administrador inicio sesión
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    # conexión base de datos
    include "../db.php";

    /**Se comprueba si se pone el id del libro**/

    if (isset($_GET['id'])) {

        /**obtener datos de la solicitud GET y almacenarlos en var **/
        $id = $_GET['id'];

        # validación del formulario
        if (empty($id)) {
            $em = "Ha Ocurrido un Error";
            header("Location: ../admin.php?error=$em");
            exit;
        } else {

            # GET. obtenemos los libros de la base de datos
            $sql2 = "SELECT * FROM libros WHERE id=?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute([$id]);
            $el_libro = $stmt2->fetch();

            if ($stmt2->rowCount() > 0) {

                # Eliminamos los libros de la base de datos
                $sql = "DELETE FROM libros WHERE id=?";
                $stmt = $conn->prepare($sql);
                $res = $stmt->execute([$id]);

                # verifica si no hay ningún error al eliminar los datos

                if ($res) {
                    # eliminar caratula_libro actual y el archivo

                    $cubrir = $el_libro['cubrir'];
                    $archivo = $el_libro['archivo'];
                    $c_b_c ="../uploads/cover/$cubrir";
                    $c_f ="../uploads/files/$cubrir";

                    unlink($c_b_c);
                    unlink($c_f);

                    # aparecera mensaje de exito insertando una categoria agregada
                    $sm = "Removido Correctamente";
                    header("Location: ../admin.php?success=$sm");
                    exit;
                } else {
                    # aparecera un error de mensaje si no se inserta un dato correctamente
                    $em = "Ha ocurrido un error";
                    header("Location: ../admin.php?error=$em");
                    exit;
                }

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
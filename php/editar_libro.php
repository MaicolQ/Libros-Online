<?php 
session_start();

// En general se hacen validaciones para agregar a un libro

// Se comprueba si el administrador inició sesión
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    // Conexión base de datos
    include "../db.php";

    // Validaciones adicionales
    include "func-validation.php";
    include "funcion_archivos.php";

    // Si todos los campos de entrada están llenos
    if (isset($_POST['libro_id']) &&
        isset($_POST['titulo_libro']) &&
        isset($_POST['libro_descripcion']) &&
        isset($_POST['autor_libro']) &&
        isset($_POST['categoria_libro']) &&
        isset($_FILES['caratula_libro']) &&
        isset($_FILES['archivo']) &&
        isset($_POST['portada_actual']) &&
        isset($_POST['portada_archivo'])) {

        // Obtener datos de la solicitud POST y almacenarlos en variables
        $id = $_POST['libro_id'];
        $titulo = $_POST['titulo_libro'];
        $descripcion = $_POST['libro_descripcion'];
        $autor = $_POST['autor_libro'];
        $categorias = $_POST['categoria_libro'];

        // Obtener la portada y el archivo actuales de la solicitud POST y guardarlos en variables
        $portada_actual = $_POST['portada_actual'];
        $portada_archivo = $_POST['portada_archivo'];

        // Validación del formulario
        $text = "el Titulo del Libro";
        $location = "../editar_libro.php";
        $ms = "id=$id&error";
        is_empty($titulo, $text, $location, $ms, "");

        $text = "la Descripcion del Libro";
        is_empty($descripcion, $text, $location, $ms, "");

        $text = "el Autor del Libro";
        is_empty($autor, $text, $location, $ms, "");

        $text = "la Categoria del Libro";
        is_empty($categorias, $text, $location, $ms, "");

        // El administrador podrá actualizar la portada del libro
        if (!empty($_FILES['caratula_libro']['nombre'])) {
            // Si el administrador intenta actualizar ambos
            if (!empty($_FILES['archivo']['nombre'])) {
                // Actualizar ambos aquí
                // Actualizamos archivos
                $caratula_libro = upload_file($_FILES['caratula_libro'], array("jpg", "jpeg", "png"), "cover");
                $archivo = upload_file($_FILES['archivo'], array("pdf", "docx", "pptx"), "files");

                // Si ocurre un error al cargar
                if ($caratula_libro['status'] == "error" || $archivo['status'] == "error") {
                    $em = $caratula_libro['data'];
                    header("Location: ../editar_libro.php?error=$em&id=$id");
                    exit;
                } else {
                    // Ubicación actual de la portada del libro
                    $c_p_book_cover = "../uploads/cover/$portada_actual";
                    $c_p_file = "../uploads/files/$portada_archivo";

                    // Eliminar del servidor
                    unlink($c_p_book_cover);
                    unlink($c_p_file);

                    // Obteniendo el nuevo nombre de archivo y el nuevo nombre de portada del libro
                    $file_URL = $archivo['data'];
                    $covertura_libro_URL = $caratula_libro['data'];

                    // Actualizar solo los datos
                    $sql = "UPDATE libros SET titulo=?, autor_id=?, descripcion=?, categoria_id=?, cubrir=?, archivo=? WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $res = $stmt->execute([$titulo, $autor, $descripcion, $categorias, $covertura_libro_URL, $file_URL, $id]);

                    if ($res) {
                        $sm = "Actualizado Correctamente";
                        header("Location: ../editar_libro.php?success=$sm&id=$id");
                        exit;
                    } else {
                        $em = "Ha ocurrido un error";
                        header("Location: ../editar_libro.php?error=$em&id=$id");
                        exit;
                    }
                }
            } else {
                // Actualizar solo la portada del libro
                $caratula_libro = upload_file($_FILES['caratula_libro'], array("jpg", "jpeg", "png"), "cover");

                // Si ocurre un error al cargar
                if ($caratula_libro['status'] == "error") {
                    $em = $caratula_libro['data'];
                    header("Location: ../editar_libro.php?error=$em&id=$id");
                    exit;
                } else {
                    // Ubicación actual de la portada del libro
                    $c_p_book_cover = "../uploads/cover/$portada_actual";

                    // Eliminar del servidor
                    unlink($c_p_book_cover);

                    // Obteniendo el nuevo nombre de portada del libro
                    $covertura_libro_URL = $caratula_libro['data'];

                    // Actualizar solo los datos
                    $sql = "UPDATE libros SET titulo=?, autor_id=?, descripcion=?, categoria_id=?, cubrir=? WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $res = $stmt->execute([$titulo, $autor, $descripcion, $categorias, $covertura_libro_URL, $id]);

                    if ($res) {
                        $sm = "Actualizado Correctamente";
                        header("Location: ../editar_libro.php?success=$sm&id=$id");
                        exit;
                    } else {
                        $em = "Ha ocurrido un error";
                        header("Location: ../editar_libro.php?error=$em&id=$id");
                        exit;
                    }
                }
            }
        } else {
            // El administrador actualizará solo el archivo
            if (!empty($_FILES['archivo']['nombre'])) {
                // Actualizar solo el archivo
                $archivo = upload_file($_FILES['archivo'], array("pdf", "docx", "pptx"), "files");

                // Si ocurre un error al cargar
                if ($archivo['status'] == "error") {
                    $em = $archivo['data'];
                    header("Location: ../editar_libro.php?error=$em&id=$id");
                    exit;
                } else {
                    // Ubicación actual del archivo
                    $c_p_file = "../uploads/files/$portada_archivo";

                    // Eliminar del servidor
                    unlink($c_p_file);

                    // Obteniendo el nuevo nombre de archivo
                    $file_URL = $archivo['data'];

                    // Actualizar solo los datos
                    $sql = "UPDATE libros SET titulo=?, autor_id=?, descripcion=?, categoria_id=?, archivo=? WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $res = $stmt->execute([$titulo, $autor, $descripcion, $categorias, $file_URL, $id]);

                    if ($res) {
                        $sm = "Actualizado Correctamente";
                        header("Location: ../editar_libro.php?success=$sm&id=$id");
                        exit;
                    } else {
                        $em = "Ha ocurrido un error";
                        header("Location: ../editar_libro.php?error=$em&id=$id");
                        exit;
                    }
                }
            } else {
                // Actualizar solo los datos
                $sql = "UPDATE libros SET titulo=?, autor_id=?, descripcion=?, categoria_id=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $res = $stmt->execute([$titulo, $autor, $descripcion, $categorias, $id]);

                if ($res) {
                    $sm = "Actualizado Correctamente";
                    header("Location: ../editar_libro.php?success=$sm&id=$id");
                    exit;
                } else {
                    $em = "Ha ocurrido un error";
                    header("Location: ../editar_libro.php?error=$em&id=$id");
                    exit;
                }
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

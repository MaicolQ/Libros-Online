<?php
session_start();

// En general se hacen validaciones para agregar un libro

// Se comprueba si el administrador inició sesión
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    // Conexión base de datos
    include "../db.php";

    // Validación auxiliar de validación
    include "func-validation.php";

    // Función auxiliar de carga de archivos
    include "funcion_archivos.php";

    // Si todos los campos de entrada están llenos
    if (
        isset($_POST['titulo_libro']) &&
        isset($_POST['libro_descripcion']) &&
        isset($_POST['autor_libro']) &&
        isset($_POST['categoria_libro']) &&
        isset($_FILES['caratula_libro']) &&
        isset($_FILES['archivo']) &&
        isset($_POST['opcion'])
    ) {
        // Obtener datos de la solicitud POST y almacenarlos en variables
        $titulo = $_POST['titulo_libro'];
        $descripcion = $_POST['libro_descripcion'];
        $autor = $_POST['autor_libro'];
        $categorias = $_POST['categoria_libro'];
        $opcion = $_POST['opcion'];

        // Verificar si la opción es "de pago"
        if ($opcion == 'de_pago') {
            // Verificar si se envió el precio y validarlo
            if (isset($_POST['precio']) && !empty($_POST['precio'])) {
                $precio = $_POST['precio'];
                // Aquí puedes realizar más validaciones si es necesario
            } else {
                // Si no se envió el precio, redirigir con un mensaje de error
                header("Location: ../agregar_libro.php?error=El precio es requerido para libros de pago");
                exit;
            }
        } else {
            // Si la opción no es "de pago", establecer el precio como NULL
            $precio = NULL;
        }

        // Si la opción seleccionada es "gratis", establecer el valor del campo "gratis" como 1, de lo contrario, dejarlo como 0
        $gratis = ($_POST['opcion'] == 'gratis') ? 1 : 0;

        // Formato de datos URL
        $user_input = 'titulo=' . $titulo . '&categoria_id=' . $categorias . '&desc=' . $descripcion . '&autor_id=' . $autor;

        // Validación de formulario simple
        is_empty($titulo, "el Título del Libro", "../agregar_libro.php", "error", $user_input);
        is_empty($descripcion, "la Descripción del Libro", "../agregar_libro.php", "error", $user_input);
        is_empty($autor, "el Autor del Libro", "../agregar_libro.php", "error", $user_input);
        is_empty($categorias, "la Categoría del Libro", "../agregar_libro.php", "error", $user_input);

        // Cargar la portada del libro
        $allowed_image_exs = array("jpg", "jpeg", "png");
        $path = "cover";
        $caratula_libro = upload_file($_FILES['caratula_libro'], $allowed_image_exs, $path);

        // Si ocurre un error al cargar la portada del libro
        if ($caratula_libro['status'] == "error") {
            $em = $caratula_libro['data'];
            // Redirigir a '../agregar_libro.php' y pasar el mensaje de error & user_input
            header("Location: ../agregar_libro.php?error=$em&$user_input");
            exit;
        } else {
            // Cargar los archivos
            $allowed_file_exs = array("pdf", "docx", "pptx");
            $path = "files";
            $archivo = upload_file($_FILES['archivo'], $allowed_file_exs, $path);

            // Si ocurre un error al cargar los archivos
            if ($archivo['status'] == "error") {
                $em = $archivo['data'];
                // Redirigir a '../add-book.php' y pasar el mensaje de error & user_input
                header("Location: ../agregar_libro.php?error=$em&$user_input");
                exit;
            } else {
                // Obtener el nuevo nombre de archivo y nombre de la portada del libro
                $file_URL = $archivo['data'];
                $covertura_libro_URL = $caratula_libro['data'];

                // Insertar datos en la base de datos
                $sql = "INSERT INTO libros (titulo, autor_id, descripcion, categoria_id, cubrir, archivo, precio, gratis) VALUES (?,?,?,?,?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $res = $stmt->execute([$titulo, $autor, $descripcion, $categorias, $covertura_libro_URL, $file_URL, $precio, $gratis]);

                // Verificar que no haya errores mientras insertamos los datos
                if ($res) {
                    // Aparecerá mensaje de éxito insertando un libro correctamente
                    $sm = "El Libro ha sido Creado Correctamente";
                    header("Location: ../agregar_libro.php?success=$sm");
                    exit;
                } else {
                    // Aparecerá un error de mensaje si no se inserta un dato correctamente
                    $em = "Ha ocurrido un error";
                    header("Location: ../agregar_autor.php?error=$em");
                    exit;
                }
            }
        }
    } else {
        header("Location: ../agregar_libro.php?error=No se enviaron todos los datos necesarios");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
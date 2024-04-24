<?php

#obtener todas las funciones de los libros
function get_all_books($con)
{
    $sql = "SELECT * FROM libros ORDER BY id DESC";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $libros = $stmt->fetchAll();
        # code...
    } else {
        $libros = 0;
    }
    return $libros;

}

#obtener la funcion Libro por ID
function get_libro($con, $id)
{
    $sql = "SELECT * FROM libros WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        $libro = $stmt->fetch();
        # code...
    } else {
        $libro = 0;
    }
    return $libro;

}

#funcion para buscar libros
function search_books($con, $key)
{

    #creando un algoritmo de búsqueda simple
    $key = "%{$key}%";
    $sql = "SELECT * FROM libros WHERE titulo LIKE ? OR descripcion LIKE ?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$key, $key]);

    if ($stmt->rowCount() > 0) {
        $libros = $stmt->fetchAll();
        # code...
    } else {
        $libros = 0;
    }
    return $libros;

}

# obtener libros por categoria
function get_books_by_category($con, $id)
{
    $sql = "SELECT * FROM libros WHERE categoria_id=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        $libros = $stmt->fetchAll();
        # code...
    } else {
        $libros = 0;
    }
    return $libros;

}

# obtener libros por por autor
function get_books_by_autor($con, $id)
{
    $sql = "SELECT * FROM libros WHERE autor_id=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        $libros = $stmt->fetchAll();
        # code...
    } else {
        $libros = 0;
    }
    return $libros;

}
?>
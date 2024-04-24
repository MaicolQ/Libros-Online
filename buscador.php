<?php
session_start();

#si la clave de búsqueda no está configurada o está vacía
if (!isset($_GET['key']) || empty($_GET['key'])) {
  header("Location: index.php");
  exit;
}
$key = $_GET['key'];

#funcion de ayuda de libro
include "db.php";

#funcion de ayuda de libro
include "php/funcion_libro.php";
$libros = search_books($conn, $key);

#funcion de ayuda de autor
include "php/func-author.php";
$autores = get_all_author($conn);

#funcion de ayuda de categoria
include "php/funcion_categoria.php";
$categoria = get_all_categoria($conn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title>Document</title>

  <!--Boostrap 5 cdn-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <!--Boostrap 5 js cdn-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>

  <link rel="stylesheet" href="css/style2.css">
</head>
<body>
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Libros</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Tienda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contacto</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <?php if (isset($_SESSION['user_id'])) {
                ?>

                <a class="nav-link" href="admin.php">Administrador</a>

              <?php } else { ?>
                <!--esta es la direccion del inicio de sesion-->
                <a class="nav-link" href="login.php">Login</a>
              <?php } ?>
            </li>
          </ul>
        </div>
      </div>
    </nav><br>

    Resultados de búsqueda <b><?= $key ?></b>
    <div class="d-flex pt-3">
      <?php if ($libros == 0) { ?>

        <div class="alert alert-warning text-center p-5 pdf-list" role="alert">
          <img src="img/buscador_onfile.png" width="100">
          <br>
          No se encuentra el libro <b>"<?= $key ?>"</b> en la base de datos
        </div>

      <?php } else { ?>
        <div class="pdf-list d-flex flex-wrap">
          <?php foreach ($libros as $libro) { ?>

            <div class="card m-1">
              <img src="uploads/cover/<?= $libro['cubrir'] ?>" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title"><?= $libro['titulo'] ?></h5>
                <p class="card-text">

                  <i><b>Por:
                      <?php foreach ($autores as $autor) {
                        if ($autor['id'] == $libro['autor_id']) {
                          echo $autor['nombre'];
                          break;
                        } ?>
                      <?php } ?>
                      <br></b></i>

                  <?= $libro['descripcion'] ?>

                  <br><i><b>Categoría:

                      <?php foreach ($categoria as $categorias) {
                        if ($categorias['id'] == $libro['categoria_id']) {
                          echo $categorias['nombre'];
                          break;
                        } ?>
                      <?php } ?>
                      <br></b></i>
                  <!--ponemos un codigo para abrir y descarga el libro-->

                </p>
                <a href="uploads/files/<?= $libro['archivo'] ?>" class="btn btn-success">Abrir</a>

                <a href="uploads/files/<?= $libro['archivo'] ?>" class="btn btn-primary"
                  download="<?= $libro['titulo'] ?>">Descargar</a>
              </div>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </div>
</body>
</html>
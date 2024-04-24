<?php
session_start();

#si no se establece el ID del Autor
if (!isset($_GET['id'])) {
  header("Location: index.php");
  exit;
}

#Obtener ID del Autor de la solicitud GET
$id = $_GET['id'];

#funcion de ayuda de libro
include "db.php";

#funcion de ayuda de libro
include "php/funcion_libro.php";
$libros = get_books_by_autor($conn, $id);

#funcion de ayuda de autor
include "php/func-author.php";
$autores = get_all_author($conn);
$current_autor = get_author($conn, $id);

#funcion de ayuda de categoria
include "php/funcion_categoria.php";
$categoria = get_all_categoria($conn);
$current_categoria = get_categoria($conn, $id);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title><?= $current_autor['nombre'] ?></title>

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
              <a class="nav-link active" aria-current="page" href="#">Tienda</a>
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
    </nav>

    <!--Agregamos un buscador y le damos su funcionalidad-->
    <h1 class="display-4 p-3 fs-3">
      <a href="index.php" class="nd">
        <img src="img/flecha-izquierda.jpg" width="35">
      </a>
      <?= $current_autor['nombre'] ?>
    </h1>

    <div class="d-flex pt-3">
      <?php if ($libros == 0) { ?>

        <div class="alert alert-warning text-center p-5" role="alert">
          <img src="img/vacios.jpg" width="100">
          <br>
          No hay ningún libro en la base de datos
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

                <?php if ($libro['gratis'] == 1) { ?>
                  <a href="uploads/files/<?= $libro['archivo'] ?>" class="btn btn-primary"
                    download="<?= $libro['titulo'] ?>">Descargar</a>
                <?php } else { ?>
                  <div class="d-flex flex-column align-items-start">
                    <span class="text-muted mb-2"><strong>Precio: </strong>$<?= $libro['precio'] ?></span>
                    <!-- Mostrar el precio -->
                    <a href="pasarela/pagar.php" class="btn btn-success">Comprar</a>

                  </div>
                <?php } ?>

              </div>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
      <div class="categorias">
        <!--Lista de las categorias-->
        <div class="list-group">
          <?php if ($categoria == 0) {
          //no hacer nada aqui
        } else { ?>
            <a href="·" class="list-group-item list-group-item-action active">Categoría</a>
            <?php foreach ($categoria as $categorias) { ?>

              <a href="categoria.php?=id=<?= $categorias['id'] ?>"
                class="list-group-item list-group-item-action"><?= $categorias['nombre'] ?></a>
            <?php }
        } ?>
        </div>

        <!--Lista de los autores-->
        <div class="list-group mt-5">
          <?php if ($autores == 0) {
          //no hacer nada aqui
        } else { ?>
            <a href="·" class="list-group-item list-group-item-action active">Autor</a>
            <?php foreach ($autores as $autor) { ?>

              <a href="autor.php?id=<?= $autor['id'] ?>"
                class="list-group-item list-group-item-action"><?= $autor['nombre'] ?></a>
            <?php }
        } ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
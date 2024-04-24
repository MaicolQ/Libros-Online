<!--esto hace parte del cierre de sesion y el inicio de sesion-->
<?php

session_start();

# If the admin is logged in
if (
  isset($_SESSION['user_id']) &&
  isset($_SESSION['user_email'])
) {

  #funcion de ayuda de libro
  include "db.php";

  #funcion de ayuda de libro
  include "php/funcion_libro.php";
  $libros = get_all_books($conn);

  #funcion de ayuda de autor
  include "php/func-author.php";
  $autores = get_all_author($conn);

  #funcion de ayuda de categoria
  include "php/funcion_categoria.php";
  $categoria = get_all_categoria($conn);

  ?>

  <!--............................................................-->
  <!DOCTYPE html>
  <html lang="es-CO">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>

    <!--Boostrap 5 cdn-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!--Boostrap 5 js cdn-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"></script>

  </head>

  <body>
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="admin.php">Admin</a>
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
                <a class="nav-link" href="agregar_libro.php">Agregar Libro</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="agregar_categoria.php">Agregar Categoría</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="agregar_autor.php">Agregar Autor</a>
              </li>
              <li class="nav-item">
                <!--esta es la direccion del inicio de sesion-->
                <a class="nav-link" href="Logout.php">Logout</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <!--Agregamos un buscador y le damos su funcionalidad-->
      <form action="buscador.php" method="get" style="width; 100%; max-width: 30rem;">
        <div class="input-group my-5">

          <input type="text" class="form-control" name="key" placeholder="Buscar Libro..." aria-label="Buscar Libro"
            aria-describedby="basic-addon2">
          <button class="input-group-text btn btn-primary" id="basic-addon2"><img src="img/buscar.png"
              width="20"></button>
        </div>

      </form>

      <div class="mt-5"></div>
      <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger" role="alert">
          <?= htmlspecialchars($_GET['error']); ?>
        </div>
      <?php } ?>
      <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-success" role="alert">
          <?= htmlspecialchars($_GET['success']); ?>
        </div>
      <?php } ?>


      <!--Alertas-->

      <?php
      if ($libros == 0) { ?>
        <div class="alert alert-warning text-center p-5" role="alert">
          <img src="img/vacios.jpg" width="100">
          <br>
          No hay ningún libro en la base de datos

        </div>
      <?php } else { ?>
        <!--Hacemos las tablas para el editor-->
        <!--lista de todos los libros-->
        <h4 class="mt-5">Todos los libros</h4>
        <table class="table table-bordered shadow">
          <thead>
            <tr>
              <th>#</th>
              <th>Título</th>
              <th>Autor</th>
              <th>Descripción</th>
              <th>Categoría</th>
              <th>Precio</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 0;
            foreach ($libros as $libro) {
              $i++;
              ?>
              <tr>
                <td><?= $i ?></td>
                <!--especificamos lo que tenemos en la base de datos para que aparezca en nuestra web-->
                <td>
                  <img width="100" src="uploads/cover/<?= $libro['cubrir'] ?>">

                  <a class="link_dark d-block text-center" href="uploads/files/<?= $libro['archivo'] ?>">
                    <?= $libro['titulo'] ?>
                  </a>

                </td>
                <td>
                  <?php if ($autores == 0) {
                    echo "undefined";
                  } else {

                    foreach ($autores as $autor) {
                      if ($autor['id'] == $libro['autor_id']) {
                        echo $autor['nombre'];
                      }
                    }
                  }
                  ?>
                </td>
                <td><?= $libro['descripcion'] ?></td>
                <td>
                  <?php if ($categoria == 0) {
                    echo "undefined";
                  } else {

                    foreach ($categoria as $categorias) {
                      if ($categorias['id'] == $libro['categoria_id']) {
                        echo $categorias['nombre'];
                      }
                    }
                  }
                  ?>
                </td>
                <td><?= $libro['precio'] ?></td>


                </td>
                <td>
                  <a href="editar_libro.php?id=<?= $libro['id'] ?>" class="btn btn-warning">Editar</a>
                  <a href="php/eliminar_libro.php?id=<?= $libro['id'] ?>" class="btn btn-danger">Eliminar</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } ?>

      <!--tablas para la categoria-->
      <?php
      if ($categoria == 0) { ?>
        <div class="alert alert-warning text-center p-5" role="alert">
          <img src="img/vacios.jpg" width="100">
          <br>
          No hay ninguna categoría en la base de datos

        </div>
      <?php } else { ?>
        <!--lista de todas las categorias-->
        <h4 class="mt-5">Todas las Categorías</h4>
        <table class="table table-bordered shadow">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre de la Categoría</th>
              <th>Acción</th>
            </tr>

          </thead>
          <tbody>
            <?php
            $j = 0;
            foreach ($categoria as $categorias) {
              $j++;

              ?>
              <tr>
                <td><?= $j ?></td>
                <td><?= $categorias['nombre'] ?></td>
                <td>
                  <a href="editar_categoria.php?id=<?= $categorias['id'] ?>" class="btn btn-warning">Editar</a>
                  <a href="php/eliminar_categoria.php?id=<?= $categorias['id'] ?>" class="btn btn-danger">Eliminar</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } ?>

      <!--tablas para los autores-->
      <?php
      if ($autores == 0) { ?>
        <div class="alert alert-warning text-center p-5" role="alert">
          <img src="img/vacios.jpg" width="100">
          <br>
          No hay ningún autor en la base de datos

        </div>
      <?php } else { ?>
        <!--lista de todos los autores-->
        <h4 class="mt-5">Todos los Autores</h4>
        <table class="table table-bordered shadow">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre del Autor</th>
              <th>Acción</th>
            </tr>

          </thead>
          <tbody>
            <?php
            $k = 0;
            foreach ($autores as $autor) {
              $k++;

              ?>
              <tr>
                <td><?= $k ?></td>
                <td><?= $autor['nombre'] ?></td>
                <td>
                  <a href="editar_autor.php?id=<?= $autor['id'] ?>" class="btn btn-warning">Editar</a>
                  <a href="php/eliminar_autor.php?id=<?= $autor['id'] ?>" class="btn btn-danger">Eliminar</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

      <?php } ?>
    </div>
  </body>

  </html>

<?php } else {
  header("Location: login.php");
  exit;
} ?>
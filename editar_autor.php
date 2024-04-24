<?php
session_start();
# se comprueba si el administrador inicio sesion
if (
  isset($_SESSION['user_id']) &&
  isset($_SESSION['user_email'])
) {

  #El ID de Autor no esta configurado, lo configuramos
  if (!isset($_GET['id'])) {
    # Redirigir a la pagina admin.php
    header("Location: admin.php");
    exit;
  }

  $id = $_GET['id'];

  #funcion de ayuda de libro
  include "db.php";

  #funcion de ayuda de autor
  include "php/func-author.php";
  $autor = get_author($conn, $id);

  #El ID es invalido
  if ($autor == 0) {
    # Redirigir a la pagina admin.php
    header("Location: admin.php");
    exit;
  }
  ?>

  <!--............................................................-->
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Editar Autor</title>

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
                <a class="nav-link" href="agregar_categoria.php">Agregar Categoria</a>
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

      <!--estilos en el autor-->
      <form action="php/editar_autor.php" method="post" class="shadow p-4 rounded mt-5"
        style="width: 90%; max-width: 50rem;">
        <h1 class="text-center pb-5 display-4 fs-3">
          Editar Autor
        </h1>
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

        <div class="mb-3">
          <label class="form-label">Nombre del Autor</label>
          <input type="text" value="<?= $autor['id'] ?>" hidden name="autor_id">
          <input type="text" class="form-control" value="<?= $autor['nombre'] ?>" name="nombre_autor">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
      </form>
    </div>
  </body>
  </html>

<?php } else {
  header("Location: login.php");
  exit;
} ?>
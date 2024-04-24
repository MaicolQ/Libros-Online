<!--esto hace parte del cierre de sesion y el inicio de sesion-->
<?php
session_start();
# se comprueba si el administrador inicio sesion
if (
    isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])
) {

    #funcion de ayuda de libro
    include "db.php";

    #funcion de ayuda de categoria
    include "php/funcion_categoria.php";
    $categoria = get_all_categoria($conn);

    #funcion de ayuda de autor
    include "php/func-author.php";
    $autores = get_all_author($conn);

    #Lo que hace esto es que a la hora de enviar el formulario con algunos campos vacios(muestra el error) se queden los campos completados y no queden vacios

    if (isset($_GET['titulo'])) {
        $titulo = $_GET['titulo'];
    } else
        $titulo = '';

    if (isset($_GET['desc'])) {
        $desc = $_GET['desc'];
    } else
        $desc = '';

    if (isset($_GET['categoria_id'])) {
        $categoria_id = $_GET['categoria_id'];
    } else
        $categoria_id = 0;

    if (isset($_GET['autor_id'])) {
        $autor_id = $_GET['autor_id'];
    } else
        $autor_id = 0;
    ?>

    <!--............................................................-->
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=, initial-scale=1.0">
        <title>Agregar un Libro</title>

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
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="index.php">Tienda</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="agregar_libro.php">Agregar Libro</a>
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
            <!--estilos en el autor-->
            <form action="php/agregar_libro.php" method="post" enctype="multipart/form-data" class="shadow p-4 rounded mt-5"
                style="width: 90%; max-width: 50rem;">

                <h1 class="text-center pb-5 display-4 fs-3">
                    Agregar Nuevo Libro
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

                <!--Agregamos datos al libro-->

                <div class="mb-3">
                    <label class="form-label">Título Libro</label>
                    <input type="text" class="form-control" value="<?= $titulo ?>" name="titulo_libro">
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción del Libro</label>
                    <input type="text" class="form-control" value="<?= $desc ?>" name="libro_descripcion">
                </div>

                <div class="mb-3">
                    <label class="form-label">Autor del Libro</label>
                    <select name="autor_libro" class="form-control">
                        <option value="0">
                            Seleccionar Autor
                        </option>
                        <?php
                        if ($autores == 0) {
                            # aca no se hace nada
                        } else {

                            foreach ($autores as $autor) {
                                if ($autor_id == $autor['id']) {
                                    ?>
                                    <option selected value="<?= $autor['id'] ?>">
                                        <?= $autor['nombre'] ?>
                                    </option>
                                <?php } else { ?>

                                    <option value="<?= $autor['id'] ?>">
                                        <?= $autor['nombre'] ?>
                                    </option>

                                <?php }
                            }
                        } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Categoría del Libro</label>
                    <select name="categoria_libro" class="form-control">
                        <option value="0">
                            Seleccionar Categoría
                        </option>
                        <?php
                        if ($categoria == 0) {
                            # aca no se hace nada
                        } else {

                            foreach ($categoria as $categorias) {
                                if ($categoria_id == $categorias['id']) {
                                    ?>
                                    <option selected value="<?= $categorias['id'] ?>">
                                        <?= $categorias['nombre'] ?>
                                    </option>
                                <?php } else { ?>

                                    <option value="<?= $categorias['id'] ?>">
                                        <?= $categorias['nombre'] ?>
                                    </option>

                                <?php }
                            }
                        } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Carátula del Libro</label>
                    <input type="file" class="form-control" name="caratula_libro">
                </div>

                <div class="mb-3">
                    <label class="form-label">Archivo</label>
                    <input type="file" class="form-control" name="archivo">
                    <br>

                    <div>
                        <div>
                            <p>Selecciona una opción:</p>
                            <input type="radio" id="opcionGratis" name="opcion" value="gratis">
                            <label for="opcionGratis">Gratis</label><br>
                            <input type="radio" id="opcionDePago" name="opcion" value="de_pago">
                            <label for="opcionDePago">De Pago</label><br>
                            <div id="precioInput" style="display: none;">
                                <label for="precio">Precio:</label>
                                <input type="text" id="precio" name="precio" placeholder="Ingresar precio del libro">
                            </div>
                            <button type="button" id="btnAceptar" onclick="procesarOpcion()">Aceptar</button>
                        </div>
                        <br>

                        <script src="js/script1.js"></script>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Libro</button>
            </form>
        </div>
    </body>
    </html>

<?php } else {
    header("Location: login.php");
    exit;
} ?>
<?php

# funciones de autor
function get_all_author($con)
{
   $sql = "SELECT * FROM autores";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
      $autores = $stmt->fetchAll();
   } else {
      $autores = 0;
   }

   return $autores;
}


# Obtener la funcion Autor por ID
function get_author($con, $id)
{
   $sql = "SELECT * FROM autores WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
      $autor = $stmt->fetch();
   } else {
      $autor = 0;
   }

   return $autor;
}

?>
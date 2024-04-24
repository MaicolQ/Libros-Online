<?php

# funciones de categorias
function get_all_categoria($con)
{
   $sql = "SELECT * FROM categoria";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
      $categoria = $stmt->fetchAll();
   } else {
      $categoria = 0;
   }

   return $categoria;
}

# Obtener Categoria por ID

function get_categoria($con, $id)
{
   $sql = "SELECT * FROM categoria WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
      $categorias = $stmt->fetch();
   } else {
      $categorias = 0;
   }

   return $categorias;
}

?>
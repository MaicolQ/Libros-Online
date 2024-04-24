<?php
# nombre servidor
$sName = "localhost";
# nombre usuario
$uName = "root";
# contraseña
$pass = "";
# base de datos
$db_name = "rol";

try {
  $conn = new PDO(
    "mysql:host=$sName;dbname=$db_name",
    $uName,
    $pass
  );
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Conexion fallida
  : " . $e->getMessage();
}
?>
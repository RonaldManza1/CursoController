<?php

//tabla
$claveUsuario = "SENATI";

// $claveMD5 = md5($claveUsuario);
$claveSHA = sha1($claveUsuario);
$claveHASH = password_hash($claveUsuario, PASSWORD_BCRYPT);

//clave acceso (LOGIN)
$claveAcceso= "SENATI";

//var_dump($claveHASH);

//validar claves HASH
if (password_verify($claveAcceso, $claveHASH)){
  echo "Acceso correcto";
}
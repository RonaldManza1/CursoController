<?php

$claveUsuario = "SENATI";

// $claveMD5 = md5($claveUsuario);
$claveSHA = sha1($claveUsuario);
$claveHASH = password_hash($claveUsuario, PASSWORD_BCRYPT);


var_dump($claveHASH);
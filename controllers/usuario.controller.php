<?php
session_start();
require_once '../models/Usuario.php';

if (isset($_POST['operacion'])){

  $usuario = new Usuario();

  //identificando la operacion...
  if ($_POST['operacion'] == 'login'){

    $registro = $usuario->iniciarSesion($_POST['nombreusuario']);

    $_SESSION["login"] = false;

    //objeto para contener el resultado
    $resultado = [
      "status" => false,
      "mensaje" => ""
    ];


    if ($registro){
      //el usuario si existe
      $claveEncriptada = $registro["claveacceso"];
      
      //validar la contraseña
      if (password_verify($_POST['claveIngresada'], $claveEncriptada)){
        $resultado["status"] = true;
        $resultado["mendaje"] = "Bienvenido al sistema";
        $_SESSION["login"] = true;
      }else{
        $resultado["mensaje"] = "Error en la contraseña";
      }
    }
    else {
      //el usuario no existe
      $resultado["mensaje"] = "No encontramos al usuario";
    }

    //enviamos un objeto resultado a la vista.
    echo json_encode($resultado);

  }
}


if (isset($_GET['operacion'])){

  if ($_GET['operacion'] == 'finalizar'){
    session_destroy();
    session_unset();
    header('Location:../index.php');
  }
}
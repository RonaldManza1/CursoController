<?php

require_once 'Conexion.php';

class Usuario extends Conexion{

  private $accesoBD; //Conexion

  public function __CONSTRUCT(){
    $this->accesoBD = parent::getConexion();
  }

  public function iniciarSesion($nombreUsuario = "") {
    try{
      $consulta = $this->accesoBD->prepare("CALL spu_usuarios_login(?)");
      $consulta->execute(array($nombreUsuario));
      return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

 public function registrarUsuario(){

 }

 public function eliminarUsuario(){

 }

 public function listarUsuarios(){

 }

}
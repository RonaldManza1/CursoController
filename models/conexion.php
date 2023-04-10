<?php
  //Esta clase le permitirá a los modelos acceder y consumir los datos
class Conexion{
  
  //Atributos
  private $host = "localhost";      //Servidor
  private $port = "3306";           //Puerto comunicación BD
  private $database = "senati";     //Nombre BD
  private $charset = "UTF8";        //Codificación (Idioma)
  private $user = "root";           //Usuario (raíz)
  private $password = "";           //Contraseña

  //atributo (instancia PDO) que almacena la coneión
  private $pdo;

  //Método 1: Acceeder a la base de datos
  //Constructor:
  //new PDO("CADENA_CONEXION", "USER", "PASSWORD"); 
  private function conectarServidor(){
    $conexion = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->database};charset={$this->charset}", $this->user,
                        $this->password);

    return $conexion;
  }

  //Metodo 2: Retornar el acceso
  public function getConexion(){
    try{
      //Pasaremos la conexión al atributo/objeto $po
      $this->pdo = $this->conectarServidor();

      //Controlar los errores (será controlado por TRY-CATCH)
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //Retornamos la conexión al modelo que lo necesite
      return $this->pdo;
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

}

?>
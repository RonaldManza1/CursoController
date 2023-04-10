<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login']){
  header('Location:views/index.php');
}
?>

<!doctype html>
<html lang="es">

<head>
  <title>Welcome</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <!--inicio de card-->
        <div class="card">
          <div class="card-header">
            <strong>Inicio de sesion</strong>
          </div>
          <div class="card-body">
            <form action="">
              <div class="mb_3">
                <label for="usuario" class="form-label">usuario:</label>
                <input type="text" id="usuario" class="form-control form-control-sm" autofocus>
              </div>
              <div class="mb_3">
                <label for="clave" class="form-label">Contraseña:</label>
                <input type="password" id="clave" class="form-control form-control-sm">
              </div>
            </form>
          <div class="card-footer text-muted">
            <button type="button" class="btn btn-sm btn-success" id="iniciar-sesion">Iniciar de sesion</button>
          </div>
        </div>
        <!--fin de card-->
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>

  <!--jQuery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

  <script>
    $(document).ready(function(){

      function iniciarSesion() {
        const usuario = $("#usuario").val();
        const clave = $("#clave").val();

        if (usuario != "" && clave !=""){
          $.ajax({
            url: 'controllers/usuario.controller.php',
            type: 'POST',
            data: {
              operacion : 'login',
              nombreusuario : usuario,
              claveIngresada : clave
            },
            dataType: 'JSON',
            success: function (result){
              console.log(result);
              if (result["status"]){
                window.location.href = "views/index.php";
              }else{
                alert(result["mensaje"]);
              }
            }
          });
        }

      }
      $("#iniciar-sesion").click(iniciarSesion);

    });
  </script>


</body>

</html>
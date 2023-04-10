<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] == false){
  header('Location:../index.php');
}


?>

<!doctype html>
<html lang="es">

<head>
  <title>Cursos PDO</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <!--Icono de Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    

</head>

<body>
  
  <div class="container mt-3">
    <div class="card">
      <div class="card-header bg-primary text-light">
        <div class="row">
          <div class="col-md-6">
            <strong>LISTA DE CURSOS</strong>
          </div>
          <div class="col-md-6 text-end">
            <button class="btn btn-success btn-sm" id="abrir-modal" data-bs-toggle="modal" data-bs-target="#modal-registro-cursos"><i class="bi bi-plus-circle"></i> Agregar Curso</button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-sm table-striped" id="tabla-cursos">
          <colgroup>
            <col width = "5%">
            <col width = "30%">
            <col width = "25%">
            <col width = "10%">
            <col width = "10%">
            <col width = "10%">
            <col width = "10%">
          </colgroup>
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Especialidad</th>
              <th>Nivel</th>
              <th>Inicio</th>
              <th>Inversión</th>
              <th>Operaciones</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <div class="card-footer text-end">
        <a href= "../controllers/usuario.controller.php?operacion=finalizar"> Cerrar sesion</a>
      </div>
    </div>
  </div>  <!--Fin del container-->

  <!--Zona Modales-->
  <!-- Modal trigger button -->
  
  <!-- Modal Body -->
  <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
  <div class="modal fade" id="modal-registro-cursos" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-secondary text-light">
          <h5 class="modal-title" id="modal-titulo">Registro de Cursos</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formulario-cursos" autocomplete="off">
            <div class="mb-3">
              <label for="nombrecurso" class="form-label">Nombre del Curso</label>
              <input type="text" class="form-control form-control-sm" id="nombrecurso">
            </div>
            <div class="mb-3">
              <label for="especialidad" class="form-label">Especialidad</label>
              <select id="especialidad" class="form-select form-select-sm">
                <option value="">Seleccione</option>
                <option value="ETI">ETI</option>
                <option value="Administración">Administración</option>
                <option value="Mecánica">Mecánica</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="complejidad" class="form-label">Complejidad</label>
              <select id="complejidad" class="form-select form-select-sm">
                <option value="">Seleccione</option>
                <option value="B">Básico</option>
                <option value="M">Medio</option>
                <option value="A">Avanzado</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="fechainicio" class="form-label">Fecha de Inicio</label>
              <input type="date" class="form-control form-control-sm" id="fechainicio">
            </div>
            <div class="mb-3">
              <label for="precio" class="form-label">Precio</label>
              <input type="text" class="form-control form-control-sm" id="precio">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary btn-sm" id="guardar-curso">Guardar</button>
        </div>
      </div>
    </div>
  </div>
  
  
  <!--Fin zona Modales-->

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">


  </script>

  <!--jQuery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


  <script>
    $(document).ready(function(){

      //variables de ambito general (accesibles)
      let datocNuevos = true;
      let idcursoactualizar = -1;

      function mostrarCursos(){
        $.ajax({
          url:      '../controllers/curso.controller.php',
          type:     'POST',
          data:     {operacion: 'listar'},
          dataType: 'text',
          success: function(result){
            $("#tabla-cursos tbody").html(result);
          }
        });
      }

      function registrarcurso(){
        console.log("hola");
        //pendiente de validar...
        if (confirm("¿Está seguro de salvar los datos?")){

          //crear un objeto conteniendo los datos a guardar
          let datos = {
              operacion       :     'registrar',
              idcurso         :     idcursoactualizar,
              nombrecurso     :     $("#nombrecurso").val(),
              especialidad    :     $("#especialidad").val(),
              complejidad     :     $("#complejidad").val(),
              fechainicio     :     $("#fechainicio").val(),
              precio          :     $("#precio").val()

          };
          if (!datosNuevos){
            datos["operacion"] = "actualizar";
          }


          $.ajax({
            url:    '../controllers/curso.controller.php',
            type:   'POST',
            data: datos,
            success: function(result){
              if (result == ""){
                //Reiniciar el formulario
                $("#formulario-cursos")[0].reset();

                //Actualizar la table
                mostrarCursos();

                //Cerrar el modal
                $("#modal-registro-cursos").modal('hide');

              }
            }
          });
        }
      }

      function abrirModal(){
        datosNuevos = true; //variable de tipo BANDERA
        $("#modal-titulo").html("Registro de Curso");
        $("#formulario-cursos")[0].reset();
      }

      //Evento
      $('#guardar-curso').click(registrarcurso);
      $("#abrir-modal").click(abrirModal);

      //Al pulsar click sobre el botón rojo eliminar el registro
      //Detectaremos eventos de los objetos creados de manera asincrona en...
      $("#tabla-cursos tbody").on("click", ".eliminar", function (){
        const idcursoEliminar = $(this).data("idcurso");
        if (confirm("¿Está seguro de proceder?")){
          $.ajax({
            url:      '../controllers/curso.controller.php',
            type:     'POST',
            data: {
              operacion   :  'eliminar',
              idcurso     :  idcursoEliminar
            },
            success: function(result){
              if (result == ""){
                mostrarCursos();
              }
            }
          })
        }
      });

      //detectar click en editar
      //on() permite getionar-controlar eventos
      $("#tabla-cursos tbody").on("click", ".editar", function(){
        const idcursoeditar = $(this).data("idcurso");
        
        $.ajax({
          url:'../controllers/curso.controller.php',
          type:'POST',
          data:{
            operacion: 'obtenercurso',
            idcurso : idcursoeditar
          },
          dataType: 'JSON',
          success: function(result){
            console.log(result);

            //configurar la bandera
            datosNuevos = false;

            ///retornamos los valores a los controles de FORM
            idcursoactualizar =result["idcurso"];
            $("#nombrecurso").val(result["nombrecurso"]);
            $("#especialidad").val(result["especialidad"]);
            $("#complejidad").val(result["complejidad"]);
            $("#fechainicio").val(result["fechainicio"]);
            $("#precio").val(result["precio"]);

            //cambiar titulo del modal
            $("#modal-titulo").html("Actualizar datos de cursos");

            //podemos al modal en la pantalla
            $("#modal-registro-cursos").modal("show");
          }
        });
      });

      //Ejecución automatica
      mostrarCursos();



    });
  </script>

</body>

</html>
<?php
session_start();
if(!isset($_SESSION['palacioRosaUserAuthenticated'])){
  die("No tiene permisos");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test Palacio Rosa</title>
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <!-- Bootstrap 4.5 con Jquery
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  -->
  <!-- Bootstrap 5 con Font Awesome icons y Axios -->
  <script src="https://kit.fontawesome.com/d6e2fe2a12.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>

  <div id="tablaUsuarios"></div>

  <button id="botonCrearUsuario" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearUsuario">Crear Usuario</button>
  <button id="botonLimpiar" type="button" class="btn btn-success" >Limpiar</button>

  <style>
    .box {
    float: left;
    height: 60px;
    width: 60px;
    margin-bottom: 15px;
    border: 1px solid black;
    clear: both;
    }

    .red {
      background-color: red;
    }

    .green {
      background-color: green;
    }

    .black {
      background-color: black;
    }
  </style>

  <div id="respuestaColor"></div>

  <!-- Inicio Modal para crear usuario -->
  <div class="modal fade" id="modalCrearUsuario" tabindex="-1" aria-labelledby="modalCrearUsuario" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Crear Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- <form id="formCrearUsuario" class="form"> -->
          <div class="modal-body">
            <div class="form-group">
              <label for="message-text" class="col-form-label">Nombre de usuario:</label>
              <input type="text" class="form-control" id="nombre_create">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">E-Mail:</label>
              <input type="text" class="form-control" id="email_create">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Password:</label>
              <input type="password" class="form-control" id="passwd_create">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Fecha de Nacimiento:</label>
              <input type="text" class="form-control" id="fechaNacimiento_create">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Sexo:</label>
              <select name="sexo_create" id="sexo_create">
                <option value="" disabled selected>Elegir Sexo</option>
                <option value="m">M</option>
                <option value="f">F</option>
              </select>
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Direccion:</label>
              <input type="text" class="form-control" id="direccion_create">
            </div>
            <span id="respuestaCrearUsuario"></span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <!-- <button type="submit">Crear</button> -->
            <button id="botonModalCrearUsuario" class="btn btn-success">Crear Usuario</button>
          </div>
        <!-- </form> -->
      </div>
    </div>
  </div>
  <!-- Fin Modal para crear usuario -->

  <!-- Inicio Modal para editar usuario -->
  <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuario" aria-hidden="true">
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button> -->
        </div>
        <!-- <form action="" id="formCrearUsuario"> -->
          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" class="form-control" id="id_edit">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Nombre de usuario:</label>
              <input type="text" class="form-control" id="nombre_edit">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">E-Mail:</label>
              <input type="text" class="form-control" id="email_edit">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Password:</label>
              <input type="password" class="form-control" id="passwd_edit">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Fecha de Nacimiento:</label>
              <input type="text" class="form-control" id="fechaNacimiento_edit">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Sexo:</label>
              <select name="sexo_edit" id="sexo_edit">
                <option value="" disabled selected>Elegir Sexo</option>
                <option value="m">M</option>
                <option value="f">F</option>
              </select>
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Direccion:</label>
              <input type="text" class="form-control" id="direccion_edit">
            </div>

            <span id="respuestaEditarUsuario"></span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button id="botonModalEditarUsuario" class="btn btn-success">Actualizar Usuario</button>
          </div>
        <!-- </form> -->
      </div>
    </div>
  </div>
  <!-- Fin Modal para editar usuario -->

</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>

<!--
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
-->
<script src="js/main.js"></script>

</html>
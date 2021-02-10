<?php
session_start();
if(!isset($_SESSION['palaciorosaUserAuthenticated'])){
  //die("No tiene permisos");
  header("Location: login.php");
  exit();

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
  <!--
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>

  <!-- Inicio Barra de navegacion superior -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Palacio Rosa Test</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
          <!-- <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Link
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Link</a>
          </li> -->
        </ul>
        
        <ul class="navbar-nav ml-auto ml-md-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i><?php echo $_SESSION['palaciorosaUserAuthenticated']; ?></a>
            <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
          
        <!--
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        -->
      </div>
    </div>
  </nav>
  <!-- Final Barra de navegacion superior -->


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
              <input type="text" class="form-control" id="username_create">
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
              <input type="text" class="form-control" id="username_edit">
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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
-->

<!--
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
-->
<script src="js/main.js"></script>

</html>
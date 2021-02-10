<?php
//echo "yess";
//print_r($_REQUEST);
//var_dump($_POST);
//echo json_encode($_REQUEST);
session_start();

include_once("../model/dbModel.php");

if(isset($_REQUEST['dataUsuario'])){

  $modelo = new dbModel();
  //echo $_REQUEST['usuario'];
  switch($_REQUEST['accion']){
    case "table":
      //echo json_encode($_REQUEST);
      $sql = "SELECT * FROM usuarios";
      $intCamposAfectados = $modelo->arrEjecutarConsulta($sql);
      echo json_encode($intCamposAfectados);
    break;
    case "create":
      $passwdCrypted = password_hash($_REQUEST['passwd'], PASSWORD_BCRYPT, ['cost' => 9]);
      /* 
      Si no se especifica un costo, se tomará por defecto el valor '10'. 
      (Se toma en este caso '9') porque Docker tiene bajo nivel de procesamiento
      En el caso de querer que la maquina tome un costo por defecto, se debe encriptar el password de esta manera:

      password_hash('rasmuslerdorf', PASSWORD_DEFAULT)

      */
      $sql = "INSERT INTO usuarios (username, email, passwd, fecha_nacimiento, sexo, direccion, fecha_creacion) VALUES ('{$_REQUEST['username']}', '{$_REQUEST['email']}', '{$passwdCrypted}', '{$_REQUEST['fechaNacimiento']}', '{$_REQUEST['sexo']}', '{$_REQUEST['direccion']}', NOW())";
      $intCamposAfectados = $modelo->ejecutarSentencia($sql);
      echo json_encode($intCamposAfectados);
    break;
    case "show":
      $sql = "SELECT * FROM usuarios WHERE id = {$_REQUEST['id_usuario']}";
      $intCamposAfectados = $modelo->arrEjecutarConsulta($sql);
      echo json_encode($intCamposAfectados);
    break;
    case "edit":
      if ($_REQUEST['passwd'] == "xxxxxxx"){
        $sql = "UPDATE usuarios SET username='{$_REQUEST['username']}', email='{$_REQUEST['email']}', fecha_nacimiento='{$_REQUEST['fechaNacimiento']}', sexo='{$_REQUEST['sexo']}', direccion='{$_REQUEST['direccion']}', fecha_modificacion=NOW() WHERE id={$_REQUEST['id_usuario']}";
      } else{
        $passwdCrypted = password_hash($_REQUEST['passwd'], PASSWORD_BCRYPT, ['cost' => 9]);
        $sql = "UPDATE usuarios SET username='{$_REQUEST['username']}', email='{$_REQUEST['email']}', passwd='{$passwdCrypted}', fecha_nacimiento='{$_REQUEST['fechaNacimiento']}', sexo='{$_REQUEST['sexo']}', direccion='{$_REQUEST['direccion']}', fecha_modificacion=NOW() WHERE id={$_REQUEST['id_usuario']}";
      }
      //echo json_encode($sql);
      $intCamposAfectados = $modelo->ejecutarSentencia($sql);
	    echo json_encode($intCamposAfectados);
    break;
    case "remove":
      $sql = "DELETE FROM usuarios WHERE id = {$_REQUEST['id_usuario']}";
      $intCamposAfectados = $modelo->ejecutarSentencia($sql);
	    echo json_encode($intCamposAfectados);
    break;
    case "login":
      $sql = "SELECT * FROM usuarios WHERE username = '{$_REQUEST['username']}'";
      $intCamposAfectados = $modelo->arrEjecutarConsulta($sql);
      if (password_verify($_REQUEST['passwd'], $intCamposAfectados[0]['passwd'])) {
        echo json_encode(true);
        $_SESSION['palaciorosaUserAuthenticated'] = $_REQUEST['username'];
      } else {
        echo json_encode(false);
      }
    
  }

  

  //echo $sql;
}

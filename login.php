<?php

session_start();

include('includes/config.php');
include('includes/db.php');

if(isset($_POST['login'])){
    $usuario =  trim(strip_tags($_POST['usuario']));
    $senha = trim(strip_tags($_POST['senha']));
    $cript_pass = md5(strrev($senha));

    $query = "SELECT * FROM login WHERE BINARY usuario=:usuario AND BINARY senha=:senha";

    try {
        $result = $PDO->prepare($query);
        $result->bindParam(':usuario',$usuario, PDO::PARAM_STR);
        $result->bindParam(':senha',$cript_pass, PDO::PARAM_STR);
        $result->execute();
        $contar = $result->rowCount();
        if($contar>0) {
            $usuario =  $_POST['usuario'];
            $senha = $cript_pass;
            $_SESSION['usuario'] = $usuario;
            $_SESSION['senha'] = $cript_pass;

            header("Location:admin/index.php");

        } else {
            header("Location:login.php?err=Dados incorretos!!");
            exit();
        }

    } catch(PDOException $e) {
        echo 'Erro:' . $e;
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!-- Imports de libs -->
    <link href="libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Programeiros</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse navbar-right">
          <ul class="nav navbar-nav">
            <li class="active"><a href="login.php">Login</a></li>
            <li><a href="index.php">Voltar ao Site</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container">
     <form action="login.php" method="post" style="margin-top:75px;">
         <h2>Login</h2>

         <?php if(isset($_GET['success'])) { ?>

         <div class="alert alert-success"><?php echo $_GET['success']; ?></div>

         <?php } ?>

         <?php if(isset($_GET['err'])) { ?>

         <div class="alert alert-danger"><?php echo $_GET['err']; ?></div>

         <?php } ?>

         <hr>
        <div class="form-group">
          <label for="campo_user">Usuário</label>
          <input type="text" id="campo_user" name="usuario" class="form-control" placeholder="Usuário" autofocus>
        </div>
        <div class="form-group">
          <label for="campo_pass">Senha</label>
          <input type="password" name="senha" class="form-control" id="campo_pass" placeholder="Senha">
        </div>
        <button type="submit" name="login" class="btn btn-success">Login</button>
      </form>
    </div>


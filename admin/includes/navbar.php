<?php
session_start();
include('../includes/config.php');
include('../includes/db.php');
include('../includes/functions.php');

if(!loggedIn()){
    header("Location:../login.php?err=" . urlencode("Você precisa estar logado para acessar sua conta!!"));
    exit();
}

if(isset($_GET['acao'])) {
    $acao = $_GET['acao'];
} else {
    $acao = '';
}

$usuario = $_SESSION['usuario'];

$user = 'SELECT * FROM login WHERE usuario = :usuario';
$resultado = $PDO->prepare($user);
$resultado->bindValue(':usuario', $usuario, PDO::PARAM_STR);
$resultado->execute();
$count=$resultado->rowCount();
if($count=1) {
    while($nomeUser = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $nomeUsuario = $nomeUser['nome'];
    }

}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Programeiros - Sistema de Postagem</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="../libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../libs/font-awesome-4.7.0/css/font-awesome.min.css">
<link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
  <header>
    <nav class="navbar navbar-inverse" role="banner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span> </a>
            <a class="navbar-brand" href="index.php">Programeiros</a>
          <ul class="nav navbar-nav navbar-right">
            <li>
              <form action="#" method="post" enctype="multipart/form-data" class="navbar-form navbar-right">
              <div class="form-group">
                <input type="text" class="form-control" name="busca" placeholder="Pesquisar...">
              </div>
            </form>
            </li>
            <li><a href="logout.php">Sair</a></li>
          </ul>
        </div>
    </nav>
</header>

    <div class="container">
      <div class="row">
        <div class="alert alert-info">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>Olá, <?php echo $nomeUsuario; ?></strong>, Seja Bem vindo!
        </div>

<div class="container">
  <div class="navbar navbar submenu" role="banner">
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Início</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Postagens <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="postagens.php">Visualizar</a></li>
            <li><a href="cadastra_post.php">Cadastrar</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuários <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="usuarios.php">Visualizar</a></li>
            <li><a href="cadastra_user.php">Cadastrar</a></li>
          </ul>
        </li>
      </ul>
    </div>
    </div>
  </div>
</nav>

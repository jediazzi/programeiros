<?php

include('includes/config.php');
include('includes/db.php');

?>
<!-- Inicio corpo html -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>
        <?php echo TITLE; ?>
    </title>
    <!-- Importe de libs -->
    <link href="libs/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/navbar.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
  <nav class="navbar navbar-findcond navbar-fixed-top">
    <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand title-text" href="index.php">Programeiros</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
        <li><a href="contato.php"><span class="glyphicon glyphicon-earphone"> Contato </span></a></li>
        <li ><a href="login.php"><span class="glyphicon glyphicon-user" aria-hidden="true"> Admin</span></a></li>
      </ul>
      <form class="navbar-form navbar-right search-form" role="search">
        <input type="text" class="form-control" placeholder="Busca..." />
      </form>
    </div>
  </div>
</nav>

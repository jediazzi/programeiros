<?php

@define(TITLE, "Programeiros");

include('includes/navbar.php');

$sql = 'SELECT * FROM tb_postagens ORDER BY id DESC LIMIT 6';

$stmt = $PDO->prepare($sql);
$stmt->execute();

?>
<section id="blog" class="container posts" style="margin-top:100px;>

<div class="row">
  <div class="col-md-8">
    <h1 class="title-main">Área de Postagens</h1>
    <div class="row">
    <?php
    $conteudo = '';
    while ($posts = $stmt->fetch(PDO::FETCH_ASSOC)):

    $conteudo = substr($posts['conteudo'],0,100);

    ?>

      <div class='col-md-6'>
          <div class='thumbnail'>
            <a href='post.php?id=<?php echo $posts['id']; ?>'><h3 class="titulo-thumb"><?php echo $posts['titulo']; ?></h3>
            <img src='upload/postagens/<?php echo $posts['imagem'] ?>' alt=''></a>
            <div class='caption'>
              <p><?php echo $conteudo; ?>...</p><br>
              <p><a href='post.php?id=<?php echo $posts['id']; ?>' class='btn btn-primary pull-right btn-mais' role='button'>Ler Mais</a></p>
            </div>
          </div>
        </div>
      </div>


    <?php endwhile; ?>

  </div>
</div>

<?php

  include ("includes/sidebar.php");

  include ("includes/footer.php");

?>

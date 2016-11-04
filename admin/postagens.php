<?php

include('includes/navbar.php');

   if(isset($_GET['delete'])) {
      $id_delete = $_GET['delete'];

      $seleciona = "SELECT imagem FROM tb_postagens WHERE id=:id_delete";
      try {
          $result = $PDO->prepare($seleciona);
          $result->bindParam(':id_delete',$id_delete, PDO::PARAM_INT);
          $result->execute();
          $contar = $result->rowCount();
          if($contar>0) {
              $loop = $result->fetchAll();
              foreach($loop as $exibir) {
              }

              $fotoDeleta = $exibir['imagem'];
              $arquivo = "../upload/postagens/" .$fotoDeleta;
              unlink($arquivo);

              $seleciona = "DELETE FROM tb_postagens WHERE id=:id_delete";
                  try {
                      $result = $PDO->prepare($seleciona);
                      $result->bindParam(':id_delete',$id_delete, PDO::PARAM_INT);
                      $result->execute();
                      $contar = $result->rowCount();
                      if($contar>0) {
                          echo '<div class="alert alert-success">
                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                  <strong>Postagem excluida com sucesso!</strong>
                                </div>';
                      } else {
                          echo '<div class="alert alert-danger">
                             <button type="button" class="close" data-dismiss="alert">×</button>
                             <strong>Erro ao excluir postagem!</strong>
                         </div>';
                      }

                      } catch(PDOException $erro) {
                          echo $erro;
                      }

                  } else {
                      echo '<div class="alert alert-danger">
                             <button type="button" class="close" data-dismiss="alert">×</button>
                             <strong>Post não existe, ou já foi excluido!</strong>
                           </div>';
                  }
               } catch(PDOException $erro) {
                      echo $erro;
                 }
   }

 ?>


</div><!-- row -->

      <div class="widget widget-table action-table">
        <div class="widget-header"> <i class="icon-th-list"></i>
          <h3>Últimos Posts</h3>
        </div>
        <!-- /widget-header -->
        <div class="widget-content">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th style="white-space: nowrap;"> Título da Postagem </th>
                <th style="white-space: nowrap;"> Data</th>
                <th style="white-space: nowrap;"> Usuário</th>
                <th> Resumo</th>
                <th class="td-actions"> </th>
              </tr>
            </thead>
            <tbody>
            <?php

                // PAGINACAO

            if(!empty($_GET['pg'])) {

                $pg = $_GET['pg'];
                if(!is_numeric($pg)) {
                echo "<script>location.href='index.php</script>";
                }
            }

            if(isset($pg)) {
                $pg = $_GET['pg'];
            } else {
                $pg = 1;
            }

            if(isset($_POST['busca'])) {
                $quantidade = 1000;
            } else {
                $quantidade = 6;
            }


            $inicio = ($pg * $quantidade) - $quantidade;

            if(isset($_POST['busca'])) {
                $busca = $_POST['busca'];

                $query = "SELECT * FROM tb_postagens WHERE TITULO LIKE '%$busca%' OR conteudo LIKE '%$busca%' ORDER BY id DESC LIMIT $inicio, $quantidade";

            } else {

                $query = "SELECT * FROM tb_postagens ORDER BY id DESC LIMIT $inicio, $quantidade";
            }

            $contagem = 1;

            try {
                $result = $PDO->prepare($query);
                $result->execute();
                $contar = $result->rowCount();
                if($contar>0) {
                    while ($postagem = $result->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                      <td > <?= $postagem["titulo"]; ?> </td>
                      <td style="white-space: nowrap;"> <?= date('d/m/Y', strtotime($postagem["data"])); ?></td>
                      <td > <?= $postagem["usuario"]; ?> </td>
                      <td> <?= substr ($postagem["conteudo"],0,260); echo "..."; ?> </td>
                      <td class="td-actions"><a href="edita_post.php?id=<?= $postagem["id"]; ?>" class="btn btn-small btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                      <a href="?delete=<?= $postagem["id"]; ?>" onClick='return confirm("Deseja realmente excluir esta postagem?")' class="btn btn-danger btn-small"><i class="fa fa-times" aria-hidden="true"></i></a></td>
                    </tr>
               <?php endwhile;
                } else {
                    echo "<tr>
                             <td colspan='7' style='text-align:center';> Não há postagens cadastradas! </td>
                          </tr>";
                }

            } catch(PDOException $e) {
                echo 'Erro:' . $e;
            }
            ?>

            </tbody>
          </table>
        </div>
        <!-- /widget-content -->

        <style>

            .paginas {
                width: 100%;
                padding: 10px 0;
                text-align: center;
                background-color: #fff;
                height: auto;
                margin: 10px auto;
            }

            .paginas a {
                width: auto;
                padding: 4px 10px;
                background-color: #eee;
                color: #333;
                margin: 0px 2.5px;
            }

            .paginas a:hover {
                text-decoration: none;
                background-color: #00ba8b;
                color: #fff;
            }

            <?php
                if(isset($_GET['pg'])) {
                    $num_pg = $_GET['pg'];
                } else {
                    $num_pg = 1;
                }
            ?>

            .paginas a.ativo<?php echo $num_pg; ?> {
                background-color: #00ba8b;
                color: #fff;
            }

        </style>


        <?php
            if(isset($_POST['busca'])) {
                $busca = $_POST['busca'];

                $sql = "SELECT * FROM tb_postagens WHERE titulo LIKE '%$busca%' OR conteudo LIKE '%$busca%'";

            } else {

                $sql = "SELECT * FROM tb_postagens";
            }

            try {
                $result = $PDO->prepare($sql);
                $result->execute();
                $totalRegistros = $result->rowCount();
            } catch(PDOException $e) {
                echo 'Erro:' . $e;
            }
          if($totalRegistros <= $quantidade) {

          } else {
              $paginas = ceil($totalRegistros/$quantidade);
              if($pg > $paginas) {
                  echo "<script>location.href='postagens.php?pg=$paginas';</script>";
              }
              $links = 5;

              if(isset($i)) {

              } else {
                  $i = '1';
              }

        ?>

        <div class="paginas">


            <a href="postagens.php?pg=1">Primeira Página</a>
            <?php
                if(isset($_GET['pg'])) {
                    $num_pg = $_GET['pg'];
                }

                for($i = $pg-$links; $i <= $pg-1; $i++) {
                    if($i<=0) {} else {
                        ?>
                        <a href="postagens.php?pg=<?php echo $i; ?>" class="ativo<?php echo $i; ?>"><?php echo $i; ?></a>

         <?php } } ?>

         <a href="#" class="ativo<?php echo $i; ?>"><?php echo $pg; ?></a>

        <?php
            for($i = $pg+1; $i <= $pg+$links; $i++) {
                if($i>$paginas) { }
                else{
                    ?>

                    <a href="postagens.php?pg=<?php echo $i; ?>" class="ativo<?php echo $i; ?>"><?php echo $i; ?></a>

        <?php } } ?>

        <a href="postagens.php?pg=<?php echo $paginas; ?>">Última Página</a>

         </div>

         <?php  } ?>

      </div>
    </div>
  </div>
</div>

<?php

include('includes/footer.php');

?>

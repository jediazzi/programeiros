</div>
<!-- row -->
<?php
	//excluir
	if(isset($_GET['delete'])){
		$id_delete = $_GET['delete'];
		
		// seleciona a imagem
		$seleciona = "SELECT * from tb_postagens WHERE id= :id_delete";
		try{
			$result = $PDO->prepare($seleciona);	
			$result->bindParam('id_delete',$id_delete, PDO::PARAM_INT);		
			$result->execute();
			$contar = $result->rowCount();
			if($contar>0){
				$loop = $result->fetchAll();
				foreach ($loop as $exibir){
				}
				
				$fotoDeleta = $exibir['imagem'];
				$arquivo = "upload/postagens/" .$fotoDeleta;
				unlink($arquivo);
				
				// exclui o registo
				$seleciona = "DELETE from tb_postagens WHERE id=:id_delete";
				try{
					$result = $PDO->prepare($seleciona);
					$result->bindParam('id_delete',$id_delete, PDO::PARAM_INT);				
					$result->execute();
					$contar = $result->rowCount();
					if($contar>0){
						echo '<div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <strong>Sucesso!</strong> O post foi excluído.
                </div>';
					}else{
						echo '<div class="alert alert-danger">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <strong>Erro!</strong> Não foi possível excluir o post.
                </div>';	
					}				
					
					}catch (PDOWException $erro){ echo $erro;}			}			
		}catch (PDOWException $erro){ echo $erro;}
			
	}

?>

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
                        <th style="white-space: nowrap;"> Imagem</th>
                        <th style="white-space: nowrap;"> Usuário</th>
                        <th> Resumo</th>
                        <th class="td-actions"> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                $query = "SELECT * FROM tb_postagens ORDER BY id DESC LIMIT 0,6";
    
                try {
                    $result = $PDO->prepare($query);
                    $result->execute();
                    $contar = $result->rowCount();
                    if($contar>0) {
                        while ($postagem = $result->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td>
                                <?= $postagem["titulo"]; ?>
                            </td>
                            <td style="white-space: nowrap;">
                                <?= date('d/m/Y', strtotime($postagem["data"])); ?>
                            </td>
                            <td> <img src="upload/postagens/<?= $postagem["imagem"]; ?>" alt="" style="height:50px;"> </td>
                            <td>
                                <?= $postagem["usuario"]; ?>
                            </td>
                            <td>
                                <?= substr ($postagem["conteudo"],0,260); echo "..."; ?>
                            </td>
                            <td class="td-actions"><a href="?acao=editapost&id=<?= $postagem["id"]; ?>" class="btn btn-small btn-success"><i class="btn-icon-only icon-edit"> </i></a>
                                <a href="myaccount.php?acao=visualisapost&delete=<?= $postagem["id"]; ?>" onClick='return confirm("Deseja realmente excluir esta postagem?")' class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a></td>
                        </tr>
                        <?php endwhile;
                    } else {
                        echo "<tr>
                                 <td colspan='4' style='text-align:center';> Não há postagens! </td>
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
    </div>
    <!-- /widget -->

    </div>
    <!-- /span6 -->
    </div>
    <!-- /row -->
    </div>
    <!-- /container -->
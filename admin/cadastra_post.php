<?php

include('includes/navbar.php');

?>

</div>
<!-- row -->

<div class="widget widget-table action-table">
    <div class="widget-header">
        <i class="icon-file"></i>
        <h3>Cadastra Nova Postagem</h3>
    </div>
    <!-- /widget-header -->

    <div class="widget-content">

        <?php

        if(isset($_POST['cadastrar'])) {
            $titulo = trim(strip_tags($_POST['titulo']));
            $conteudo = $_POST['conteudo'];
            $categoria = trim(strip_tags($_POST['categoria']));
            $usuario = trim(strip_tags($_SESSION['usuario']));
            $data = date('Y/m/d');
            $hora = date('H:i:s');

        //INFO IMAGEM
		$file 		= $_FILES['img'];
		$numFile	= count(array_filter($file['name']));

		//PASTA
		$folder		= '../upload/postagens';

		//REQUISITOS
		$permite 	= array('image/jpeg', 'image/png');
		$maxSize	= 1024 * 1024 * 1;

		//MENSAGENS
		$msg		= array();
		$errorMsg	= array(
			1 => 'O arquivo no upload é maior do que o limite definido em upload_max_filesize no php.ini.',
			2 => 'O arquivo ultrapassa o limite de tamanho em MAX_FILE_SIZE que foi especificado no formulário HTML',
			3 => 'o upload do arquivo foi feito parcialmente',
			4 => 'Não foi feito o upload do arquivo'
		);

		if($numFile <= 0){
			echo '<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Selecione uma imagem para a postagem!
					</div>';
		}
		else if($numFile > 1){
			echo '<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Você ultrapassou o limite de upload. Selecione apenas 1 foto e tente novamente!
					</div>';
		}else{
			for($i = 0; $i < $numFile; $i++){
				$name 	= $file['name'][$i];
				$type	= $file['type'][$i];
				$size	= $file['size'][$i];
				$error	= $file['error'][$i];
				$tmp	= $file['tmp_name'][$i];

				$extensao = @end(explode('.', $name));
				$novoNome = rand().".$extensao";

				if($error != 0)
					$msg[] = "<b>$name :</b> ".$errorMsg[$error];
				else if(!in_array($type, $permite))
					$msg[] = "<b>$name :</b> Erro imagem não suportada!";
				else if($size > $maxSize)
					$msg[] = "<b>$name :</b> Erro imagem ultrapassa o limite de 5MB";
				else{

					if(move_uploaded_file($tmp, $folder.'/'.$novoNome)){
						//$msg[] = "<b>$name :</b> Upload Realizado com Sucesso!";

                        $insert = "INSERT INTO tb_postagens (titulo,conteudo,imagem,categoria,data,hora,usuario) VALUES (:titulo,:conteudo,:imagem,:categoria,:data,:hora,:usuario)";

                    try {
                        $result = $PDO->prepare($insert);
                        $result->bindParam(':titulo',$titulo, PDO::PARAM_STR);
                        $result->bindParam(':conteudo',$conteudo, PDO::PARAM_STR);
                        $result->bindParam(':imagem',$novoNome, PDO::PARAM_STR);
                        $result->bindParam(':categoria',$categoria, PDO::PARAM_STR);
                        $result->bindParam(':usuario',$nomeUsuario, PDO::PARAM_STR);
                        $result->bindParam(':data',$data, PDO::PARAM_STR);
                        $result->bindParam(':hora',$hora, PDO::PARAM_STR);
                        $result->execute();
                        $contar = $result->rowCount();
                        if($contar>0) {
                            echo '<div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>Post incluido com Sucesso!</strong>
                            </div>';
                        } else {
                            echo '<div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>Erro ao cadastrar post!</strong>
                            </div>';
                        }

                    } catch(PDOException $e) {
                        echo 'Erro:' . $e;
                        }

					}else
						$msg[] = "<b>$name :</b> Desculpe! Ocorreu um erro...";

				}

				foreach($msg as $pop)
				echo '';
					//echo $pop.'<br>';
			}
		}

                }

                ?>

            <br>

            <form id="edit-profile" class="form-horizontal" method="post" enctype="multipart/form-data">
                <fieldset>

                    <div class="form-group">
                        <label for="titulo">Titulo do Post:</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Titulo da Postagem">
                    </div>

                    <div class="form-group">
                        <label for="imagem">Imagem para o Post:</label>
                            <input type="file" class="form-control" id="imagem" name="img[]">
                    </div>
                    <!-- /control-group -->

                    <div class="form-group">
                        <label for="categoria">Categoria:</label>
                            <input type="text" class="form-control" id="categoria" name="categoria">
                    </div>

                    <div class="form-group">
                        <label for="conteudo">Conteúdo do Post:</label>
                            <textarea class="form-control" id="conteudo" name="conteudo" rows="8" placeholder="Conteúdo da Postagem"></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="cadastrar" class="btn btn-primary">Incluir Post</button>
                        <button type="reset" class="btn btn-danger">Cancelar</button>
                    </div>

                </fieldset>
            </form>
    </div>
</div>
</div>
</div>
</div>

<script src="../js/nicEdit.js"></script>
<script type="text/javascript">
    bkLib.onDomLoaded(function () {
        nicEditors.allTextAreas()
    });
</script>

<?php

include('includes/footer.php');

?>

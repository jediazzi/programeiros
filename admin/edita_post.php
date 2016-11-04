<?php

    include('includes/navbar.php');

    if(!isset($_GET['id'])) {
        header('Location: index.php');
        exit();
    }
    // RECUPERA OS DADOS
    $id = $_GET['id'];
    $select = 'SELECT * FROM tb_postagens WHERE id=:id';
    $contagem = 1;

    try {
        $resultado = $PDO->prepare($select);
        $resultado->bindParam(':id',$id,PDO::PARAM_INT);
        $resultado->execute();
        $contar = $resultado->rowCount();
        if($contar>0) {
            while($mostra = $resultado->FETCH(PDO::FETCH_ASSOC)) {
                $idPost = $mostra['id'];
                $titulo = $mostra['titulo'];
                $conteudo = $mostra['conteudo'];
                $imagem = $mostra['imagem'];
            }
        } else {
            echo '<div class="span12"><div class="alert alert-danger">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      Não há dados cadastratos com o ID informado!
                  </div></div>';
            exit();
          }
        } catch(PDOException $e) {
            echo 'Erro:' . $e;
        }

        $novoNome = $imagem;

?>

     </div><!-- row -->

          <div class="widget widget-table action-table">
            	<div class="widget-header">
                    <i class="icon-file"></i>
                    <h3>Edita Postagem</h3>
                </div> <!-- /widget-header -->

                <div class="widget-content">

                <?php
                    //ATUALIZA POST
                if(isset($_POST['atualiza'])) {
                    $titulo = trim(strip_tags($_POST['titulo']));
                    $conteudo = $_POST['conteudo'];

                    if(!empty($_FILES['img']['name'])) {



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
                   /* echo '<div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                Selecione uma imagem para a postagem!
                            </div>'; */
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
                                $arquivo = "../upload/postagens/" .$imagem;
                                unlink($arquivo);

                                }
                                        foreach($msg as $pop)
                                        echo '';
                                            //echo $pop.'<br>';
                                    }
                                }
                }
                            } //SE O INPUT FILE NAO ESTIVER VAZIO
                            else {

                                $novoNome = $imagem;

                            }

                                $update = 'UPDATE tb_postagens SET titulo=:titulo, conteudo=:conteudo, imagem=:imagem WHERE id=:id';

                            try {
                                $result = $PDO->prepare($update);
                                $result->bindParam(':titulo',$titulo, PDO::PARAM_STR);
                                $result->bindParam(':conteudo',$conteudo, PDO::PARAM_STR);
                                $result->bindParam(':imagem',$novoNome, PDO::PARAM_STR);
                                $result->bindParam(':id',$id, PDO::PARAM_INT);
                                $result->execute();
                                $contar = $result->rowCount();
                                if($contar>0) {
                                    echo '<div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                    <strong>Post alterado com Sucesso!</strong>
                                    </div>';
                                } else {
                                    echo '<div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                    <strong>Erro ao editar!</strong>
                                    </div>';
                                }

                            } catch(PDOException $e) {
                                echo 'Erro:' . $e;
                                }

                            }

                 else {
                    $novoNome = $imagem;
                }

                ?>

                    <br>

                    <form id="edit-profile" method="post" enctype="multipart/form-data">
                        <fieldset>

                            <div class="form-group">
                                <label for="titulo">Titulo do Post:</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Titulo da Postagem" value="<?php echo $titulo; ?>">
                            </div>

                            <div class="form-group">
                                <label for="imagem">Imagem para o Post:</label>
                                    <input type="file" class="form-control" id="imagem" name="img[]" >
                                    <img src="../upload/postagens/<?php echo $novoNome; ?>" alt="" style="height:40px;">
                            </div>

                            <div class="form-group">
                                <label for="conteudo">Conteúdo do Post:</label>
                                    <textarea class="form-control" id="conteudo" name="conteudo" rows="8"><?php echo $conteudo; ?></textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" name="atualiza" class="btn btn-primary">Atualizar Post</button>
                                <button type="reset" class="btn btn-danger">Limpar Campos</button>
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
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>

<?php

include('includes/footer.php');

?>

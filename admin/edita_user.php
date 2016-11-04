<?php

  include('includes/navbar.php');

    // RECUPERA OS DADOS
    if(!isset($_GET['id'])) {
        header('Location: usuarios.php');
        exit();
    }
    $id = $_GET['id'];
    $select = 'SELECT * FROM login WHERE id=:id';

    try {
        $resultado = $PDO->prepare($select);
        $resultado->bindParam(':id',$id,PDO::PARAM_INT);
        $resultado->execute();
        $contar = $resultado->rowCount();
        if($contar>0) {
            while($mostra = $resultado->FETCH(PDO::FETCH_ASSOC)) {
                $idPost = $mostra['id'];
                $nome = $mostra['nome'];
                $email = $mostra['email'];
                $usuario = $mostra['usuario'];
            }
        } else {
            echo '<div class="alert alert-danger">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      Não há dados cadastratos com o ID informado!
                  </div>';
            exit();
          }
        } catch(PDOException $e) {
            echo 'Erro:' . $e;
        }

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
                    $nome = trim(strip_tags($_POST['nome']));
                    $email = trim(strip_tags($_POST['email']));
                    $usuario = trim(strip_tags($_POST['usuario']));
                    $senha = trim(strip_tags(md5(strrev($_POST['senha']))));
                    $rep_senha = trim(strip_tags(md5(strrev($_POST['rep_senha']))));

                    if($senha != $rep_senha) {
                        echo '<div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>As senhas não conferem!</strong>
                              </div>';
                    } else {

                    $update = 'UPDATE login SET nome=:nome, email=:email, usuario=:usuario, senha=:senha WHERE id=:id';

                    try {
                        $result = $PDO->prepare($update);
                        $result->bindParam(':nome',$nome, PDO::PARAM_STR);
                        $result->bindParam(':email',$email, PDO::PARAM_STR);
                        $result->bindParam(':usuario',$usuario, PDO::PARAM_STR);
                        $result->bindParam(':senha',$senha, PDO::PARAM_INT);
                        $result->bindParam(':id',$id, PDO::PARAM_INT);
                        $result->execute();
                        $contar = $result->rowCount();
                        if($contar>0) {
                            echo '<div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Usuário alterado com Sucesso!</strong>
                            </div>';
                        } else {
                            echo '<div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Erro ao alterar!</strong>
                            </div>';
                        }

                    } catch(PDOException $e) {
                        echo 'Erro:' . $e;
                        }

                        }

                    }

                ?>

                    <br>

                    <form id="edit-profile" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <fieldset>

                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do usuário" value="<?php echo $nome; ?>">
                            </div>

                            <div class="form-group">
                                <label for="email">E-mail:</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="E-mail do usuário" value="<?php echo $email; ?>">
                            </div>

                            <div class="form-group">
                              <label for="usuario">Usuário:</label>
                                <input type="text" class="form-control" id="usuario" name="usuario"  placeholder="Username" value="<?php echo $usuario; ?>">
                            </div>

                            <div class="form-group">
                              <label for="senha">Senha:</label>
                              <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha do usuário" >
                            </div>

                            <div class="form-group">
                              <label for="rep_senha">Repete Senha:</label>
                              <input type="password" class="form-control" id="rep_senha" name="rep_senha" placeholder="Repita a Senha do usuário" >
                            </div>

                            <div class="form-group">
                              <button type="submit" name="atualiza" class="btn btn-primary">Alterar Usuário</button>
                              <button type="reset" class="btn btn-danger">Cancelar</button>
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

include('includes/footer.php');

?>

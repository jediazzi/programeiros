<?php include('includes/navbar.php'); ?>

</div><!-- row -->

          <div class="widget widget-table action-table">
            	<div class="widget-header">
                    <i class="icon-file"></i>
                    <h3>Cadastra Novo Usuário</h3>
                </div> <!-- /widget-header -->

                <div class="widget-content">

                <?php

                if(isset($_POST['cadastrar'])) {
                    $nome = trim(strip_tags($_POST['nome']));
                    $email = trim(strip_tags($_POST['email']));
                    $usuario = trim(strip_tags($_POST['usuario']));
                    $senha = trim(strip_tags(md5(strrev($_POST['senha']))));
                    $rep_senha = trim(strip_tags(md5(strrev($_POST['rep_senha']))));
                    $data = date('Y/m/d');

                    if($senha != $rep_senha) {
                        echo '<div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <strong>As senhas não conferem!</strong>
                              </div>';
                    } else {

                    $consulta = "SELECT * FROM login WHERE usuario = :usuario";

                    try {
                            $resultado = $PDO->prepare($consulta);
                            $resultado->bindParam(':usuario',$usuario, PDO::PARAM_STR);
                            $resultado->execute();
                            $contar = $resultado->rowCount();
                            if($contar>0) {
                                echo '<div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <strong>Já existe um usuário com este nome!</strong>
                                </div>';
                            } else {

                        $insert = "INSERT INTO login (nome,email,usuario,senha,data) VALUES (:nome,:email,:usuario,:senha,:data)";

                        try {
                            $result = $PDO->prepare($insert);
                            $result->bindParam(':nome',$nome, PDO::PARAM_STR);
                            $result->bindParam(':email',$email, PDO::PARAM_STR);
                            $result->bindParam(':usuario',$usuario, PDO::PARAM_STR);
                            $result->bindParam(':senha',$senha, PDO::PARAM_INT);
                            $result->bindParam(':data',$data, PDO::PARAM_STR);
                            $result->execute();
                            $contar = $result->rowCount();
                            if($contar>0) {
                                echo '<div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <strong>Usuário incluido com Sucesso!</strong>
                                </div>';
                            } else {
                                echo '<div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <strong>Erro ao cadastrar usuário!</strong>
                                </div>';
                            }

                        } catch(PDOException $e) {
                            echo 'Erro:' . $e;
                            }

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
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do usuário" required>
                            </div>

                            <div class="form-group">
                                <label for="email">E-mail:</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="E-mail do usuário" required>
                            </div>

                            <div class="form-group">
                                <label for="usuario">Usuário:</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario"  placeholder="Username" required>
                            </div>

                            <div class="form-group">
                                <label for="senha">Senha:</label>
                                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha do usuário" required>
                            </div>

                            <div class="form-group">
                                <label for="rep_senha">Repete Senha:</label>
                                    <input type="password" class="form-control" id="rep_senha" name="rep_senha" placeholder="Repita a Senha do usuário" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" name="cadastrar" class="btn btn-primary">Incluir Usuário</button>
                                <button type="reset" class="btn btn-danger">Cancelar</button>
                            </div> <!-- /form-actions -->

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

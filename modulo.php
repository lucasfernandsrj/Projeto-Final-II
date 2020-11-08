<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php
    require_once("lib/Database/ConnectionAbstract.php");
    $conn = Database\ConnectionAbstract::getConn();
    //var_dump($conn);

    $titulo = "Módulo";
    include_once "templates/head.php";
    ?>
    <body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">
            <?php include_once "templates/sidebar.php"; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                        <a href="sistema.php"><button type="button" class="btn btn-outline-dark btn-lg mx-2">Sistema</button></a>
                        <a href="modulo.php"><button type="button" class="btn btn-outline-primary btn-lg mx-2">Módulo</button></a>
                        <a href="risco.php"><button type="button" class="btn btn-outline-dark btn-lg mx-2">Risco</button></a>
                        <a href="analise.php"><button type="button" class="btn btn-outline-dark btn-lg mx-2">Análise do Gerente</button></a>
                        <a href="analista.php"><button type="button" class="btn btn-outline-dark btn-lg mx-2">Analista</button></a>
                    </nav>
                    <!-- End of Topbar -->
                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>

                        <!-- Page Heading -->
                        <h1 class="h3 mb-2 text-gray-800">Módulo</h1>
                        <p class="mb-4">A atual página mostra a relação de módulos cadastrados. Permite ao gerente de projetos adicionar novos módulos ou realizar alterações.</p>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Módulo</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto mr-auto mb-2">
                                        <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#ModalCadastrarModulo">
                                            <i class="fas fa-list"></i>&nbsp;Cadastrar Módulo
                                        </button>&nbsp;
                                        <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#ModalCadastrarModulo2">
                                            <i class="fas fa-list"></i>&nbsp;Vincular Módulo
                                        </button>
                                    </div>
                                    <div class="col-auto mb-2">
                                        <button class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#ModalAn">
                                            <i class="fas fa-print"></i>&nbsp;Gerar Relatório
                                        </button>
                                    </div>
                                </div>
                                <!-- Tabela -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-dark" id="DataTableModulo" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center" colspan="6">Informações</th>
                                                <th class="text-center" colspan="2">Ferramentas</th>
                                            </tr>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nível</th>
                                                <th>Nome</th>
                                                <th>Ambiente</th>
                                                <th>Sistema</th>
                                                <th>Módulo Vinculado</th>
                                                <th class="text-center">Detalhe</th>
                                                <th class="text-center">Editar</th>
                                                <!--<th class="text-center">Excluir</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="m-0 font-weight-bold text-dark">
                                                <th>ID</th>
                                                <th>Nível</th>
                                                <th>Nome</th>
                                                <th>Ambiente</th>
                                                <th>Sistema</th>
                                                <th>Módulo Vinculado</th>
                                                <th class="text-center">Detalhe</th>
                                                <th class="text-center">Editar</th>
                                                <!--<th class="text-center">Excluir</th>-->
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            require_once("lib/Database/Connection.php");
                                            $query = "
                                                    SELECT 
                                                        tbmodulo.*,
                                                        tbsistema.nome sistema_nome
                                                    FROM 
                                                        tbmodulo 
                                                    LEFT JOIN 
                                                        tbsistema
                                                    ON 
                                                        tbmodulo.idsistema = tbsistema.idsistema";
                                            $result = mysqli_query($conn, $query);
                                            foreach ($result as $row) {
                                                ?>
                                                <tr>
                                                    <td><?= $row['idmodulo']; ?></td>
                                                    <td><?= $row['nivel']; ?></td>
                                                    <td><?= $row['nome']; ?></td>
                                                    <td><?= $row['ambiente']; ?></td>
                                                    <td><?= $row['sistema_nome']; ?></td>
                                                    <?php
                                                    if ($row['fk_idmodulo'] != "") {
                                                        $fk_idmodulo = $row['fk_idmodulo'];
                                                        $query_fk_idmodulo = "SELECT nome FROM tbmodulo WHERE idmodulo = $fk_idmodulo";
                                                        $result_fk_idmodulo = mysqli_query($conn, $query_fk_idmodulo);
                                                        foreach ($result_fk_idmodulo as $row_fk_idmodulo) {
                                                            ?>
                                                            <td><?= $row_fk_idmodulo['nome']; ?> (ID: <?= $row['fk_idmodulo']; ?>)</td><?php
                                                        }
                                                    } else {
                                                        ?><td></td><?php
                                                    }
                                                    ?>
                                                    <td class="text-center">
                                                        <button type="button" onClick="Detalhe(this)" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalDetalheModulo"
                                                                data-modulonome="<?= $row['nome']; ?>"
                                                                data-modulodescricao="<?= $row['descricao']; ?>"
                                                                data-moduloambiente="<?= $row['ambiente']; ?>"
                                                                data-modulofkidmodulo="<?= $row['fk_idmodulo']; ?>"
                                                                data-modulonivel="<?= $row['nivel']; ?>"
                                                                >
                                                            <i class="fas fa-fingerprint"></i>&nbsp;Detalhe
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#ModalEditarModulo"
                                                                data-moduloidmodulo="<?= $row['idmodulo']; ?>"
                                                                data-modulonome="<?= $row['nome']; ?>"
                                                                data-modulodescricao="<?= $row['descricao']; ?>"
                                                                data-moduloambiente="<?= $row['ambiente']; ?>"
                                                                data-modulofkidmodulo="<?= $row['fk_idmodulo']; ?>"
                                                                data-modulonivel="<?= $row['nivel']; ?>"
                                                                >
                                                            <i class="fas fa-edit"></i>&nbsp;Editar
                                                        </button>
                                                    </td>
                                                    <!--
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                                >
                                                            <i class="fas fa-eraser"></i>&nbsp;Excluir
                                                        </button>
                                                    </td>
                                                    -->
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Fim Tabela -->
                            </div>
                        </div>

                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->
                <?php include_once "templates/footer.php"; ?>
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->

        <!-- Modal Cadastrar -->
        <div class="modal fade" id="ModalCadastrarModulo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cadastrar Módulo de Nível 1</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="action/cadastrarModulo.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5><i class="fa fa-list"></i> Informações do Módulo</h5>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome</label>
                                        <input type="text" class="form-control" name="modulonome" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Descrição</label>
                                        <textarea class="form-control" rows="1" name="modulodescricao" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Ambiente Organizacional</label>
                                        <select class="form-control" name="moduloambiente" required>
                                            <option value="">Selecione</option>
                                            <option value="Administrativo">Administrativo</option>
                                            <option value="Configuração">Configuração</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nível</label>
                                        <input type="text" class="form-control" id="modulonivel" value="1" disabled>
                                        <input type="hidden" class="form-control" id="modulonivel" name="modulonivel" value="1" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <hr>
                                    <h5><i class="fa fa-list"></i> Informações do Sistema*</h5>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome do Sistema</label>
                                        <select class="form-control" name="moduloidsistema" required>
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_sistema = "SELECT idsistema, nome FROM tbsistema";
                                            $result_sistema = mysqli_query($conn, $query_sistema);
                                            foreach ($result_sistema as $row_sistema) {
                                                ?>
                                                <option value="<?= $row_sistema['idsistema']; ?>"><?= $row_sistema['nome']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <small class="help-block">*Campo(s) obrigatório(s).</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary" name="btnCadastrar">Confirmar Dados</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fim Modal Cadastrar -->

        <!-- Modal Vincular -->
        <div class="modal fade" id="ModalCadastrarModulo2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Vincular Módulo - Submódulo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="action/vincularModulo.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5><i class="fa fa-list"></i> Informações do Módulo</h5>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome do Módulo</label>
                                        <input type="text" class="form-control" name="modulonome" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Descrição</label>
                                        <textarea class="form-control" rows="1" name="modulodescricao" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <hr>
                                    <h5><i class="fa fa-list"></i> Informações do Módulo*</h5>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome do Módulo*²</label>
                                        <select class="form-control" name="modulofk_idmodulo" required>
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_modulo2 = "SELECT idmodulo,nivel, nome,idsistema,fk_idmodulo FROM tbmodulo WHERE nivel < 3 ORDER BY idsistema ASC, nivel ASC";
                                            $result_modulo2 = mysqli_query($conn, $query_modulo2);
                                            foreach ($result_modulo2 as $row_modulo2) {
                                                if ($row_modulo2['nivel'] == 1) {
                                                    $modulo_idsistema_nv1 = $row_modulo2['idsistema'];
                                                    $query_modulonv1 = "SELECT nome FROM tbsistema WHERE idsistema = '$modulo_idsistema_nv1' LIMIT 1";
                                                    $result_modulonv1 = mysqli_query($conn, $query_modulonv1);
                                                    foreach ($result_modulonv1 as $row_modulonv1) {
                                                        $sistema_nome_nv1 = $row_modulonv1['nome'];
                                                    }
                                                    ?>
                                                    <option value="<?= $row_modulo2['idmodulo']; ?>">ID: <?= $row_modulo2['idmodulo']; ?> - Nível: <?= $row_modulo2['nivel']; ?> - Sistema: <?= $sistema_nome_nv1; ?> - Módulo: <?= $row_modulo2['nome']; ?></option>
                                                    <?php
                                                } else {
                                                    $modulo_fk_idmodulo = $row_modulo2['fk_idmodulo'];
                                                    $query_modulofk = "SELECT nome,nivel,idmodulo FROM tbmodulo WHERE idmodulo = '$modulo_fk_idmodulo' LIMIT 1";
                                                    $result_modulofk = mysqli_query($conn, $query_modulofk);
                                                    foreach ($result_modulofk as $row_modulofk) {
                                                        $modulofk_nome = $row_modulofk['nome'];
                                                    }
                                                    ?>
                                                    <option value="<?= $row_modulo2['idmodulo']; ?>">ID: <?= $row_modulo2['idmodulo']; ?> - Nível: <?= $row_modulo2['nivel']; ?> - Módulo: <?= $row_modulo2['nome']; ?> - Módulo Vinculado: <?= $modulofk_nome; ?> (ID: <?= $row_modulofk['idmodulo']; ?>)</option>
                                                    <?php
                                                }
                                                ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <small class="help-block">*Todos os campos são obrigatórios.</small>
                                </div>
                                <div class="col-lg-12">
                                    <small class="help-block">*²O campo exibe uma lista de módulos até o nível 2.</small>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary" name="btnCadastrar">Confirmar Dados</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fim Modal Vincular -->

        <!-- Modal Detalhe -->
        <div class="modal fade" id="ModalDetalheModulo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalhe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="text-primary"><i class="fa fa-clipboard"></i> Informações do Módulo</h5>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome</label>
                                    <p><output type="text" id="detalhe_modulonome"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6" id="mostra_modambiente">
                                <div>
                                    <label class="col-form-label font-weight-bold">Ambiente Organizacional</label>
                                    <p><output type="text" id="detalhe_moduloambiente"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Descrição</label>
                                    <p><output type="text" id="detalhe_modulodescricao"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nível</label>
                                    <p><output type="text" id="detalhe_modulonivel"></output></p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fim Modal Detalhe -->

        <!-- Modal Editar -->
        <div class="modal fade" id="ModalEditarModulo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Módulo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="action/editarModulo.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5><i class="fa fa-list"></i> Informações do Módulo</h5>
                                </div>
                                <input type="hidden" class="form-control" id="editar_moduloidmodulo" name="editar_moduloidmodulo" required>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome</label>
                                        <input type="text" class="form-control" id="editar_modulonome" name="editar_modulonome" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Descrição</label>
                                        <textarea class="form-control" id="editar_modulodescricao" name="editar_modulodescricao" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Ambiente Organizacional</label>
                                        <select class="form-control" id="editar_moduloambiente" name="editar_moduloambiente" required>
                                            <option value="">Selecione</option>
                                            <option value="Administrativo">Administrativo</option>
                                            <option value="Configuração">Configuração</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Nível</label>
                                        <input type="text" class="form-control" id="editar_modulonivel" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-12" id="mostra_modulo">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome do Módulo*²</label>
                                        <select class="form-control" id="editar_modulofkidmodulo" name="editar_modulofkidmodulo">
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_modulo2 = "SELECT idmodulo,nivel, nome,idsistema,fk_idmodulo FROM tbmodulo WHERE nivel < 3 ORDER BY idsistema ASC, nivel ASC";
                                            $result_modulo2 = mysqli_query($conn, $query_modulo2);
                                            foreach ($result_modulo2 as $row_modulo2) {
                                                if ($row_modulo2['nivel'] == 1) {
                                                    $modulo_idsistema_nv1 = $row_modulo2['idsistema'];
                                                    $query_modulonv1 = "SELECT nome FROM tbsistema WHERE idsistema = '$modulo_idsistema_nv1' LIMIT 1";
                                                    $result_modulonv1 = mysqli_query($conn, $query_modulonv1);
                                                    foreach ($result_modulonv1 as $row_modulonv1) {
                                                        $sistema_nome_nv1 = $row_modulonv1['nome'];
                                                    }
                                                    ?>
                                                    <option value="<?= $row_modulo2['idmodulo']; ?>">ID: <?= $row_modulo2['idmodulo']; ?> - Nível: <?= $row_modulo2['nivel']; ?> - Módulo: <?= $row_modulo2['nome']; ?> - Sistema: <?= $sistema_nome_nv1; ?> </option>
                                                    <?php
                                                } else {
                                                    $modulo_fk_idmodulo = $row_modulo2['fk_idmodulo'];

                                                    $query_modulofk = "SELECT nome,nivel,idmodulo FROM tbmodulo WHERE idmodulo = '$modulo_fk_idmodulo' LIMIT 1";
                                                    $result_modulofk = mysqli_query($conn, $query_modulofk);
                                                    foreach ($result_modulofk as $row_modulofk) {
                                                        $modulofk_nome = $row_modulofk['nome'];
                                                    }
                                                    ?>
                                                    <option value="<?= $row_modulo2['idmodulo']; ?>">ID: <?= $row_modulo2['idmodulo']; ?> - Nível: <?= $row_modulo2['nivel']; ?> - Módulo: <?= $row_modulo2['nome']; ?> - Módulo Vinculado: <?= $modulofk_nome; ?> (ID: <?= $row_modulofk['idmodulo']; ?>)</option>
                                                    <?php
                                                }
                                                ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <small class="help-block">*Campo(s) obrigatório(s).</small>
                                </div>
                                <div class="col-lg-12">
                                    <small class="help-block">*²O campo exibe uma lista de módulos até o nível 2.</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary" name="btnEditar">Confirmar Dados</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fim Modal Editar -->
        <?php include_once "templates/frameworks.php"; ?>

        <!-- Modal Detalhe-->
        <script>
            $('#ModalDetalheModulo').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var detalhe_modulonome = button.data('modulonome'); // Extract info from data-* attributes
                var detalhe_modulodescricao = button.data('modulodescricao');
                var detalhe_moduloambiente = button.data('moduloambiente');
                var detalhe_modulofk_idmodulo = button.data('modulofkidmodulo');
                var detalhe_modulonivel = button.data('modulonivel');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Detalhe do Módulo: ' + detalhe_modulonome);
                modal.find('#detalhe_modulonome').val(detalhe_modulonome);
                modal.find('#detalhe_modulodescricao').val(detalhe_modulodescricao);
                modal.find('#detalhe_moduloambiente').val(detalhe_moduloambiente);
                modal.find('#detalhe_modulofk_idmodulo').val(detalhe_modulofk_idmodulo);
                modal.find('#detalhe_modulonivel').val(detalhe_modulonivel);
            });
        </script>
        <!-- Fim Modal Detalhe-->

        <!-- Modal Editar-->
        <script>
            $('#ModalEditarModulo').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var editar_moduloidmodulo = button.data('moduloidmodulo'); // Extract info from data-* attributes
                var editar_modulonome = button.data('modulonome'); // Extract info from data-* attributes
                var editar_modulodescricao = button.data('modulodescricao'); // Extract info from data-* attributes
                var editar_moduloambiente = button.data('moduloambiente');
                var editar_modulofkidmodulo = button.data('modulofkidmodulo');
                var editar_modulonivel = button.data('modulonivel');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Editar Módulo: ' + editar_modulonome);
                modal.find('#editar_moduloidmodulo').val(editar_moduloidmodulo);
                modal.find('#editar_modulonome').val(editar_modulonome);
                modal.find('#editar_modulodescricao').val(editar_modulodescricao);
                modal.find('#editar_moduloambiente').val(editar_moduloambiente);
                modal.find('#editar_modulofkidmodulo').val(editar_modulofkidmodulo);
                modal.find('#editar_modulonivel').val(editar_modulonivel);

                if (editar_modulonivel === 1) {
                    $('#mostra_modulo').hide();
                } else {
                    $('#mostra_modulo').show();
                }
            });
        </script>
        <!-- Fim Modal Editar-->

        <!-- Reseta Modal Cadastrar ao Fechar-->
        <script>
            $('#ModalCadastrarModulo').on('hidden.bs.modal', function () {
                $(this).find("input,textarea,select").val('').end();
                $('#modulonivel').val(1);
            });
        </script>
        <!-- Fim Reseta Modal Cadastrar ao Fechar-->

        <!-- Reseta Modal Cadastrar ao Fechar-->
        <script>
            $('#ModalCadastrarModulo2').on('hidden.bs.modal', function () {
                $(this).find("input,textarea,select").val('').end();
            });
        </script>
        <!-- Fim Reseta Modal Cadastrar ao Fechar-->
        <!-- Datatable -->
        <script>
            $(document).ready(function () {
                $('#DataTableModulo').DataTable({
                    "pagingType": "full_numbers",
                    initComplete: function () {
                        this.api().columns().every(function () {
                            var column = this;
                            column.data().unique().sort().each(function (x, z) {
                                if (x.length < 100) {
                                    var select = $('<select><option value="">Todos</option></select>')
                                            .appendTo($(column.footer()).empty())
                                            .on('change', function () {
                                                var val = $.fn.dataTable.util.escapeRegex(
                                                        $(this).val()
                                                        );
                                                column
                                                        .search(val ? '^' + val + '$' : '', true, false)
                                                        .draw();
                                            });
                                    column.data().unique().sort().each(function (d, j) {
                                        if (d.length < 100) {
                                            select.append('<option value="' + d + '">' + d + '</option>');
                                        }
                                    });
                                }
                            });

                        });
                    }
                });
            });
        </script>
        <!-- Fim Datatable -->
    </body>

</html>

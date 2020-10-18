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
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">Cadastros
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
                                    <table class="table table-bordered table-hover" id="DataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Descrição</th>
                                                <th>Ambiente</th>
                                                <th>Nome do Sistema</th>
                                                <th class="text-center">Detalhe</th>
                                                <th class="text-center">Editar</th>
                                                <!--<th class="text-center">Excluir</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="m-0 font-weight-bold text-dark">
                                                <th>Nome</th>
                                                <th>Descrição</th>
                                                <th>Ambiente</th>
                                                <th>Nome do Sistema</th>
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
                                                    <td><?= $row['nome']; ?></td>
                                                    <td><?= $row['descricao']; ?></td>
                                                    <td><?= $row['ambiente']; ?></td>
                                                    <td><?= $row['sistema_nome']; ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalDetalheModulo"
                                                                data-modnome="<?= $row['nome']; ?>"
                                                                data-moddescricao="<?= $row['descricao']; ?>"
                                                                data-modambiente="<?= $row['ambiente']; ?>"
                                                                
                                                                >
                                                            <i class="fas fa-fingerprint"></i>&nbsp;Detalhe
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#ModalEditarModulo"
                                                                data-modidmodulo="<?= $row['idmodulo']; ?>"
                                                                data-modnome="<?= $row['nome']; ?>"
                                                                data-moddescricao="<?= $row['descricao']; ?>"
                                                                data-modambiente="<?= $row['ambiente']; ?>"
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
                        <h5 class="modal-title" id="exampleModalLabel">Cadastrar Módulo</h5>
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
                                        <input type="text" class="form-control" name="mod_nome" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Descrição</label>
                                        <input type="text" class="form-control" name="mod_descricao" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Ambiente</label>
                                        <input type="text" class="form-control" name="mod_ambiente" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <hr>
                                    <h5><i class="fa fa-list"></i> Informações do Sistema*</h5>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome do Sistema</label>
                                        <select class="form-control" name="mod_idsistema" required>
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
                                <h5><i class="fa fa-list"></i> Informações do Módulo</h5>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome</label>
                                    <p><output type="text" id="detalhe_mod_nome"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label class="col-form-label font-weight-bold">Descrição</label>
                                    <p><output type="text" id="detalhe_mod_descricao"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label class="col-form-label font-weight-bold">Ambiente</label>
                                    <p><output type="text" id="detalhe_mod_ambiente"></output></p>
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
                                <input type="hidden" class="form-control" id="editar_mod_idmodulo" name="editar_mod_idmodulo" required>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome*</label>
                                        <input type="text" class="form-control" id="editar_mod_nome" name="editar_mod_nome" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Descrição*</label>
                                        <input type="text" class="form-control" id="editar_mod_descricao" name="editar_mod_descricao" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Ambiente*</label>
                                        <input type="text" class="form-control" id="editar_mod_ambiente" name="editar_mod_ambiente" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <small class="help-block">*Campo(s) obrigatório(s).</small>
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
                var detalhe_mod_nome = button.data('modnome'); // Extract info from data-* attributes
                var detalhe_mod_descricao = button.data('moddescricao');
                var detalhe_mod_ambiente = button.data('modambiente');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Detalhe do Módulo: ' + detalhe_mod_nome);
                modal.find('#detalhe_mod_nome').val(detalhe_mod_nome);
                modal.find('#detalhe_mod_descricao').val(detalhe_mod_descricao);
                modal.find('#detalhe_mod_ambiente').val(detalhe_mod_ambiente);
            });
        </script>
        <!-- Fim Modal Detalhe-->

        <!-- Modal Editar-->
        <script>
            $('#ModalEditarModulo').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var editar_mod_idmodulo = button.data('modidmodulo'); // Extract info from data-* attributes
                var editar_mod_nome = button.data('modnome'); // Extract info from data-* attributes
                var editar_mod_descricao = button.data('moddescricao'); // Extract info from data-* attributes
                var editar_mod_ambiente = button.data('modambiente');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Editar Módulo: ' + editar_mod_nome);
                modal.find('#editar_mod_idmodulo').val(editar_mod_idmodulo);
                modal.find('#editar_mod_nome').val(editar_mod_nome);
                modal.find('#editar_mod_descricao').val(editar_mod_descricao);
                modal.find('#editar_mod_ambiente').val(editar_mod_ambiente);
            });
        </script>
        <!-- Fim Modal Editar-->

        <!-- Reseta Modal Cadastrar ao Fechar-->
        <script>
            $('#ModalCadastrarModulo').on('hidden.bs.modal', function () {
                $(this).find("input,textarea,select").val('').end();

            });
        </script>
        <script>
            $(document).ready(function () {
                $('#DataTable').DataTable({
                    buttons: [
                        'print'
                    ]
                });
            });
        </script>
        <!-- Fim Reseta Modal Cadastrar ao Fechar-->
    </body>

</html>

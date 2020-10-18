<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php
    require_once("lib/Database/ConnectionAbstract.php");
    $conn = Database\ConnectionAbstract::getConn();
    //var_dump($conn);

    $titulo = "Sistema";
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
                        <h1 class="h3 mb-2 text-gray-800">Sistema</h1>
                        <p class="mb-4">A atual página mostra a relação de sistemas cadastrados. Permite ao gerente de projetos adicionar novos sistemas ou realizar alterações.</p>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Sistema</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto mr-auto mb-2">
                                        <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#ModalCadastrarSistema">
                                            <i class="fas fa-list"></i>&nbsp;Cadastrar Sistema
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
                                                <th>Data Inicial</th>
                                                <th>Data Final</th>
                                                <th class="text-center">Detalhe</th>
                                                <th class="text-center">Editar</th>
                                                <!--<th class="text-center">Excluir</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="m-0 font-weight-bold text-dark">
                                                <th class="text-left">Nome</th>
                                                <th>Descrição</th>
                                                <th>Data Inicial</th>
                                                <th>Data Final</th>
                                                <th class="text-center">Detalhe</th>
                                                <th class="text-center">Editar</th>
                                                <!--<th class="text-center">Excluir</th>-->
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            require_once("lib/Database/Connection.php");
                                            $query = "SELECT * FROM tbsistema";
                                            $result = mysqli_query($conn, $query);
                                            foreach ($result as $row) {
                                                ?>
                                                <tr>
                                                    <td><?= $row['nome']; ?></td>
                                                    <td><?= $row['descricao']; ?></td>
                                                    <td><?= $row['dataInicio']; ?></td>
                                                    <td><?= $row['dataFim']; ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalDetalheSistema"
                                                                data-sisnome="<?= $row['nome']; ?>"
                                                                data-sisdescricao="<?= $row['descricao']; ?>"
                                                                data-sisdatainicio="<?= $row['dataInicio']; ?>"
                                                                data-sisdatafim="<?= $row['dataFim']; ?>"
                                                                >
                                                            <i class="fas fa-fingerprint"></i>&nbsp;Detalhe
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#ModalEditarSistema"
                                                                data-sisidsistema="<?= $row['idsistema']; ?>"
                                                                data-sisnome="<?= $row['nome']; ?>"
                                                                data-sisdescricao="<?= $row['descricao']; ?>"
                                                                data-sisdatainicio="<?= $row['dataInicio']; ?>"
                                                                data-sisdatafim="<?= $row['dataFim']; ?>"
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
        <div class="modal fade" id="ModalCadastrarSistema" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cadastrar Sistema</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="action/cadastrarSistema.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5><i class="fa fa-list"></i> Informações do Sistema</h5>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome</label>
                                        <input type="text" class="form-control" name="sis_nome" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Descrição</label>
                                        <input type="text" class="form-control" name="sis_descricao" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Data Inicial</label>
                                        <input type="date" class="form-control" name="sis_dt_inicio" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Data Final</label>
                                        <input type="date" class="form-control" name="sis_dt_final" >
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <hr>
                                    <h5><i class="fa fa-list"></i> Informações do Módulo*</h5>
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
                                        <label for="recipient-name" class="col-form-label">Ambiente Organizacional</label>
                                        <input type="text" class="form-control" name="mod_ambiente" required>
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
        <div class="modal fade" id="ModalDetalheSistema" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <h5><i class="fa fa-list"></i> Informações do Sistema</h5>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome</label>
                                    <p><output type="text" id="detalhe_sis_nome"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label class="col-form-label font-weight-bold">Descrição</label>
                                    <p><output type="text" id="detalhe_sis_descricao"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <hr>
                                <h5><i class="fa fa-info"></i> Informações Adicionais</h5>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Data Inicial</label>
                                    <p><output type="date" id="detalhe_sis_dataInicio"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Data Final</label>
                                    <p><output type="date" id="detalhe_sis_dataFim"></output></p>
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
        <div class="modal fade" id="ModalEditarSistema" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Sistema</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="action/editarSistema.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5><i class="fa fa-list"></i> Informações do Sistema</h5>
                                </div>
                                <input type="hidden" class="form-control" id="editar_sis_idsistema" name="editar_sis_idsistema" required>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome*</label>
                                        <input type="text" class="form-control" id="editar_sis_nome" name="editar_sis_nome" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Descrição*</label>
                                        <input type="text" class="form-control" id="editar_sis_descricao" name="editar_sis_descricao" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Data Inicial*</label>
                                        <input type="date" class="form-control" id="editar_sis_dataInicio" name="editar_sis_dataInicio" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Data Final</label>
                                        <input type="date" class="form-control" id="editar_sis_dataFim" name="editar_sis_dataFim" >
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
            $('#ModalDetalheSistema').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var detalhe_sis_nome = button.data('sisnome'); // Extract info from data-* attributes
                var detalhe_sis_descricao = button.data('sisdescricao');
                var detalhe_sis_dataInicio = button.data('sisdatainicio');
                var detalhe_sis_dataFim = button.data('sisdatafim');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Detalhe do Sistema: ' + detalhe_sis_nome);
                modal.find('#detalhe_sis_nome').val(detalhe_sis_nome);
                modal.find('#detalhe_sis_descricao').val(detalhe_sis_descricao);
                modal.find('#detalhe_sis_dataInicio').val(detalhe_sis_dataInicio);
                modal.find('#detalhe_sis_dataFim').val(detalhe_sis_dataFim);
            });
        </script>
        <!-- Fim Modal Detalhe-->

        <!-- Modal Editar-->
        <script>
            $('#ModalEditarSistema').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var editar_sis_idsistema = button.data('sisidsistema'); // Extract info from data-* attributes
                var editar_sis_nome = button.data('sisnome'); // Extract info from data-* attributes
                var editar_sis_descricao = button.data('sisdescricao');
                var editar_sis_dataInicio = button.data('sisdatainicio');
                var editar_sis_dataFim = button.data('sisdatafim');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Editar Sistema: ' + editar_sis_nome);
                modal.find('#editar_sis_idsistema').val(editar_sis_idsistema);
                modal.find('#editar_sis_nome').val(editar_sis_nome);
                modal.find('#editar_sis_descricao').val(editar_sis_descricao);
                modal.find('#editar_sis_dataInicio').val(editar_sis_dataInicio);
                modal.find('#editar_sis_dataFim').val(editar_sis_dataFim);
            });
        </script>
        <!-- Fim Modal Editar-->

        <!-- Reseta Modal Cadastrar ao Fechar-->
        <script>
            $('#ModalCadastrarSistema').on('hidden.bs.modal', function () {
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

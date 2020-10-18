<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php
    require_once("lib/Database/ConnectionAbstract.php");
    $conn = Database\ConnectionAbstract::getConn();
    //var_dump($conn);

    $titulo = "Análise";
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
                        <h1 class="h3 mb-2 text-gray-800">Análise</h1>
                        <p class="mb-4">A atual página mostra a relação de análises cadastradas. Permite ao gerente de projetos adicionar novas análises ou realizar alterações.</p>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Análise</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto mr-auto mb-2">
                                        <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#ModalCadastrarAnalise">
                                            <i class="fas fa-list"></i>&nbsp;Cadastrar Análise
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
                                                <th>ID Análise</th>
                                                <th>Analista</th>
                                                <th>Módulo</th>
                                                <th>Risco</th>
                                                <th>Situação</th>
                                                <th>Data Início</th>
                                                <th class="text-center">Detalhe</th>
                                                <th class="text-center">Editar</th>
                                                <!--<th class="text-center">Excluir</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="m-0 font-weight-bold text-dark">
                                                <th>ID Análise</th>
                                                <th>Analista</th>
                                                <th>Módulo</th>
                                                <th>Risco</th>
                                                <th>Situação</th>
                                                <th>Data Início</th>
                                                
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
                                                        tbanalise.*,
                                                        tbanalista.nome AS analista_nome,
                                                        tbmodulo.nome AS modulo_nome,
                                                        tbrisco.nome AS risco_nome
                                                    FROM 
                                                        tbanalise
                                                    LEFT JOIN
                                                        tbanalista
                                                    ON
                                                        tbanalista.idanalista = tbanalise.idanalista
                                                    LEFT JOIN
                                                        tbmodulo
                                                    ON
                                                        tbmodulo.idmodulo = tbanalise.idmodulo
                                                    LEFT JOIN
                                                        tbrisco
                                                    ON
                                                        tbrisco.idrisco = tbanalise.idrisco";
                                            $result = mysqli_query($conn, $query);
                                            foreach ($result as $row) {
                                                ?>
                                                <tr>
                                                    <td><?= $row['idanalise']; ?></td>
                                                    <td><?= $row['analista_nome']; ?></td>
                                                    <td><?= $row['modulo_nome']; ?></td>
                                                    <td><?= $row['risco_nome']; ?></td>
                                                    <td><?= $row['situacao']; ?></td>
                                                    <td><?= $row['dataInicio']; ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalDetalheAnalise"
                                                                data-analiseanalistanome="<?= $row['analista_nome']; ?>"
                                                                data-analisemodulonome="<?= $row['modulo_nome']; ?>"
                                                                data-analiserisconome="<?= $row['risco_nome']; ?>"
                                                                data-analisesituacao="<?= $row['situacao']; ?>"
                                                                data-analisedatainicio="<?= $row['dataInicio']; ?>"
                                                                data-analisedatafim="<?= $row['dataFim']; ?>"
                                                                >
                                                            <i class="fas fa-fingerprint"></i>&nbsp;Detalhe
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#ModalEditarAnalise"
                                                                data-analiseidanalista="<?= $row['idanalista']; ?>"
                                                                data-analiseidmodulo="<?= $row['idmodulo']; ?>"
                                                                data-analiseidrisco="<?= $row['idrisco']; ?>"
                                                                
                                                                data-analiseanalistanome="<?= $row['analista_nome']; ?>"
                                                                data-analisemodulonome="<?= $row['modulo_nome']; ?>"
                                                                data-analiserisconome="<?= $row['risco_nome']; ?>"
                                                                
                                                                data-analisedatainicio="<?= $row['dataInicio']; ?>"
                                                                data-analisedatafim="<?= $row['dataFim']; ?>"
                                                                data-analisesituacao="<?= $row['situacao']; ?>"
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
        <div class="modal fade" id="ModalCadastrarAnalise" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cadastrar Análise</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="action/cadastrarAnalise.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5><i class="fa fa-list"></i> Informações da Análise*</h5>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Analista</label>
                                        <select class="form-control" name="analise_idanalista" required>
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_analista = "SELECT idanalista, nome FROM tbanalista";
                                            $result_analista = mysqli_query($conn, $query_analista);
                                            foreach ($result_analista as $row_analista) {
                                                ?>
                                                <option value="<?= $row_analista['idanalista']; ?>"><?= $row_analista['nome']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Módulo</label>
                                        <select class="form-control" name="analise_idmodulo" required>
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_modulo = "SELECT idmodulo, nome FROM tbmodulo";
                                            $result_modulo = mysqli_query($conn, $query_modulo);
                                            foreach ($result_modulo as $row_modulo) {
                                                ?>
                                                <option value="<?= $row_modulo['idmodulo']; ?>"><?= $row_modulo['nome']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Risco</label>
                                        <select class="form-control" name="analise_idrisco" required>
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_risco = "SELECT idrisco, nome FROM tbrisco";
                                            $result_risco = mysqli_query($conn, $query_risco);
                                            foreach ($result_risco as $row_risco) {
                                                ?>
                                                <option value="<?= $row_risco['idrisco']; ?>"><?= $row_risco['nome']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Situação</label>
                                        <input type="text" class="form-control" value="Bloqueado" disabled>
                                        <input type="hidden" class="form-control" name="analise_situacao" value="Bloqueado">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Data Início</label>
                                        <input type="date" class="form-control" name="analise_datainicio" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Data Fim</label>
                                        <input type="date" class="form-control" name="analise_datafim" >
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
        <div class="modal fade" id="ModalDetalheAnalise" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <h5><i class="fa fa-list"></i> Informações da Análise</h5>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome do Analista</label>
                                    <p><output type="text" id="detalhe_analiseanalistanome"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome do Módulo</label>
                                    <p><output type="text" id="detalhe_analisemodulonome"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome do Risco</label>
                                    <p><output type="text" id="detalhe_analiserisconome"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Situação</label>
                                    <p><output type="text" id="detalhe_analisesituacao"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Data Início</label>
                                    <p><output type="date" id="detalhe_analisedatainicio"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Data Fim</label>
                                    <p><output type="date" id="detalhe_analisedatafim"></output></p>
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
        <div class="modal fade" id="ModalEditarAnalise" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Análise</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="action/editarAnalise.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5><i class="fa fa-list"></i> Informações da Análise</h5>
                                </div>
                                <input type="hidden" class="form-control" id="editar_analiseidanalise" name="editar_analiseidanalise" required>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome*</label>
                                        <input type="text" class="form-control" id="editar_analisenome" name="editar_analisenome" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Probabilidade</label>
                                        <select class="form-control" name="analise_probabilidade" required>
                                            <option value="">Selecione</option>
                                            <option value="0.90">Muito Alta</option>
                                            <option value="0.70">Alta</option>
                                            <option value="0.50">Média</option>
                                            <option value="0.30">Baixa</option>
                                            <option value="0.10">Muito Baixa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Impacto</label>
                                        <select class="form-control" name="analise_impacto" required>
                                            <option value="">Selecione</option>
                                            <option value="0.80">Muito Alto</option>
                                            <option value="0.40">Alto</option>
                                            <option value="0.20">Médio</option>
                                            <option value="0.10">Baixo</option>
                                            <option value="0.05">Muito Baixo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">E-mail*</label>
                                        <input type="email" class="form-control" id="editar_analiseemail" name="editar_analiseemail" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">CPF*</label>
                                        <input type="text" class="form-control" id="editar_analisecpf" name="editar_analisecpf" maxlength="11" required>
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
            $('#ModalDetalheAnalise').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var detalhe_analiseanalistanome = button.data('analiseanalistanome'); // Extract info from data-* attributes
                var detalhe_analisemodulonome = button.data('analisemodulonome');
                var detalhe_analiserisconome = button.data('analiserisconome');
                var detalhe_analisesituacao = button.data('analisesituacao');
                var detalhe_analisedatainicio = button.data('analisedatainicio');
                var detalhe_analisedatafim = button.data('analisedatafim');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Detalhe da Análise: ' + detalhe_analiseanalistanome);
                modal.find('#detalhe_analiseanalistanome').val(detalhe_analiseanalistanome);
                modal.find('#detalhe_analisemodulonome').val(detalhe_analisemodulonome);
                modal.find('#detalhe_analiserisconome').val(detalhe_analiserisconome);
                modal.find('#detalhe_analisesituacao').val(detalhe_analisesituacao);
                modal.find('#detalhe_analisedatainicio').val(detalhe_analisedatainicio);
                modal.find('#detalhe_analisedatafim').val(detalhe_analisedatafim);
            });
        </script>
        <!-- Fim Modal Detalhe-->

        <!-- Modal Editar-->
        <script>
            $('#ModalEditarAnalise').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var editar_analiseidanalista = button.data('analiseidanalista'); // Extract info from data-* attributes
                var editar_analiseidmodulo = button.data('analiseidmodulo'); // Extract info from data-* attributes
                var editar_analiseidrisco = button.data('analiseidrisco'); // Extract info from data-* attributes
                
                var editar_analiseanalistanome = button.data('analiseanalistanome');
                var editar_analisemodulonome = button.data('analisemodulonome');
                var editar_analiserisconome = button.data('analiserisconome');
                
                var editar_analisesituacao = button.data('analisesituacao');
                var editar_analisedatainicio = button.data('analisedatainicio');
                var editar_analisedatafim = button.data('analisedatafim');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Editar Análise: ' + editar_analiseidanalista);
                modal.find('#editar_analiseidanalista').val(editar_analiseidanalista);
                modal.find('#editar_analiseidmodulo').val(editar_analiseidmodulo);
                modal.find('#editar_analiseidrisco').val(editar_analiseidrisco);
                
                modal.find('#editar_analiseanalistanome').val(editar_analiseanalistanome);
                modal.find('#editar_analisemodulonome').val(editar_analisemodulonome);
                modal.find('#editar_analiserisconome').val(editar_analiserisconome);
                
                modal.find('#editar_analisesituacao').val(editar_analisesituacao);
                modal.find('#editar_analisedatainicio').val(editar_analisedatainicio);
                modal.find('#editar_analisedatafim').val(editar_analisedatafim);
            });
        </script>
        <!-- Fim Modal Editar-->

        <!-- Reseta Modal Cadastrar ao Fechar-->
        <script>
            $('#ModalCadastrarAnalise').on('hidden.bs.modal', function () {
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

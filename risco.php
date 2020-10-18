<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php
    require_once("lib/Database/ConnectionAbstract.php");
    $conn = Database\ConnectionAbstract::getConn();
    //var_dump($conn);

    $titulo = "Risco";
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
                        <h1 class="h3 mb-2 text-gray-800">Risco</h1>
                        <p class="mb-4">A atual página mostra a relação de riscos cadastrados. Permite ao gerente de projetos adicionar novos riscos ou realizar alterações.</p>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Risco</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto mr-auto mb-2">
                                        <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#ModalCadastrarRisco">
                                            <i class="fas fa-list"></i>&nbsp;Cadastrar Risco
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
                                                <th>Nome da Categoria</th>
                                                <th class="text-center">Detalhe</th>
                                                <th class="text-center">Editar</th>
                                                <!--<th class="text-center">Excluir</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="m-0 font-weight-bold text-dark">
                                                <th class="text-left">Nome</th>
                                                <th>Descrição</th>
                                                <th>Nome da Categoria</th>
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
                                                        tbrisco.*,
                                                        tbcategoria.nome AS nome_categoria
                                                        
                                                    FROM 
                                                        tbrisco
                                                    INNER JOIN
                                                        tbcategoria
                                                    ON
                                                        tbrisco.idcategoria = tbcategoria.idcategoria";
                                            $result = mysqli_query($conn, $query);
                                            foreach ($result as $row) {
                                                ?>
                                                <tr>
                                                    <td><?= $row['nome']; ?></td>
                                                    <td><?= $row['descricao']; ?></td>
                                                    <td><?= $row['nome_categoria']; ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalDetalheRisco"
                                                                data-risnome="<?= $row['nome']; ?>"
                                                                data-risdescricao="<?= $row['descricao']; ?>"
                                                                data-risnomecategoria="<?= $row['nome_categoria']; ?>"
                                                                >
                                                            <i class="fas fa-fingerprint"></i>&nbsp;Detalhe
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#ModalEditarRisco"
                                                                data-risidrisco="<?= $row['idrisco']; ?>"
                                                                data-risnome="<?= $row['nome']; ?>"
                                                                data-risdescricao="<?= $row['descricao']; ?>"
                                                                data-risnomecategoria="<?= $row['nome_categoria']; ?>"
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
        <div class="modal fade" id="ModalCadastrarRisco" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cadastrar Risco</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="action/cadastrarRisco.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5><i class="fa fa-list"></i> Informações do Risco</h5>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome</label>
                                        <input type="text" class="form-control" name="risnome" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Descrição</label>
                                        <input type="text" class="form-control" name="risdescricao" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <hr>
                                    <h5><i class="fa fa-list"></i> Informações da Categoria*</h5>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Categoria (Nv. 1)</label>
                                        <select class="form-control" name="catidcategoria1" id="catidcategoria1" required>
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_categoria = "SELECT idcategoria, nome FROM tbcategoria WHERE nivel  = 1";
                                            $result_categoria = mysqli_query($conn, $query_categoria);
                                            foreach ($result_categoria as $row_categoria) {
                                                ?>
                                                <option value="<?= $row_categoria['idcategoria']; ?>"><?= $row_categoria['nome']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Categoria (Nv. 2)</label>
                                        <select class="form-control" name="catidcategoria2" id="catidcategoria2" required>
                                            <option value="">Selecione</option>
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
        <div class="modal fade" id="ModalDetalheRisco" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <h5><i class="fa fa-list"></i> Informações do Risco</h5>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome</label>
                                    <p><output type="text" id="detalhe_risnome"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label class="col-form-label font-weight-bold">Descrição</label>
                                    <p><output type="text" id="detalhe_risdescricao"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <hr>
                                <h5><i class="fa fa-info"></i> Informações Adicionais</h5>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome da Categoria</label>
                                    <p><output type="text" id="detalhe_risnomecategoria"></output></p>
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
        <div class="modal fade" id="ModalEditarRisco" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Risco</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="action/editarRisco.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5><i class="fa fa-list"></i> Informações do Risco</h5>
                                </div>
                                <input type="hidden" class="form-control" id="editar_risidrisco" name="editar_risidrisco" required>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome*</label>
                                        <input type="text" class="form-control" id="editar_risnome" name="editar_risnome" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Descrição*</label>
                                        <input type="text" class="form-control" id="editar_risdescricao" name="editar_risdescricao" required>
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
            $('#ModalDetalheRisco').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var detalhe_risnome = button.data('risnome'); // Extract info from data-* attributes
                var detalhe_risdescricao = button.data('risdescricao');
                var detalhe_risnomecategoria = button.data('risnomecategoria');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Detalhe do Risco: ' + detalhe_risnome);
                modal.find('#detalhe_risnome').val(detalhe_risnome);
                modal.find('#detalhe_risdescricao').val(detalhe_risdescricao);
                modal.find('#detalhe_risnomecategoria').val(detalhe_risnomecategoria);
            });
        </script>
        <!-- Fim Modal Detalhe-->

        <!-- Modal Editar-->
        <script>
            $('#ModalEditarRisco').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var editar_risidrisco = button.data('risidrisco'); // Extract info from data-* attributes
                var editar_risnome = button.data('risnome'); // Extract info from data-* attributes
                var editar_risdescricao = button.data('risdescricao');
                var editar_risnomecategoria = button.data('risnomecategoria');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Editar Risco: ' + editar_risnome);
                modal.find('#editar_risidrisco').val(editar_risidrisco);
                modal.find('#editar_risnome').val(editar_risnome);
                modal.find('#editar_risdescricao').val(editar_risdescricao);
                modal.find('#editar_risnomecategoria').val(editar_risnomecategoria);
            });
        </script>
        <!-- Fim Modal Editar-->

        <!-- Reseta Modal Cadastrar ao Fechar-->
        <script>
            $('#ModalCadastrarRisco').on('hidden.bs.modal', function () {
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

        <!-- JS Seleciona a Categoria -->
        <script type="text/javascript">
            $(function () {
                $('#catidcategoria1').change(function () {
                    if ($(this).val()) {
                        $.getJSON('action/selecionarCategoria.php?search=', {
                            idcategoria: $(this).val(), ajax: 'true'},
                                function (j) {
                                    var options = '<option value="">Selecione</option>';
                                    for (var i = 0; i < j.length; i++) {
                                        options += '<option value="' + j[i].idcategoria + '">' + j[i].nome + '</option>';
                                    }
                                    $('#catidcategoria2').html(options).show();
                                });
                    } else {
                        $('#catidcategoria2').html('<option value="">Selecione</option>');
                    }
                });
            });
        </script>
        <!-- Fim JS Seleciona a Categoria -->
    </body>

</html>

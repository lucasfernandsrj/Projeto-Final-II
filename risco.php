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
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                        <a href="sistema.php"><button type="button" class="btn btn-outline-dark btn-lg mx-2">Sistema</button></a>
                        <a href="modulo.php"><button type="button" class="btn btn-outline-dark btn-lg mx-2">Módulo</button></a>
                        <a href="risco.php"><button type="button" class="btn btn-outline-primary btn-lg mx-2">Risco</button></a>
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
                                                <th class="text-center" colspan="3">Informações</th>
                                                <th class="text-center" colspan="2">Ferramentas</th>
                                            </tr>
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
                                                        tbcategoria.nome AS nome_categoria,
                                                        tbcategoria.fk_idcategoria AS fk_idcategoria_categoria
                                                    FROM 
                                                        tbrisco
                                                    INNER JOIN
                                                        tbcategoria
                                                    ON
                                                        tbrisco.idcategoria = tbcategoria.idcategoria";
                                            $result = mysqli_query($conn, $query);
                                            foreach ($result as $row) {
                                                $fk_idcategoria = $row['fk_idcategoria_categoria'];
                                                $querycategoria = "SELECT nome FROM tbcategoria WHERE idcategoria = $fk_idcategoria LIMIT 1";
                                                $resultcategoria = mysqli_query($conn, $querycategoria);
                                                foreach ($resultcategoria as $rowcategoria){
                                                    $nome_categoria1 = $rowcategoria['nome'];
                                                }
                                                ?>
                                                <tr>
                                                    <td><?= $row['nome']; ?></td>
                                                    <td><?= $row['descricao']; ?></td>
                                                    <td><?= $row['nome_categoria']; ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalDetalheRisco"
                                                                data-risconome="<?= $row['nome']; ?>"
                                                                data-riscodescricao="<?= $row['descricao']; ?>"
                                                                
                                                                data-risconomecategoria1="<?= $nome_categoria1; ?>"
                                                                data-risconomecategoria2="<?= $row['nome_categoria']; ?>"
                                                                >
                                                            <i class="fas fa-fingerprint"></i>&nbsp;Detalhe
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#ModalEditarRisco"
                                                                data-riscoidrisco="<?= $row['idrisco']; ?>"
                                                                data-risconome="<?= $row['nome']; ?>"
                                                                data-riscodescricao="<?= $row['descricao']; ?>"
                                                                
                                                                data-risconomecategoria="<?= $row['nome_categoria']; ?>"
                                                                data-riscoidcategoria="<?= $row['idcategoria']; ?>"
                                                                data-riscofkidcategoria="<?= $row['fk_idcategoria_categoria']; ?>"
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
                                        <input type="text" class="form-control" name="risconome" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Descrição</label>
                                        <textarea class="form-control" name="riscodescricao" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <hr>
                                    <h5><i class="fa fa-list"></i> Informações da Categoria*</h5>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Categoria (Nv. 1)</label>
                                        <select class="form-control" name="categoriaidcategoria1" id="categoriaidcategoria1" required>
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
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Categoria (Nv. 2)</label>
                                        <select class="form-control" name="riscoidcategoria2" id="riscoidcategoria2" required>
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
                                    <p><output type="text" id="detalhe_risconome"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label class="col-form-label font-weight-bold">Descrição</label>
                                    <p><output type="text" id="detalhe_riscodescricao"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <hr>
                                <h5><i class="fa fa-info"></i> Informações Adicionais</h5>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome da Categoria (Nv.1)</label>
                                    <p><output type="text" id="detalhe_risconomecategoria1"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome da Categoria (Nv.2)</label>
                                    <p><output type="text" id="detalhe_risconomecategoria2"></output></p>
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
                                <input type="hidden" class="form-control" id="editar_riscoidrisco" name="editar_riscoidrisco" required>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome*</label>
                                        <input type="text" class="form-control" id="editar_risconome" name="editar_risconome" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Descrição*</label>
                                        <textarea class="form-control" id="editar_riscodescricao" name="editar_riscodescricao" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Categoria (Nv. 1)</label>
                                        <select class="form-control" id="editar_riscoidcategoria1" required>
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_categoria1 = "SELECT idcategoria, nome FROM tbcategoria WHERE nivel  = 1";
                                            $result_categoria1 = mysqli_query($conn, $query_categoria1);
                                            foreach ($result_categoria1 as $row_categoria1) {
                                                ?>
                                                <option value="<?= $row_categoria1['idcategoria']; ?>"><?= $row_categoria1['nome']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Categoria (Nv. 2)</label>
                                        <select class="form-control" name="editar_categoriaidcategoria2" id="editar_categoriaidcategoria2" required>
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_categoria2 = "SELECT idcategoria, nome FROM tbcategoria WHERE nivel  = 2";
                                            $result_categoria2 = mysqli_query($conn, $query_categoria2);
                                            foreach ($result_categoria2 as $row_categoria2) {
                                                ?>
                                                <option value="<?= $row_categoria2['idcategoria']; ?>"><?= $row_categoria2['nome']; ?></option>
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
                var detalhe_risconome = button.data('risconome'); // Extract info from data-* attributes
                var detalhe_riscodescricao = button.data('riscodescricao');
                
                var detalhe_risconomecategoria1 = button.data('risconomecategoria1');
                var detalhe_risconomecategoria2 = button.data('risconomecategoria2');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Detalhe do Risco: ' + detalhe_risconome);
                modal.find('#detalhe_risconome').val(detalhe_risconome);
                modal.find('#detalhe_riscodescricao').val(detalhe_riscodescricao);
                
                modal.find('#detalhe_risconomecategoria1').val(detalhe_risconomecategoria1);
                modal.find('#detalhe_risconomecategoria2').val(detalhe_risconomecategoria2);
            });
        </script>
        <!-- Fim Modal Detalhe-->

        <!-- Modal Editar-->
        <script>
            $('#ModalEditarRisco').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var editar_riscoidrisco = button.data('riscoidrisco'); // Extract info from data-* attributes
                var editar_risconome = button.data('risconome'); // Extract info from data-* attributes
                var editar_riscodescricao = button.data('riscodescricao');
                
                var editar_risconomecategoria = button.data('risconomecategoria');
                var editar_riscoidcategoria = button.data('riscoidcategoria');
                var editar_riscofkidcategoria = button.data('riscofkidcategoria');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Editar Risco: ' + editar_risconome);
                modal.find('#editar_riscoidrisco').val(editar_riscoidrisco);
                modal.find('#editar_risconome').val(editar_risconome);
                modal.find('#editar_riscodescricao').val(editar_riscodescricao);
                
                modal.find('#editar_risconomecategoria').val(editar_risconomecategoria);
                modal.find('#editar_riscoidcategoria1').val(editar_riscofkidcategoria);
                modal.find('#editar_categoriaidcategoria2').val(editar_riscoidcategoria);
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

        <!-- JS Seleciona a Categoria em Cadastrar Risco -->
        <script type="text/javascript">
            $(function () {
                $('#categoriaidcategoria1').change(function () {
                    if ($(this).val()) {
                        $.getJSON('action/selecionarCategoria.php?search=', {
                            idcategoria: $(this).val(),
                            ajax: 'true'},
                                function (j) {
                                    var options = '<option value="">Selecione</option>';
                                    for (var i = 0; i < j.length; i++) {
                                        options += '<option value="' + j[i].idcategoria + '">' + j[i].nome + '</option>';
                                    }
                                    $('#riscoidcategoria2').html(options).show();
                                });
                    } else {
                        $('#riscoidcategoria2').html('<option value="">Selecione</option>');
                    }
                });
            });
        </script>
        <!-- Fim JS Seleciona a Categoria em Cadastrar Risco -->
        
        <!-- JS Seleciona a Categoria em Editar Risco -->
        <script type="text/javascript">
            $(function () {
                $('#editar_riscoidcategoria1').change(function () {
                    if ($(this).val()) {
                        $.getJSON('action/selecionarCategoria.php?search=', {
                            idcategoria: $(this).val(),
                            ajax: 'true'},
                                function (j) {
                                    var options = '<option value="">Selecione</option>';
                                    for (var i = 0; i < j.length; i++) {
                                        options += '<option value="' + j[i].idcategoria + '">' + j[i].nome + '</option>';
                                    }
                                    $('#editar_categoriaidcategoria2').html(options).show();
                                });
                    } else {
                        $('#editar_categoriaidcategoria2').html('<option value="">Selecione</option>');
                    }
                });
            });
        </script>
        <!-- Fim JS Seleciona a Categoria em Cadastrar Risco -->
    </body>

</html>

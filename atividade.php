<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php
    require_once("lib/Database/ConnectionAbstract.php");
    $conn = Database\ConnectionAbstract::getConn();
    //var_dump($conn);

    $titulo = "Atividade";
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
                        <a href="analise2.php"><button type="button" class="btn btn-outline-dark btn-lg mx-2">Análise do Analista</button></a>
                        <a href="resposta.php"><button type="button" class="btn btn-outline-dark btn-lg mx-2">Resposta ao Risco</button></a>
                        <a href="atividade.php"><button type="button" class="btn btn-outline-primary btn-lg mx-2">Atividade</button></a>
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
                        <h1 class="h3 mb-2 text-gray-800">Atividade</h1>
                        <p class="mb-4">A atual página mostra a relação de atividades cadastradas. Permite ao gerente de projetos adicionar novas atividades ou realizar alterações.</p>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Atividade</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto mr-auto mb-2">
                                        <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#ModalCadastrarAtividade">
                                            <i class="fas fa-list"></i>&nbsp;Cadastrar Atividade
                                        </button>
                                    </div>
                                </div>
                                <!-- Tabela -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-dark" id="DataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center" colspan="4">Informações</th>
                                                <th class="text-center" colspan="2">Ferramentas</th>
                                            </tr>
                                            <tr>
                                                <th>Objetivo</th>
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
                                                <th>Objetivo</th>
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
                                            $query = "SELECT * FROM tbatividade";
                                            $result = mysqli_query($conn, $query);
                                            foreach ($result as $row) {
                                                ?>
                                                <tr>
                                                    <td><?= $row['objetivo']; ?></td>
                                                    <td><?= $row['descricao']; ?></td>
                                                    <td><?= $row['dataInicio']; ?></td>
                                                    <td><?= $row['dataFim']; ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalDetalheAtividade"
                                                                data-atividadedescricao="<?= $row['descricao']; ?>"
                                                                data-atividadeobjetivo="<?= $row['objetivo']; ?>"
                                                                data-atividadedatainicio="<?= $row['dataInicio']; ?>"
                                                                data-atividadedatafim="<?= $row['dataFim']; ?>"
                                                                >
                                                            <i class="fas fa-fingerprint"></i>&nbsp;Detalhe
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#ModalEditarAtividade"
                                                                data-atividadeidatividade="<?= $row['idatividade']; ?>"
                                                                
                                                                data-atividadedescricao="<?= $row['descricao']; ?>"
                                                                data-atividadeobjetivo="<?= $row['objetivo']; ?>"
                                                                data-atividadedatainicio="<?= $row['dataInicio']; ?>"
                                                                data-atividadedatafim="<?= $row['dataFim']; ?>"
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
        <div class="modal fade" id="ModalCadastrarAtividade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cadastrar Atividade</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="action/cadastrarAtividade.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5><i class="fa fa-list"></i> Informações da Atividade</h5>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Objetivo</label>
                                        <input type="text" class="form-control" name="atividade_objetivo" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Descrição</label>
                                        <textarea class="form-control" rows="1" name="atividade_descricao" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Data Inicial</label>
                                        <input type="date" class="form-control" name="atividade_dt_inicio" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Data Final</label>
                                        <input type="date" class="form-control" name="atividade_dt_final" required>
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
        <div class="modal fade" id="ModalDetalheAtividade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalhe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="printThis">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="text-primary"><i class="fa fa-clipboard"></i> Informações do Atividade</h5>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Objetivo</label>
                                    <p><output type="text" id="detalhe_atividadeobjetivo"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Descrição</label>
                                    <p><output type="text" id="detalhe_atividadedescricao"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Data Inicial</label>
                                    <p><output type="date" id="detalhe_atividadedatainicio"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Data Final</label>
                                    <p><output type="date" id="detalhe_atividadedatafim"></output></p>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                            <button id="btnPrint" type="button" class="btn btn-info"><i class="fas fa-print"></i> Gerar Print</button>
                        </div>
                </div>
            </div>
        </div>
        <!-- Fim Modal Detalhe -->

        <!-- Modal Editar -->
        <div class="modal fade" id="ModalEditarAtividade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Atividade</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="action/editarAtividade.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5><i class="fa fa-list"></i> Informações do Atividade</h5>
                                </div>
                                <input type="hidden" class="form-control" id="editar_atividadeidatividade" name="editar_atividadeidatividade" required>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Objetivo*</label>
                                        <input type="text" class="form-control" id="editar_atividadeobjetivo" name="editar_atividadeobjetivo" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Descrição*</label>
                                        <textarea class="form-control" rows="1" id="editar_atividadedescricao" name="editar_atividadedescricao" required></textarea>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Data Inicial*</label>
                                        <input type="date" class="form-control" id="editar_atividadedatainicio" name="editar_atividadedatainicio" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Data Final</label>
                                        <input type="date" class="form-control" id="editar_atividadedatafim" name="editar_atividadedatafim" required>
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
            $('#ModalDetalheAtividade').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var detalhe_atividadedescricao = button.data('atividadedescricao'); // Extract info from data-* attributes
                var detalhe_atividadeobjetivo = button.data('atividadeobjetivo');
                var detalhe_atividadedatainicio = button.data('atividadedatainicio');
                var detalhe_atividadedatafim = button.data('atividadedatafim');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Detalhe da Atividade: ' + detalhe_atividadeobjetivo);
                modal.find('#detalhe_atividadedescricao').val(detalhe_atividadedescricao);
                modal.find('#detalhe_atividadeobjetivo').val(detalhe_atividadeobjetivo);
                modal.find('#detalhe_atividadedatainicio').val(detalhe_atividadedatainicio);
                modal.find('#detalhe_atividadedatafim').val(detalhe_atividadedatafim);
            });
        </script>
        <!-- Fim Modal Detalhe-->

        <!-- Modal Editar-->
        <script>
            $('#ModalEditarAtividade').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var editar_atividadeidatividade = button.data('atividadeidatividade'); // Extract info from data-* attributes
                
                var editar_atividadeobjetivo = button.data('atividadeobjetivo'); // Extract info from data-* attributes
                var editar_atividadedescricao = button.data('atividadedescricao');
                var editar_atividadedatainicio = button.data('atividadedatainicio');
                var editar_atividadedatafim = button.data('atividadedatafim');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Editar Atividade: ' + editar_atividadeobjetivo);
                modal.find('#editar_atividadeidatividade').val(editar_atividadeidatividade);
                
                modal.find('#editar_atividadedescricao').val(editar_atividadedescricao);
                modal.find('#editar_atividadeobjetivo').val(editar_atividadeobjetivo);
                modal.find('#editar_atividadedatainicio').val(editar_atividadedatainicio);
                modal.find('#editar_atividadedatafim').val(editar_atividadedatafim);
            });
        </script>
        <!-- Fim Modal Editar-->

        <!-- Reseta Modal Cadastrar ao Fechar-->
        <script>
            $('#ModalCadastrarAtividade').on('hidden.bs.modal', function () {
                $(this).find("input,textarea,select").val('').end();

            });
        </script>
        <script>
            $(document).ready(function () {
                $('#DataTable').DataTable({
                    buttons: [
                        {
                            extend: 'copy',
                            text: '<i class="fas fa-copy"></i> Copiar Tabela'
                        }, {
                            extend: 'excel',
                            text: '<i class="fas fa-file-excel"></i> Gerar Relatório: Excel'
                        }, {
                            extend: 'pdf',
                            text: '<i class="fas fa-file-pdf"></i> Gerar Relatório: PDF'
                        }
                    ],initComplete: function () {
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
                }).buttons().container().appendTo('.col-md-6:eq(0)');
            });
        </script>
        <!-- Fim Reseta Modal Cadastrar ao Fechar-->
        <!-- JS Print Modal Detalhe-->
        <script>
            document.getElementById("btnPrint").onclick = function () {
                printElement(document.getElementById("printThis"));
            };

            function printElement(elem) {
                var domClone = elem.cloneNode(true);

                var $printSection = document.getElementById("printSection");

                if (!$printSection) {
                    var $printSection = document.createElement("div");
                    $printSection.id = "printSection";
                    document.body.appendChild($printSection);
                }

                $printSection.innerHTML = "";
                $printSection.appendChild(domClone);
                window.print();
            }
            ;
        </script>
        <!-- End JS Print Modal Detalhe-->
    </body>

</html>

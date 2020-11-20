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
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                        <a href="sistema.php"><button type="button" class="btn btn-outline-primary btn-lg mx-2">Sistema</button></a>
                        <a href="modulo.php"><button type="button" class="btn btn-outline-dark btn-lg mx-2">Módulo</button></a>
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
                                </div>
                                <!-- Tabela -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-dark" id="DataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center" colspan="5">Informações</th>
                                                <th class="text-center" colspan="2">Ferramentas</th>
                                            </tr>
                                            <tr>
                                                <th>Nome do Sistema</th>
                                                <th>Descrição</th>
                                                <th>Data Inicial</th>
                                                <th>Data Final</th>
                                                <th>Qtd. de Módulos</th>
                                                <th class="text-center">Detalhe</th>
                                                <th class="text-center">Editar</th>
                                                <!--<th class="text-center">Excluir</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="m-0 font-weight-bold text-dark">
                                                <th>Nome do Sistema</th>
                                                <th>Descrição</th>
                                                <th>Data Inicial</th>
                                                <th>Data Final</th>
                                                <th>Qtd. de Módulos</th>
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
                                                $idsistema = $row['idsistema'];
                                                $query_modulo="SELECT count(*) as quantidade FROM projetofinal2.tbmodulo WHERE idsistema = $idsistema;";
                                                $result_modulo = mysqli_query($conn, $query_modulo);
                                                $row_modulo = mysqli_fetch_row($result_modulo);
                                                ?>
                                                <tr>
                                                    <td><?= $row['nome']; ?></td>
                                                    <td><?= $row['descricao']; ?></td>
                                                    <td><?= $row['dataInicio']; ?></td>
                                                    <td><?= $row['dataFim']; ?></td>
                                                    <td><?= $row_modulo[0]; ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalDetalheSistema"
                                                                data-sistemanome="<?= $row['nome']; ?>"
                                                                data-sistemadescricao="<?= $row['descricao']; ?>"
                                                                data-sistemadatainicio="<?= $row['dataInicio']; ?>"
                                                                data-sistemadatafim="<?= $row['dataFim']; ?>"
                                                                >
                                                            <i class="fas fa-fingerprint"></i>&nbsp;Detalhe
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#ModalEditarSistema"
                                                                data-sistemaidsistema="<?= $row['idsistema']; ?>"
                                                                data-sistemanome="<?= $row['nome']; ?>"
                                                                data-sistemadescricao="<?= $row['descricao']; ?>"
                                                                data-sistemadatainicio="<?= $row['dataInicio']; ?>"
                                                                data-sistemadatafim="<?= $row['dataFim']; ?>"
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
                                        <input type="text" class="form-control" name="sistema_nome" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Descrição</label>
                                        <textarea class="form-control" name="sistema_descricao" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Data Inicial</label>
                                        <input type="date" class="form-control" name="sistema_dt_inicio" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Data Final</label>
                                        <input type="date" class="form-control" name="sistema_dt_final" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <hr>
                                    <h5><i class="fa fa-list"></i> Informações do Módulo</h5>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome</label>
                                        <input type="text" class="form-control" name="modulo_nome" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Descrição</label>
                                        <textarea class="form-control" name="modulo_descricao" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Ambiente Organizacional</label>
                                        <select class="form-control" name="modulo_ambiente" required>
                                            <option value="">Selecione</option>
                                            <option value="Interno">Interno</option>
                                            <option value="Externo">Externo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <small class="help-block">*Todos os campos são obrigatórios.</small>
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
                    <div class="modal-body" id="printThis">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="text-primary"><i class="fa fa-clipboard"></i> Informações do Sistema</h5>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome</label>
                                    <p><output type="text" id="detalhe_sistema_nome"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Descrição</label>
                                    <p><output type="text" id="detalhe_sistema_descricao"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Data Inicial</label>
                                    <p><output type="date" id="detalhe_sistema_dataInicio"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Data Final</label>
                                    <p><output type="date" id="detalhe_sistema_dataFim"></output></p>
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
                                <input type="hidden" class="form-control" id="editar_sistemaidsistema" name="editar_sistemaidsistema" required>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome</label>
                                        <input type="text" class="form-control" id="editar_sistemanome" name="editar_sistemanome" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Descrição</label>
                                        <textarea class="form-control" id="editar_sistemadescricao" name="editar_sistemadescricao" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Data Inicial</label>
                                        <input type="date" class="form-control" id="editar_sistemadatainicio" name="editar_sistemadatainicio" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Data Final</label>
                                        <input type="date" class="form-control" id="editar_sistemadatafim" name="editar_sistemadatafim" >
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <small class="help-block">*Todos os campos obrigatórios.</small>
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
                var detalhe_sistema_nome = button.data('sistemanome'); // Extract info from data-* attributes
                var detalhe_sistema_descricao = button.data('sistemadescricao');
                var detalhe_sistema_dataInicio = button.data('sistemadatainicio');
                var detalhe_sistema_dataFim = button.data('sistemadatafim');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Detalhe do Sistema: ' + detalhe_sistema_nome);
                modal.find('#detalhe_sistema_nome').val(detalhe_sistema_nome);
                modal.find('#detalhe_sistema_descricao').val(detalhe_sistema_descricao);
                modal.find('#detalhe_sistema_dataInicio').val(detalhe_sistema_dataInicio);
                modal.find('#detalhe_sistema_dataFim').val(detalhe_sistema_dataFim);
            });
        </script>
        <!-- Fim Modal Detalhe-->

        <!-- Modal Editar-->
        <script>
            $('#ModalEditarSistema').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var editar_sistemaidsistema = button.data('sistemaidsistema'); // Extract info from data-* attributes
                var editar_sistemanome = button.data('sistemanome'); // Extract info from data-* attributes
                var editar_sistemadescricao = button.data('sistemadescricao');
                var editar_sistemadatainicio = button.data('sistemadatainicio');
                var editar_sistemadatafim = button.data('sistemadatafim');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Editar Sistema: ' + editar_sistemanome);
                modal.find('#editar_sistemaidsistema').val(editar_sistemaidsistema);
                modal.find('#editar_sistemanome').val(editar_sistemanome);
                modal.find('#editar_sistemadescricao').val(editar_sistemadescricao);
                modal.find('#editar_sistemadatainicio').val(editar_sistemadatainicio);
                modal.find('#editar_sistemadatafim').val(editar_sistemadatafim);
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
                }).buttons().container().appendTo('.col-md-6:eq(0)');;
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

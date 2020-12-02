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
                                </div>
                                <!-- Tabela -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-dark" id="DataTableModulo" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center" colspan="5">Informações</th>
                                                <th class="text-center" colspan="2">Ferramentas</th>
                                            </tr>
                                            <tr>
                                                <th>Sistema</th>
                                                <th>Nível</th>
                                                <th>Nome do Módulo</th>
                                                <th>Ambiente</th>
                                                <th>Módulo Superior</th>
                                                <th class="text-center">Detalhe</th>
                                                <th class="text-center">Editar</th>
                                                <!--<th class="text-center">Excluir</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="m-0 font-weight-bold text-dark">
                                                <th>Sistema</th>
                                                <th>Nível</th>
                                                <th>Nome do Módulo</th>
                                                <th>Ambiente</th>
                                                <th>Módulo Superior</th>
                                                <th class="text-center">Detalhe</th>
                                                <th class="text-center">Editar</th>
                                                <!--<th class="text-center">Excluir</th>-->
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            require_once("lib/Database/Connection.php");
                                            $query = "SELECT 
    tbmodulo.*,
    tbsistema.nome sistema_nome,
    tbsistema.descricao sistema_descricao,
    tbsistema.dataInicio sistema_datainicio,
    tbsistema.dataFim sistema_datafinal
FROM
    tbmodulo
        LEFT JOIN
    tbsistema ON tbmodulo.idsistema = tbsistema.idsistema;";
                                            $result = mysqli_query($conn, $query);
                                            foreach ($result as $row) {
                                                ?>
                                                <tr>
                                                    <td><?= $row['sistema_nome']; ?></td>
                                                    <td><?= $row['nivel']; ?></td>
                                                    <td><?= $row['nome']; ?></td>
                                                    <td><?= $row['ambiente']; ?></td>
                                                    <?php
                                                    if ($row['fk_idmodulo'] != "") {
                                                        $fk_idmodulo = $row['fk_idmodulo'];
                                                        $query_fk_idmodulo = "SELECT nome FROM tbmodulo WHERE idmodulo = $fk_idmodulo";
                                                        $result_fk_idmodulo = mysqli_query($conn, $query_fk_idmodulo);
                                                        foreach ($result_fk_idmodulo as $row_fk_idmodulo) {
                                                            ?>
                                                            <td><?= $row_fk_idmodulo['nome']; ?></td><?php
                                                        }
                                                    } else {
                                                        ?><td></td><?php
                                                    }
                                                    ?>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalDetalheModulo"
                                                                data-modulonome="<?= $row['nome']; ?>"
                                                                data-modulodescricao="<?= $row['descricao']; ?>"
                                                                data-moduloambiente="<?= $row['ambiente']; ?>"
                                                                data-modulofkidmodulo="<?= $row['fk_idmodulo']; ?>"
                                                                data-modulonivel="<?= $row['nivel']; ?>"
                                                                data-sistemanome="<?= $row['sistema_nome']; ?>"
                                                                data-sistemadescricao="<?= $row['sistema_descricao']; ?>"
                                                                data-sistemadatainicio="<?= $row['sistema_datainicio']; ?>"
                                                                data-sistemadatafinal="<?= $row['sistema_datafinal']; ?>"
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
                                    <h5><i class="fa fa-list"></i> Informações do Sistema*</h5>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome do Sistema</label>
                                        <select class="form-control" name="moduloidsistema" required>
                                            <option value="">Selecione o sistema</option>
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
                                    <hr>
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
                                            <option value="Interno">Interno</option>
                                            <option value="Externo">Externo</option>
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
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome do Módulo</label>
                                        <input type="text" class="form-control" name="modulonome" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nível</label>
                                        <input type="text" class="form-control" id="vincularmodulonivel" value="2" disabled>
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
                                    <h5><i class="fa fa-list"></i> Informações do Módulo Superior*²</h5>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Nível</label>
                                        <select class="form-control" name="modulosuperiornivel" id="modulosuperiornivel" required>
                                            <option value="">Selecione</option>
                                            <option value="1">Nível 1</option>
                                            <option value="2">Nível 2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome do Módulo Superior</label>
                                        <select class="form-control" id="modulofk_idmodulo" name="modulofk_idmodulo" required>
                                            <option value="">Selecione</option>
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
                    <div class="modal-body" id="printThis">
                        <div class="row">
                            <div class="col-lg-12" id="info_sistema">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="text-dark"><i class="fa fa-archive"></i> Informações do Sistema</h5><!-- Título -->
                                    </div>
                                    <div class="col-lg-6">
                                        <div>
                                            <label class="col-form-label font-weight-bold">Nome do Sistema</label>
                                            <p><output type="text" id="detalhe_sistemanome"></output></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div>
                                            <label class="col-form-label font-weight-bold">Descrição do Sistema</label>
                                            <p><output type="text" id="detalhe_sistemadescricao"></output></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div>
                                            <label class="col-form-label font-weight-bold">Data de Início</label>
                                            <p><output type="date" id="detalhe_sistemadatainicio"></output></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div>
                                            <label class="col-form-label font-weight-bold">Data Final</label>
                                            <p><output type="date" id="detalhe_sistemadatafinal"></output></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="modulo_superior2" class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="text-dark"><i class="fa fa-archive"></i> Informações do Módulo Superior</h5>
                                    </div>

                                    <div class="col-lg-6">
                                        <div>
                                            <label class="col-form-label font-weight-bold">Nome</label>
                                            <p><output type="text" id="detalhe_superior2modulonome"></output></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6" id="mostra_modambiente">
                                        <div>
                                            <label class="col-form-label font-weight-bold">Ambiente Organizacional</label>
                                            <p><output type="text" id="detalhe_superior2moduloambiente"></output></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div>
                                            <label class="col-form-label font-weight-bold">Descrição</label>
                                            <p><output type="text" id="detalhe_superior2modulodescricao"></output></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div>
                                            <label class="col-form-label font-weight-bold">Nível</label>
                                            <p><output type="text" id="detalhe_superior2modulonivel"></output></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="modulo_superior" class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="text-dark"><i class="fa fa-archive"></i> Informações do Módulo Superior</h5>
                                    </div>

                                    <div class="col-lg-6">
                                        <div>
                                            <label class="col-form-label font-weight-bold">Nome</label>
                                            <p><output type="text" id="detalhe_superiormodulonome"></output></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6" id="mostra_modambiente">
                                        <div>
                                            <label class="col-form-label font-weight-bold">Ambiente Organizacional</label>
                                            <p><output type="text" id="detalhe_superiormoduloambiente"></output></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div>
                                            <label class="col-form-label font-weight-bold">Descrição</label>
                                            <p><output type="text" id="detalhe_superiormodulodescricao"></output></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div>
                                            <label class="col-form-label font-weight-bold">Nível</label>
                                            <p><output type="text" id="detalhe_superiormodulonivel"></output></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                            <option value="Interno">Interno</option>
                                            <option value="Externo">Externo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Nível</label>
                                        <input type="text" class="form-control" id="editar_modulonivel" disabled>
                                        <input type="hidden" class="form-control" id="editar_modulonivel2" name="editar_modulonivel2">
                                    </div>
                                </div>
                                <div class="col-lg-12" id="mostra_modulo">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome do Módulo Superior*²</label>
                                        <select class="form-control" id="editar_modulofkidmodulo" name="editar_modulofkidmodulo">
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

                var detalhe_sistemanome = button.data('sistemanome');
                var detalhe_sistemadescricao = button.data('sistemadescricao');
                var detalhe_sistemadatainicio = button.data('sistemadatainicio');
                var detalhe_sistemadatafinal = button.data('sistemadatafinal');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Detalhe do Módulo: ' + detalhe_modulonome);
                modal.find('#detalhe_modulonome').val(detalhe_modulonome);
                modal.find('#detalhe_modulodescricao').val(detalhe_modulodescricao);
                modal.find('#detalhe_moduloambiente').val(detalhe_moduloambiente);
                modal.find('#detalhe_modulofk_idmodulo').val(detalhe_modulofk_idmodulo);
                modal.find('#detalhe_modulonivel').val(detalhe_modulonivel);
                if (detalhe_modulonivel === 1) {
                    $('#info_sistema').show();
                    $('#modulo_superior').hide();
                    $('#modulo_superior2').hide();
                    modal.find('#detalhe_sistemanome').val(detalhe_sistemanome);
                    modal.find('#detalhe_sistemadescricao').val(detalhe_sistemadescricao);
                    modal.find('#detalhe_sistemadatainicio').val(detalhe_sistemadatainicio);
                    modal.find('#detalhe_sistemadatafinal').val(detalhe_sistemadatafinal);
                } else {
                    $('#info_sistema').hide();
                    $('#modulo_superior').show();
                    $('#modulo_superior2').hide();
                    $.getJSON('action/selecionarModuloPorId.php?search=', {
                        idmodulo: detalhe_modulofk_idmodulo,
                        ajax: 'true'
                    }, function (j) {
                        //console.log(j[1] !== undefined);
                        if (j.length > 0) {
                            modal.find('#detalhe_superiormodulonome').val(j[0].nome);
                            modal.find('#detalhe_superiormodulodescricao').val(j[0].descricao);
                            modal.find('#detalhe_superiormoduloambiente').val(j[0].ambiente);
                            modal.find('#detalhe_superiormodulonivel').val(j[0].nivel);
                            if (j[1] !== undefined) {
                                //console.log(j[1]);
                                $('#modulo_superior2').show();
                                modal.find('#detalhe_superior2modulonome').val(j[1].nome);
                                modal.find('#detalhe_superior2modulodescricao').val(j[1].descricao);
                                modal.find('#detalhe_superior2moduloambiente').val(j[1].ambiente);
                                modal.find('#detalhe_superior2modulonivel').val(j[1].nivel);
                            }
                        } else {
                            $('#modulo_superior').hide();
                            $('#modulo_superior2').hide();
                        }
                    });
                }
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
                //modal.find('#editar_modulofkidmodulo').val(editar_modulofkidmodulo);
                modal.find('#editar_modulonivel').val(editar_modulonivel);
                if (editar_modulonivel) {
                    $.getJSON('action/selecionarModuloPorNivel.php?search=', {
                        nivel: (parseInt(editar_modulonivel) - 1),
                        ajax: 'true'
                    }, function (j) {
                        var options = '<option value="">Selecione</option>';
                        if (j.length > 0) {
                            for (var i = 0; i < j.length; i++) {
                                options += '<option value="' + j[i].idmodulo + '">Sistema: ' + j[i].sistemanome + ' - Módulo: ' + j[i].modulonome + '</option>';
                            }
                            $('#editar_modulofkidmodulo').html(options).show();
                            $('#editar_modulofkidmodulo').val(editar_modulofkidmodulo);
                        } else {
                            $('#editar_modulofkidmodulo').html('<option value="">*Não há opções disponíveis</option>');
                        }
                    });
                }
                modal.find('#editar_modulonivel2').val(editar_modulonivel);

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
                    "pagingType": "full_numbers", buttons: [
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
                    ],
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
                }).buttons().container().appendTo('.col-md-6:eq(0)');
            });
        </script>
        <!-- Fim Datatable -->
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
        <!-- JS Selecionar Modulo por Nivel -->
        <script type="text/javascript">
            $(function () {
                $('#modulosuperiornivel').change(function () {
                    //console.log($('#modulosuperiornivel').val());
                    if ($('#modulosuperiornivel').val() === '1') {
                        $('#vincularmodulonivel').val(2);

                    } else if ($('#modulosuperiornivel').val() === '2') {
                        $('#vincularmodulonivel').val(3);

                    } else {
                        $('#vincularmodulonivel').val('2');
                    }
                    if ($(this).val()) {
                        $.getJSON('action/selecionarModuloPorNivel.php?search=', {
                            nivel: $(this).val(),
                            ajax: 'true'
                        }, function (j) {
                            var options = '<option value="">Selecione</option>';
                            if (j.length > 0) {
                                for (var i = 0; i < j.length; i++) {
                                    options += '<option value="' + j[i].idmodulo + '">Sistema: ' + j[i].sistemanome + ' - Módulo: ' + j[i].modulonome + '</option>';
                                }
                                $('#modulofk_idmodulo').html(options).show();
                            } else {
                                $('#modulofk_idmodulo').html('<option value="">*Não há opções disponíveis</option>');
                            }
                        });
                    } else {
                        $('#modulofk_idmodulo').html('<option value="">Selecione</option>');
                    }
                });
            });
        </script>
        <!-- Fim JS Selecionar Modulo por Nivel -->
    </body>

</html>

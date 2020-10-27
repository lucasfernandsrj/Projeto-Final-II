<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php
    require_once("lib/Database/ConnectionAbstract.php");
    $conn = Database\ConnectionAbstract::getConn();
    //var_dump($conn);

    $titulo = "Resposta ao Risco";
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
                        <a href="atividade.php"><button type="button" class="btn btn-outline-dark btn-lg mx-2">Atividade Mitigadora</button></a>
                        <a href="resposta.php"><button type="button" class="btn btn-outline-primary btn-lg mx-2">Resposta ao Risco</button></a>
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
                        <h1 class="h3 mb-2 text-gray-800">Resposta ao Risco</h1>
                        <p >A atual página mostra a relação de respostas cadastrados. Permite ao gerente de projetos adicionar novas respostas ou realizar alterações.
                        Além disso, a opção de adicionar novas atividades mitigadoras.
                        </p>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Resposta ao Risco</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto mb-2">
                                        <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#ModalCadastrarResposta">
                                            <i class="fas fa-list"></i>&nbsp;Cadastrar Resposta ao Risco
                                        </button>
                                    </div>
                                    <div class="col-auto mr-auto mb-2">
                                        <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#ModalCadastrarAtividade">
                                            <i class="fas fa-list"></i>&nbsp;Cadastrar Atividade Mitigadora
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
                                                <th class="text-center" colspan="4">Informações</th>
                                                <th class="text-center" colspan="2">Ferramentas</th>
                                            </tr>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Descrição</th>
                                                <th>Situação</th>
                                                <th>Medida do Risco</th>
                                                <th class="text-center">Detalhe</th>
                                                <th class="text-center">Editar</th>
                                                <!--<th class="text-center">Excluir</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="m-0 font-weight-bold text-dark">
                                                <th>Nome</th>
                                                <th>Descrição</th>
                                                <th>Situação</th>
                                                <th>Medida do Risco</th>
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
                                                        tbresposta.*,
                                                        tbanalise.medidadorisco,
                                                        tbanalise.probabilidade,
                                                        tbanalise.impacto,
                                                        tbanalise.datainicio,
                                                        tbanalise.datafim,
                                                        tbanalise.situacao AS  analise_situacao
                                                    FROM 
                                                        tbresposta
                                                    LEFT JOIN
                                                        tbanalise
                                                    ON
                                                        tbresposta.idanalise = tbanalise.idanalise";
                                            $result = mysqli_query($conn, $query);
                                            foreach ($result as $row) {
                                                ?>
                                                <tr>
                                                    <td><?= $row['nome']; ?></td>
                                                    <td><?= $row['descricao']; ?></td>
                                                    <td><?= $row['situacao']; ?></td>
                                                    <td><?= $row['medidadorisco']; ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalDetalheResposta"
                                                                data-respostanome="<?= $row['nome']; ?>"
                                                                data-respostadescricao="<?= $row['descricao']; ?>"
                                                                data-respostasituacao="<?= $row['situacao']; ?>"
                                                                data-respostamedidadorisco="<?= $row['medidadorisco']; ?>"
                                                                data-respostaprobabilidade="<?= $row['probabilidade']; ?>"
                                                                data-respostaimpacto="<?= $row['impacto']; ?>"
                                                                data-respostadatainicio="<?= $row['datainicio']; ?>"
                                                                data-respostadatafim="<?= $row['datafim']; ?>"
                                                                data-respostaanalisesituacao="<?= $row['analise_situacao']; ?>"
                                                                data-respostaidatividade="<?= $row['idatividade']; ?>"
                                                                >
                                                            <i class="fas fa-fingerprint"></i>&nbsp;Detalhe
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#ModalEditarResposta"
                                                                data-respostaidresposta="<?= $row['idresposta']; ?>"
                                                                data-respostanome="<?= $row['nome']; ?>"
                                                                data-respostadescricao="<?= $row['descricao']; ?>"
                                                                data-respostasituacao="<?= $row['situacao']; ?>"
                                                                data-respostaidatividade="<?= $row['idatividade']; ?>"
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
        <div class="modal fade" id="ModalCadastrarResposta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cadastrar Resposta ao Risco</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="action/cadastrarResposta.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5><i class="fa fa-list"></i> Informações da Resposta ao Risco</h5>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Análise*</label>
                                        <select class="form-control" name="resposta_idanalise" id="resposta_idanalise" required>
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_analise = "
                                                    SELECT 
                                                        tbanalise.*,tbrisco.nome AS nome_risco
                                                    FROM 
                                                        tbanalise 
                                                    LEFT JOIN
                                                        tbrisco
                                                    ON
                                                        tbrisco.idrisco = tbanalise.idrisco
                                                    WHERE 
                                                        medidaDoRisco
                                                    IS NOT NULL";
                                            $result_analise = mysqli_query($conn, $query_analise);
                                            foreach ($result_analise as $row_analise) {
                                                require_once("templates/function.php");
                                                $orcamento = dinheiro($row_analise['orcamento']);
                                                if($row_analise['medidaDoRisco'] > 0.24){
                                                    $medidadorisco_status = "Risco Alto";
                                                }elseif ($row_analise['medidaDoRisco'] > 0.08) {
                                                    $medidadorisco_status = "Risco Médio";
                                                } else {
                                                    $medidadorisco_status = "Risco Baixo";
                                                }
                                                
                                                ?>
                                                
                                                <option value="<?= $row_analise['idanalise']; ?>">Risco: <?= $row_analise['nome_risco']; ?> - <?= $medidadorisco_status; ?> (<?= $row_analise['medidaDoRisco']; ?>) - Orçamento: <?= $orcamento; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome*</label>
                                        <input type="text" class="form-control" name="resposta_nome" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Descrição*</label>
                                        <textarea class="form-control" name="resposta_descricao" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Situação*</label>
                                        <select class="form-control" name="resposta_situacao" id="resposta_situacao" required>
                                            <option value="">Selecione</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Atividade Mitigadora</label>
                                        <select class="form-control" name="resposta_idatividade" id="resposta_idatividade">
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_atividade = "SELECT idatividade,objetivo FROM tbatividade";
                                            $result_atividade = mysqli_query($conn, $query_atividade);
                                            foreach ($result_atividade as $row_atividade) {
                                                ?>
                                                <option value="<?= $row_atividade['idatividade']; ?>"><?= $row_atividade['objetivo']; ?></option>
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

        <!-- Modal Cadastrar Atividade -->
        <div class="modal fade" id="ModalCadastrarAtividade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cadastrar Atividade Mitigadora</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="action/cadastrarAtividade.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5><i class="fa fa-list"></i> Informações da Atividade Mitigadora</h5>
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
        <div class="modal fade" id="ModalDetalheResposta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <h5><i class="fa fa-list"></i> Informações da Resposta ao Risco</h5>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome</label>
                                    <p><output type="text" id="detalhe_respostanome"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label class="col-form-label font-weight-bold">Descrição</label>
                                    <p><output type="text" id="detalhe_respostadescricao"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label class="col-form-label font-weight-bold">Situação</label>
                                    <p><output type="text" id="detalhe_respostasituacao"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <hr>
                                <h5><i class="fa fa-list"></i> Informações do Sistema*</h5>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label class="col-form-label font-weight-bold">Medida do Risco</label>
                                    <p><output type="text" id="detalhe_respostamedidadorisco"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Probabilidade</label>
                                    <p><output type="text" id="detalhe_respostaprobabilidade"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Impacto</label>
                                    <p><output type="text" id="detalhe_respostaimpacto"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Data de Início</label>
                                    <p><output type="text" id="detalhe_respostadatainicio"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Data Fim</label>
                                    <p><output type="text" id="detalhe_respostadatafim"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Situação</label>
                                    <p><output type="text" id="detalhe_respostaanalisesituacao"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Atividade Mitigadora</label>
                                        <select class="form-control" id="detalhe_respostaidatividade" disabled>
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_atividade_det = "SELECT idatividade,objetivo FROM tbatividade";
                                            $result_atividade_det = mysqli_query($conn, $query_atividade_det);
                                            foreach ($result_atividade_det as $row_atividade_det) {
                                                ?>
                                                <option value="<?= $row_atividade_det['idatividade']; ?>"><?= $row_atividade_det['objetivo']; ?></option>
                                            <?php } ?>
                                        </select>
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
        <div class="modal fade" id="ModalEditarResposta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Resposta ao Risco</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="action/editarResposta.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5><i class="fa fa-list"></i> Informações do Resposta ao Risco</h5>
                                </div>
                                <input type="hidden" class="form-control" id="editar_respostaidresposta" name="editar_respostaidresposta" required>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome*</label>
                                        <input type="text" class="form-control" id="editar_respostanome" name="editar_respostanome" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Descrição*</label>
                                        <textarea class="form-control" id="editar_respostadescricao" name="editar_respostadescricao" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Situação*</label>
                                        <select class="form-control" name="editar_respostasituacao" id="editar_respostasituacao" required>
                                            <option value="">Selecione</option>
                                            <option value="Transferido">Transferido</option>
                                            <option value="Mitigado">Mitigado</option>
                                            <option value="Escalado">Escalado</option>
                                            <option value="Previnido">Previnido</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Atividade Mitigadora</label>
                                        <select class="form-control" name="editar_respostaidatividade" id="editar_respostaidatividade">
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_atividade_edt = "SELECT idatividade,objetivo FROM tbatividade";
                                            $result_atividade_edt = mysqli_query($conn, $query_atividade_edt);
                                            foreach ($result_atividade_edt as $row_atividade_edt) {
                                                ?>
                                                <option value="<?= $row_atividade_edt['idatividade']; ?>"><?= $row_atividade_edt['objetivo']; ?></option>
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
            $('#ModalDetalheResposta').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var detalhe_respostanome = button.data('respostanome'); // Extract info from data-* attributes
                var detalhe_respostadescricao = button.data('respostadescricao');
                var detalhe_respostasituacao = button.data('respostasituacao');

                var detalhe_respostamedidadorisco = button.data('respostamedidadorisco');
                var detalhe_respostaprobabilidade = button.data('respostaprobabilidade');
                var detalhe_respostaimpacto = button.data('respostaimpacto');
                var detalhe_respostadatainicio = button.data('respostadatainicio');
                var detalhe_respostadatafim = button.data('respostadatafim');
                var detalhe_respostaanalisesituacao = button.data('respostaanalisesituacao');
                var detalhe_respostaidatividade = button.data('respostaidatividade');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Detalhe da Resposta ao Risco: ' + detalhe_respostanome);
                modal.find('#detalhe_respostanome').val(detalhe_respostanome);
                modal.find('#detalhe_respostadescricao').val(detalhe_respostadescricao);
                modal.find('#detalhe_respostasituacao').val(detalhe_respostasituacao);

                modal.find('#detalhe_respostamedidadorisco').val(detalhe_respostamedidadorisco);
                modal.find('#detalhe_respostaprobabilidade').val(detalhe_respostaprobabilidade);
                modal.find('#detalhe_respostaimpacto').val(detalhe_respostaimpacto);
                modal.find('#detalhe_respostadatainicio').val(detalhe_respostadatainicio);
                modal.find('#detalhe_respostadatafim').val(detalhe_respostadatafim);
                modal.find('#detalhe_respostaanalisesituacao').val(detalhe_respostaanalisesituacao);
                
                modal.find('#detalhe_respostaidatividade').val(detalhe_respostaidatividade);
            });
        </script>
        <!-- Fim Modal Detalhe-->

        <!-- Modal Editar-->
        <script>
            $('#ModalEditarResposta').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var editar_respostaidresposta = button.data('respostaidresposta'); // Extract info from data-* attributes
                var editar_respostanome = button.data('respostanome'); // Extract info from data-* attributes
                var editar_respostadescricao = button.data('respostadescricao'); // Extract info from data-* attributes
                var editar_respostasituacao = button.data('respostasituacao');
                var editar_respostaidatividade = button.data('respostaidatividade');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Editar Resposta ao Risco: ' + editar_respostanome);
                modal.find('#editar_respostaidresposta').val(editar_respostaidresposta);
                modal.find('#editar_respostanome').val(editar_respostanome);
                modal.find('#editar_respostadescricao').val(editar_respostadescricao);
                modal.find('#editar_respostasituacao').val(editar_respostasituacao);
                modal.find('#editar_respostaidatividade').val(editar_respostaidatividade);
            });
        </script>
        <!-- Fim Modal Editar-->

        <!-- Reseta Modal Cadastrar ao Fechar-->
        <script>
            $('#ModalCadastrarResposta').on('hidden.bs.modal', function () {
                $(this).find("input,textarea,select").val('').end();
            });
        </script>
        <!-- Fim Reseta Modal Cadastrar ao Fechar-->

        <!-- Datatable -->
        <script>
            $(document).ready(function () {
                $('#DataTable').DataTable({
                    buttons: [
                        'print'
                    ]
                });
            });
        </script>
        <!-- Fim Datatable --> 

        <!-- JS Selecionar Resposta -->
        <script type="text/javascript">
            $(function () {
                $('#resposta_idanalise').change(function () {
                    if ($(this).val()) {
                        $.getJSON('action/selecionarResposta.php?search=', {
                            idanalise: $(this).val(),
                            ajax: 'true'
                        }, function (j) {
                            if (j[0].riscobaixo === 1) {
                                var options = '<option value="Aceito">Aceito</option>';
                                $('#resposta_situacao').html(options).show();
                            } else {
                                var options = '<option value="">Selecione</option>';
                                options += '<option value="Transferido">Transferido</option>';
                                options += '<option value="Escalado">Escalado</option>';
                                options += '<option value="Previnido">Previnido</option>';
                                options += '<option value="Mitigado">Mitigado</option>';
                                $('#resposta_situacao').html(options).show();
                            }
                        });
                    } else {
                        $('#resposta_situacao').html('<option value="">Selecione</option>');
                    }
                });
            });
        </script>
        <!-- Fim JS Selecionar Resposta -->
    </body>
</html>

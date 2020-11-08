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
                                    <table class="table table-bordered table-hover text-dark" id="DataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center" colspan="5">Informações</th>
                                                <th class="text-center" colspan="2">Ferramentas</th>
                                            </tr>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Descrição</th>
                                                <th>Situação</th>
                                                <th>Medida do Risco</th>
                                                <th>Situação</th>
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
                                                <th>Situação</th>
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
                                                        tbanalise.medidadorisco AS analise_medidadorisco,
                                                        tbanalise.probabilidade AS analise_probabilidade,
                                                        tbanalise.probabilidadeJustificativa AS analise_probabilidadejustificativa,
                                                        tbanalise.impacto AS analise_impacto,
                                                        tbanalise.impactoJustificativa AS analise_impactojustificativa,
                                                        tbanalise.datainicio AS analise_datainicio,
                                                        tbanalise.datafim AS analise_datafim,
                                                        tbanalise.situacao AS  analise_situacao,
                                                        tbatividade.objetivo AS atividade_objetivo,
                                                        tbatividade.descricao AS atividade_descricao,
                                                        tbatividade.dataInicio AS atividade_datainicio,
                                                        tbatividade.dataFim AS atividade_datafim
                                                    FROM 
                                                        tbresposta
                                                    LEFT JOIN
                                                        tbanalise
                                                    ON
                                                        tbresposta.idanalise = tbanalise.idanalise
                                                    LEFT JOIN
                                                        tbatividade
                                                    ON
                                                        tbresposta.idatividade = tbatividade.idatividade";
                                            $result = mysqli_query($conn, $query);
                                            foreach ($result as $row) {
                                                ?>
                                                <tr>
                                                    <td><?= $row['nome']; ?></td>
                                                    <td><?= $row['descricao']; ?></td>
                                                    <td><?= $row['situacao']; ?></td>
                                                    <?php
                                                    if ($row['analise_medidadorisco'] > 0.24) {
                                                        ?><td class="text-danger"><?= $row['analise_medidadorisco']; ?> - Risco Alto</td>
                                                        <?php
                                                    } elseif ($row['analise_medidadorisco'] > 0.08) {
                                                        ?><td class="text-warning"><?= $row['analise_medidadorisco']; ?> - Risco Médio</td>
                                                        <?php
                                                    } else {
                                                        ?><td class="text-success"><?= $row['analise_medidadorisco']; ?> - Risco Baixo</td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <td><?= $row['analise_situacao']; ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalDetalheResposta"
                                                                data-respostanome="<?= $row['nome']; ?>"
                                                                data-respostadescricao="<?= $row['descricao']; ?>"
                                                                data-respostasituacao="<?= $row['situacao']; ?>"
                                                                
                                                                data-analiseprobabilidade="<?= $row['analise_probabilidade']; ?>"
                                                                data-analiseprobabilidadejustificativa="<?= $row['analise_probabilidadejustificativa']; ?>"
                                                                data-analiseimpacto="<?= $row['analise_impacto']; ?>"
                                                                data-analiseimpactojustificativa="<?= $row['analise_impactojustificativa']; ?>"
                                                                data-analisemedidadorisco="<?= $row['analise_medidadorisco']; ?>"
                                                                
                                                                data-analisedatainicio="<?= $row['analise_datainicio']; ?>"
                                                                data-analisedatafim="<?= $row['analise_datafim']; ?>"
                                                                data-analisesituacao="<?= $row['analise_situacao']; ?>"
                                                                
                                                                data-analiseidatividade="<?= $row['idatividade']; ?>"
                                                                
                                                                data-atividadeobjetivo="<?= $row['atividade_objetivo']; ?>"
                                                                data-atividadedescricao="<?= $row['atividade_descricao']; ?>"
                                                                data-atividadedatainicio="<?= $row['atividade_datainicio']; ?>"
                                                                data-atividadedatafim="<?= $row['atividade_datafim']; ?>"
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

        <!-- Modal Cadastrar Resposta -->
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
                                            $query_atividade = "SELECT idatividade,objetivo,dataInicio,dataFim FROM tbatividade";
                                            $result_atividade = mysqli_query($conn, $query_atividade);
                                            foreach ($result_atividade as $row_atividade) {
                                                ?>
                                                <option value="<?= $row_atividade['idatividade']; ?>"><?= $row_atividade['objetivo']; ?> (Validade de <?= $row_atividade['dataInicio']; ?> a <?= $row_atividade['dataFim']; ?>)</option>
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

        <!-- Modal Cadastrar Atividade Mitigadora-->
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
                                <h5 class="text-primary"><i class="fa fa-clipboard"></i> Informações da Resposta ao Risco</h5>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome</label>
                                    <p><output type="text" id="detalhe_respostanome"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Descrição</label>
                                    <p><output type="text" id="detalhe_respostadescricao"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Situação</label>
                                    <p><output type="text" id="detalhe_respostasituacao"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <hr>
                                <h5 class="text-dark"><i class="fa fa-archive"></i> Informações do Análise</h5>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Probabilidade</label>
                                    <p><output type="text" id="detalhe_analiseprobabilidade"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Justificativa da Probabilidade</label>
                                    <p><output type="text" id="detalhe_analiseprobabilidadejustificativa"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Impacto</label>
                                    <p><output type="text" id="detalhe_analiseimpacto"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Justificativa do Impacto</label>
                                    <p><output type="text" id="detalhe_analiseimpactojustificativa"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Medida do Risco</label>
                                    <p><output type="text" id="detalhe_analisemedidadorisco"></output></p>
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
                                    <label class="col-form-label font-weight-bold">Data de Início</label>
                                    <p><output type="date" id="detalhe_analisedatainicio"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Data Fim</label>
                                    <p><output type="date" id="detalhe_analisedatafim"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <hr>
                                <h5 class="text-dark"><i class="fa fa-archive"></i> Informações da Atividade Mitigadora</h5>
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
                                    <label class="col-form-label font-weight-bold">Data de Início</label>
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
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nome*</label>
                                        <input type="text" class="form-control" id="editar_respostanome" name="editar_respostanome" required>
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
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Descrição*</label>
                                        <textarea class="form-control" id="editar_respostadescricao" name="editar_respostadescricao" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Atividade Mitigadora</label>
                                        <select class="form-control" name="editar_respostaidatividade" id="editar_respostaidatividade">
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_atividade_edt = "SELECT idatividade,objetivo,dataFim,dataInicio FROM tbatividade";
                                            $result_atividade_edt = mysqli_query($conn, $query_atividade_edt);
                                            foreach ($result_atividade_edt as $row_atividade_edt) {
                                                ?>
                                                <option value="<?= $row_atividade_edt['idatividade']; ?>"><?= $row_atividade_edt['objetivo']; ?> (Validade de <?= $row_atividade_edt['dataInicio']; ?> a <?= $row_atividade_edt['dataFim']; ?>)</option>
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

        <!-- JS Medida do Risco + Status -->
        <script>
            // Medida do Risco
            function medidadoriscoprint(medidadorisco) {
                var analisemedidadorisco_print;
                if (medidadorisco === "") {
                    analisemedidadorisco_print = "";
                } else if (medidadorisco > 0.24) {
                    analisemedidadorisco_print = medidadorisco + ' - Risco Alto';
                } else if (medidadorisco > 0.08) {
                    analisemedidadorisco_print = medidadorisco + ' - Risco Médio';
                } else {
                    analisemedidadorisco_print = medidadorisco + ' - Risco Baixo';
                }
                return analisemedidadorisco_print;
            }
        </script>
        <!-- Fim JS Medida do Risco + Status -->
        
        <!-- Modal Detalhe-->
        <script>
            $('#ModalDetalheResposta').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var detalhe_respostanome = button.data('respostanome'); // Extract info from data-* attributes
                var detalhe_respostadescricao = button.data('respostadescricao');
                var detalhe_respostasituacao = button.data('respostasituacao');

                var detalhe_analiseprobabilidade = button.data('analiseprobabilidade');
                var detalhe_analiseprobabilidadejustificativa = button.data('analiseprobabilidadejustificativa');
                var detalhe_analiseimpacto = button.data('analiseimpacto');
                var detalhe_analiseimpactojustificativa = button.data('analiseimpactojustificativa');
                var detalhe_analisemedidadorisco = button.data('analisemedidadorisco');
                
                var detalhe_analisedatainicio = button.data('analisedatainicio');
                var detalhe_analisedatafim = button.data('analisedatafim');
                var detalhe_analisesituacao = button.data('analisesituacao');
                
                var detalhe_analiseidatividade = button.data('analiseidatividade');
                
                var detalhe_atividadeobjetivo = button.data('atividadeobjetivo');
                var detalhe_atividadedescricao = button.data('atividadedescricao');
                var detalhe_atividadedatainicio = button.data('atividadedatainicio');
                var detalhe_atividadedatafim = button.data('atividadedatafim');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Detalhe da Resposta ao Risco: ' + detalhe_respostanome);
                modal.find('#detalhe_respostanome').val(detalhe_respostanome);
                modal.find('#detalhe_respostadescricao').val(detalhe_respostadescricao);
                modal.find('#detalhe_respostasituacao').val(detalhe_respostasituacao);

                modal.find('#detalhe_analiseprobabilidade').val(detalhe_analiseprobabilidade);
                modal.find('#detalhe_analiseprobabilidadejustificativa').val(detalhe_analiseprobabilidadejustificativa);
                modal.find('#detalhe_analiseimpacto').val(detalhe_analiseimpacto);
                modal.find('#detalhe_analiseimpactojustificativa').val(detalhe_analiseimpactojustificativa);
                //modal.find('#detalhe_analisemedidadorisco').val(medidadoriscoprint(detalhe_analisemedidadorisco));
                var situacaocolor = "text-success";
                if (detalhe_analisemedidadorisco > 0.24) {
                    situacaocolor = 'text-danger';
                } else if (detalhe_analisemedidadorisco > 0.08) {
                    situacaocolor = "text-warning";
                } else {
                    situacaocolor = "text-success";
                }
                $('#detalhe_analisemedidadorisco').html('<p><output type="text" class="' + situacaocolor + '" id="detalhe_analisemedidadorisco">' + medidadoriscoprint(detalhe_analisemedidadorisco) + '</output></p>');

                modal.find('#detalhe_analisedatainicio').val(detalhe_analisedatainicio);
                modal.find('#detalhe_analisedatafim').val(detalhe_analisedatafim);
                //modal.find('#detalhe_analisesituacao').val(detalhe_analisesituacao);
                var situacaocolor = "text-success";
                if (detalhe_analisesituacao === 'Aprovada') {
                    situacaocolor = "text-success";
                } else if (detalhe_analisesituacao === 'Reprovada') {
                    situacaocolor = "text-danger";
                } else if (detalhe_analisesituacao === 'Bloqueada') {
                    situacaocolor = "text-dark";
                } else {
                    situacaocolor = "text-info";
                }
                $('#detalhe_analisesituacao').html('<p><output type="text" class="' + situacaocolor + '" id="detalhe_analisesituacao">' + detalhe_analisesituacao + '</output></p>');

                
                modal.find('#detalhe_analiseidatividade').val(detalhe_analiseidatividade);
                
                modal.find('#detalhe_atividadeobjetivo').val(detalhe_atividadeobjetivo);
                modal.find('#detalhe_atividadedescricao').val(detalhe_atividadedescricao);
                modal.find('#detalhe_atividadedatainicio').val(detalhe_atividadedatainicio);
                modal.find('#detalhe_atividadedatafim').val(detalhe_atividadedatafim);
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

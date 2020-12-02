<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php
    require_once("lib/Database/ConnectionAbstract.php");
    $conn = Database\ConnectionAbstract::getConn();
    //var_dump($conn);

    $titulo = "Análise do Analista";
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
                        <a href="analise2.php"><button type="button" class="btn btn-outline-primary btn-lg mx-2">Análise do Analista</button></a>
                        <a href="resposta.php"><button type="button" class="btn btn-outline-dark btn-lg mx-2">Resposta ao Risco</button></a>
                        <a href="atividade.php"><button type="button" class="btn btn-outline-dark btn-lg mx-2">Atividade</button></a>
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
                        <h1 class="h3 mb-2 text-gray-800">Análise do Analista</h1>
                        <p class="mb-4">A atual página mostra a relação de análises cadastradas. Permite ao Analista realizar a sua análise ou realizar alterações.
                        </p>
                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Análise</h6>
                            </div>
                            <div class="card-body">

                                <!-- Tabela -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-dark" id="DataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center" colspan="7">Informações</th>
                                                <th class="text-center" colspan="2">Ferramentas</th>
                                            </tr>
                                            <tr>
                                                <th>Risco</th>
                                                <th>Analista</th>
                                                <th>Status</th>
                                                <th>Probabilidade</th>
                                                <th>Impacto</th>
                                                <th>Medida do Risco</th>
                                                <th>Data Fim</th>

                                                <th class="text-center">Detalhe</th>
                                                <th class="text-center">Editar</th>
                                                <!--<th class="text-center">Excluir</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="m-0 font-weight-bold text-dark">

                                                <th>Risco</th>
                                                <th>Analista</th>
                                                <th>Status</th>
                                                <th>Probabilidade</th>
                                                <th>Impacto</th>
                                                <th>Medida do Risco</th>
                                                <th>Data Fim</th>

                                                <th class="text-center">Detalhe</th>
                                                <th class="text-center">Editar</th>
                                                <!--<th class="text-center">Excluir</th>-->
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            require_once("lib/Database/Connection.php");
                                            $query = "SELECT 
    tbrisco.nome AS risco_nome,
    tbrisco.descricao AS risco_descricao,
    tbrisco.idcategoria AS risco_idcategoria,
    tbmodulo.nome AS modulo_nome,
    tbmodulo.descricao AS modulo_descricao,
    tbmodulo.ambiente AS modulo_ambiente,
    tbmodulo.idsistema AS modulo_idsistema,
    tbanalise.*,
    tbanalista.nome AS analista_nome,
    tbanalista.email AS analista_email,
    tbresposta.nome AS resposta_nome,
    tbresposta.descricao AS resposta_descricao,
    tbresposta.situacao AS resposta_situacao
FROM
    tbanalise
        LEFT JOIN
    tbanalista ON tbanalista.idanalista = tbanalise.idanalista
        LEFT JOIN
    tbmodulo ON tbmodulo.idmodulo = tbanalise.idmodulo
        LEFT JOIN
    tbrisco ON tbrisco.idrisco = tbanalise.idrisco
        LEFT JOIN
    tbresposta ON tbresposta.idanalise = tbanalise.idanalise
WHERE
    tbanalise.situacao = 'Em Análise'
        OR tbanalise.situacao = 'Bloqueada'";
                                            $result = mysqli_query($conn, $query);
                                            foreach ($result as $row) {
                                                ?>
                                                <tr>

                                                    <td><?= $row['risco_nome']; ?></td>
                                                    <td><?= $row['analista_nome']; ?></td>
                                                    <?php
                                                    if ($row['situacao'] == 'Em Análise') {
                                                        ?><td class="text-info">Em Análise</td><?php
                                                    } elseif ($row['situacao'] == 'Bloqueada') {
                                                        ?><td class="text-dark">Bloqueada</td><?php
                                                    } elseif ($row['situacao'] == 'Reprovada') {
                                                        ?><td class="text-danger">Reprovada</td><?php
                                                    } else {
                                                        ?><td class="text-success">Aprovada</td><?php
                                                    }
                                                    ?>
                                                    <td><?= $row['probabilidade']; ?></td>
                                                    <td><?= $row['impacto']; ?></td>
                                                    <?php
                                                    if ($row['medidaDoRisco'] > 0.24) {
                                                        ?><td class="text-danger"><?= $row['medidaDoRisco']; ?> - Risco Alto</td>
                                                        <?php
                                                    } elseif ($row['medidaDoRisco'] > 0.08) {
                                                        ?><td class="text-warning"><?= $row['medidaDoRisco']; ?> - Risco Médio</td>
                                                        <?php
                                                    } elseif ($row['medidaDoRisco'] > 0.00) {
                                                        ?><td class="text-success"><?= $row['medidaDoRisco']; ?> - Risco Baixo</td>
                                                        <?php
                                                    } else {
                                                        ?><td></td>
                                                        <?php
                                                    }
                                                    ?>

                                                    <td><?= $row['dataFim']; ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalDetalheAnalise"
                                                                data-analisemodulonome="<?= $row['modulo_nome']; ?>"
                                                                data-modulodescricao="<?= $row['modulo_descricao']; ?>"
                                                                data-analisemoduloambiente="<?= $row['modulo_ambiente']; ?>"

                                                                data-analiserisconome="<?= $row['risco_nome']; ?>"
                                                                data-analiseriscodescricao="<?= $row['risco_descricao']; ?>"

                                                                data-analisesituacao="<?= $row['situacao']; ?>"
                                                                data-analiseorcamento="<?= $row['orcamento']; ?>"
                                                                data-analisedatainicio="<?= $row['dataInicio']; ?>"
                                                                data-analisedatafim="<?= $row['dataFim']; ?>"

                                                                data-analiseprobabilidade="<?= $row['probabilidade']; ?>"
                                                                data-analiseprobabilidadejustificativa="<?= $row['probabilidadeJustificativa']; ?>"
                                                                data-analiseimpacto="<?= $row['impacto']; ?>"
                                                                data-analiseimpactojustificativa="<?= $row['impactoJustificativa']; ?>"
                                                                data-analisemedidadorisco="<?= $row['medidaDoRisco']; ?>"

                                                                data-analiseanalistanome="<?= $row['analista_nome']; ?>"
                                                                data-analiseanalistaemail="<?= $row['analista_email']; ?>"

                                                                data-respostanome="<?= $row['resposta_nome']; ?>"
                                                                data-respostadescricao="<?= $row['resposta_descricao']; ?>"
                                                                data-respostasituacao="<?= $row['resposta_situacao']; ?>"
                                                                >
                                                            <i class="fas fa-fingerprint"></i>&nbsp;Detalhe
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#ModalEditarAnalise"
                                                                data-analiseidanalise="<?= $row['idanalise']; ?>"

                                                                data-analiseidanalista="<?= $row['idanalista']; ?>"
                                                                data-analiseidmodulo="<?= $row['idmodulo']; ?>"
                                                                data-analiseidrisco="<?= $row['idrisco']; ?>"

                                                                data-analiseanalistanome="<?= $row['analista_nome']; ?>"
                                                                data-analisemodulonome="<?= $row['modulo_nome']; ?>"
                                                                data-analiserisconome="<?= $row['risco_nome']; ?>"
                                                                data-analiseriscodescricao="<?= $row['risco_descricao']; ?>"

                                                                data-analisedatainicio="<?= $row['dataInicio']; ?>"
                                                                data-analisedatafim="<?= $row['dataFim']; ?>"
                                                                data-analisesituacao="<?= $row['situacao']; ?>"
                                                                data-orcamento="<?= $row['orcamento']; ?>"

                                                                data-analiseprobabilidade="<?= $row['probabilidade']; ?>"
                                                                data-analiseprobabilidadejustificativa="<?= $row['probabilidadeJustificativa']; ?>"
                                                                data-analiseimpacto="<?= $row['impacto']; ?>"
                                                                data-analiseimpactojustificativa="<?= $row['impactoJustificativa']; ?>"
                                                                data-analisemedidadorisco="<?= $row['medidaDoRisco']; ?>"
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
                    <div class="modal-body" id="printThis">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="text-dark"><i class="fa fa-archive"></i> Informações do Módulo</h5>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome</label>
                                    <p><output type="text" id="detalhe_analisemodulonome"></output></p>
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
                                    <label class="col-form-label font-weight-bold">Ambiente</label>
                                    <p><output type="text" id="detalhe_analisemoduloambiente"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <hr>
                                <h5 class="text-dark"><i class="fa fa-archive"></i> Informações do Risco</h5>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome</label>
                                    <p><output type="text" id="detalhe_analiserisconome"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Descrição</label>
                                    <p><output type="text" id="detalhe_analiseriscodescricao"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <hr>
                                <h5 class="text-dark"><i class="fa fa-archive"></i> Informações do Analista</h5>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome</label>
                                    <p><output type="text" id="detalhe_analiseanalistanome"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">E-mail</label>
                                    <p><output type="text" id="detalhe_analiseanalistaemail"></output></p>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="infoanalise">
                            <div class="col-lg-12">
                                <hr>
                                <h5 class="text-primary"><i class="fa fa-clipboard"></i> Informações da Análise</h5>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Situação</label>
                                    <p><output type="text" id="detalhe_analisesituacao"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Orçamento</label>
                                    <p><output type="text" id="detalhe_analiseorcamento"></output></p>
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
                        </div>
                        <div class="row" id="infoanalise2">
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
                                    <label class="col-form-label font-weight-bold">Justificativa de Impacto</label>
                                    <p><output type="text" id="detalhe_analiseimpactojustificativa"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label class="col-form-label font-weight-bold">Medida do Risco</label>
                                    <p><output type="text" id="detalhe_analisemedidadorisco"></output></p>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="resposta_detalhe">
                            <div class="col-lg-12">
                                <hr>
                                <h5 class="text-dark"><i class="fa fa-archive"></i> Informações da Resposta</h5>
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
                        <form method="post" action="action/editarAnalise2.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5><i class="fa fa-list"></i> Informações da Análise</h5>
                                </div>
                                <input type="hidden" class="form-control" id="editar_analiseidanalise" name="editar_analiseidanalise" required>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Probabilidade</label>
                                        <select class="form-control" id="editar_analiseprobabilidade" name="editar_analiseprobabilidade" required>
                                            <option value="">Selecione</option>
                                            <option value="0.9">0.90 - Muito Alta</option>
                                            <option value="0.7">0.70 - Alta</option>
                                            <option value="0.5">0.50 - Média</option>
                                            <option value="0.3">0.30 - Baixa</option>
                                            <option value="0.1">0.10 - Muito Baixa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Justificativa da Probabilidade</label>
                                        <textarea class="form-control" rows="1" id="editar_analiseprobabilidadejustificativa" name="editar_analiseprobabilidadejustificativa" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Impacto</label>
                                        <select class="form-control" id="editar_analiseimpacto" name="editar_analiseimpacto" required>
                                            <option value="">Selecione</option>
                                            <option value="0.8">0.80 - Muito Alto</option>
                                            <option value="0.4">0.40 - Alto</option>
                                            <option value="0.2">0.20 - Médio</option>
                                            <option value="0.1">0.10 - Baixo</option>
                                            <option value="0.05">0.05 - Muito Baixo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Justificativa do Impacto</label>
                                        <textarea class="form-control" rows="1" id="editar_analiseimpactojustificativa" name="editar_analiseimpactojustificativa" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <label class="col-form-label font-weight-bold">Medida do Risco</label>
                                        <p><output type="text" id="editar_analisemedidadorisco"></output></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Orçamento (R$)</label>
                                        <input type="text" class="form-control" id="editar_analiseorcamento" name="editar_analiseorcamento" placeholder="Ex: 500 = R$ 500,00" required>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div>
                                        <label class="col-form-label font-weight-bold">Situação</label>
                                        <p><output type="text" id="editar_analisesituacao"></output></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <label class="col-form-label font-weight-bold">Data de Início</label>
                                        <p><output type="text" id="editar_analisedatainicio"></output></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <label class="col-form-label font-weight-bold">Data Fim</label>
                                        <p><output type="text" id="editar_analisedatafim"></output></p>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <hr>
                                    <h5 class="text-dark"><i class="fa fa-archive"></i> Informações Adicionais</h5>
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <label class="col-form-label font-weight-bold">Nome do Analista Responsável</label>
                                        <p><output type="text" id="editar_analiseanalistanome"></output></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <label class="col-form-label font-weight-bold">Nome do Módulo</label>
                                        <p><output type="text" id="editar_analisemodulonome"></output></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <label class="col-form-label font-weight-bold">Nome do Risco</label>
                                        <p><output type="text" id="editar_analiserisconome"></output></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <label class="col-form-label font-weight-bold">Descrição do Risco</label>
                                        <p><output type="text" id="editar_analiseriscodescricao"></output></p>
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
            $('#ModalDetalheAnalise').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var detalhe_analisemodulonome = button.data('analisemodulonome');
                var detalhe_modulodescricao = button.data('modulodescricao');
                var detalhe_analisemoduloambiente = button.data('analisemoduloambiente');

                var detalhe_analiserisconome = button.data('analiserisconome');
                var detalhe_analiseriscodescricao = button.data('analiseriscodescricao');

                var detalhe_analisesituacao = button.data('analisesituacao');
                var detalhe_analiseorcamento = button.data('analiseorcamento');
                var detalhe_analisedatainicio = button.data('analisedatainicio');
                var detalhe_analisedatafim = button.data('analisedatafim');

                var detalhe_analiseprobabilidade = button.data('analiseprobabilidade');
                var detalhe_analiseprobabilidadejustificativa = button.data('analiseprobabilidadejustificativa');
                var detalhe_analiseimpacto = button.data('analiseimpacto');
                var detalhe_analiseimpactojustificativa = button.data('analiseimpactojustificativa');
                var detalhe_analisemedidadorisco = button.data('analisemedidadorisco');

                var detalhe_analiseanalistanome = button.data('analiseanalistanome'); // Extract info from data-* attributes
                var detalhe_analiseanalistaemail = button.data('analiseanalistaemail');

                var detalhe_respostanome = button.data('respostanome');
                var detalhe_respostadescricao = button.data('respostadescricao');
                var detalhe_respostasituacao = button.data('respostasituacao');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Detalhe da Análise: ' + detalhe_analiseanalistanome);

                modal.find('#detalhe_analisemodulonome').val(detalhe_analisemodulonome);
                modal.find('#detalhe_modulodescricao').val(detalhe_modulodescricao);
                modal.find('#detalhe_analisemoduloambiente').val(detalhe_analisemoduloambiente);

                modal.find('#detalhe_analiserisconome').val(detalhe_analiserisconome);
                modal.find('#detalhe_analiseriscodescricao').val(detalhe_analiseriscodescricao);

                modal.find('#detalhe_analisesituacao').val(detalhe_analisesituacao);
                modal.find('#detalhe_analiseorcamento').val(detalhe_analiseorcamento.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'}));
                modal.find('#detalhe_analisedatainicio').val(detalhe_analisedatainicio);
                modal.find('#detalhe_analisedatafim').val(detalhe_analisedatafim);

                //Probabilidade
                if (detalhe_analiseprobabilidade === 0.9) {
                    modal.find('#detalhe_analiseprobabilidade').val(detalhe_analiseprobabilidade + ' - Muito Alta');
                } else if (detalhe_analiseprobabilidade === 0.7) {
                    modal.find('#detalhe_analiseprobabilidade').val(detalhe_analiseprobabilidade + ' - Alta');
                } else if (detalhe_analiseprobabilidade === 0.5) {
                    modal.find('#detalhe_analiseprobabilidade').val(detalhe_analiseprobabilidade + ' - Média');
                } else if (detalhe_analiseprobabilidade === 0.3) {
                    modal.find('#detalhe_analiseprobabilidade').val(detalhe_analiseprobabilidade + ' - Baixa');
                } else if (detalhe_analiseprobabilidade === 0.1) {
                    modal.find('#detalhe_analiseprobabilidade').val(detalhe_analiseprobabilidade + ' - Muito Baixa');
                } else {
                    modal.find('#detalhe_analiseprobabilidade').val(detalhe_analiseprobabilidade);
                }

                modal.find('#detalhe_analiseprobabilidadejustificativa').val(detalhe_analiseprobabilidadejustificativa);

                // Impacto
                if (detalhe_analiseimpacto === 0.8) {
                    modal.find('#detalhe_analiseimpacto').val(detalhe_analiseimpacto + ' - Muito Alto');
                } else if (detalhe_analiseimpacto === 0.4) {
                    modal.find('#detalhe_analiseimpacto').val(detalhe_analiseimpacto + ' - Alto');
                } else if (detalhe_analiseimpacto === 0.2) {
                    modal.find('#detalhe_analiseimpacto').val(detalhe_analiseimpacto + ' - Médio');
                } else if (detalhe_analiseimpacto === 0.1) {
                    modal.find('#detalhe_analiseimpacto').val(detalhe_analiseimpacto + ' - Baixo');
                } else if (detalhe_analiseimpacto === 0.05) {
                    modal.find('#detalhe_analiseimpacto').val(detalhe_analiseimpacto + ' - Muito Baixo');
                } else {
                    modal.find('#detalhe_analiseimpacto').val(detalhe_analiseimpacto);
                }
                modal.find('#detalhe_analiseimpactojustificativa').val(detalhe_analiseimpactojustificativa);
                if (detalhe_analisemedidadorisco === "") {
                    $('#infoanalise').show();
                    $('#infoanalise2').hide();
                } else {
                    $('#infoanalise').show();
                    $('#infoanalise2').show();
                }
                var situacaocolor = "text-success";
                if (detalhe_analisemedidadorisco > 0.24) {
                    situacaocolor = 'text-danger';
                } else if (detalhe_analisemedidadorisco > 0.08) {
                    situacaocolor = "text-warning";
                } else {
                    situacaocolor = "text-success";
                }
                $('#detalhe_analisemedidadorisco').html('<p><output type="text" class="' + situacaocolor + '" id="detalhe_analisemedidadorisco">' + medidadoriscoprint(detalhe_analisemedidadorisco) + '</output></p>');

                modal.find('#detalhe_analiseanalistanome').val(detalhe_analiseanalistanome);
                modal.find('#detalhe_analiseanalistaemail').val(detalhe_analiseanalistaemail);

                if (detalhe_respostanome === '') {
                    $('#resposta_detalhe').hide();
                } else {
                    $('#resposta_detalhe').show();
                }
                modal.find('#detalhe_respostanome').val(detalhe_respostanome);
                modal.find('#detalhe_respostadescricao').val(detalhe_respostadescricao);
                modal.find('#detalhe_respostasituacao').val(detalhe_respostasituacao);
            });
        </script>
        <!-- Fim Modal Detalhe-->

        <!-- Modal Editar-->
        <script>
            $('#ModalEditarAnalise').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var editar_analiseidanalise = button.data('analiseidanalise');

                var editar_analiseidanalista = button.data('analiseidanalista'); // Extract info from data-* attributes
                var editar_analiseidmodulo = button.data('analiseidmodulo'); // Extract info from data-* attributes
                var editar_analiseidrisco = button.data('analiseidrisco'); // Extract info from data-* attributes

                var editar_analiseanalistanome = button.data('analiseanalistanome');
                var editar_analisemodulonome = button.data('analisemodulonome');
                var editar_analiserisconome = button.data('analiserisconome');
                var editar_analiseriscodescricao = button.data('analiseriscodescricao');

                var editar_analisesituacao = button.data('analisesituacao');
                var editar_analisedatainicio = button.data('analisedatainicio');
                var editar_analisedatafim = button.data('analisedatafim');
                var editar_analiseorcamento = button.data('orcamento');

                var editar_analiseprobabilidade = button.data('analiseprobabilidade');
                var editar_analiseprobabilidadejustificativa = button.data('analiseprobabilidadejustificativa');
                var editar_analiseimpacto = button.data('analiseimpacto');
                var editar_analiseimpactojustificativa = button.data('analiseimpactojustificativa');
                var editar_analisemedidadorisco = button.data('analisemedidadorisco');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Editar Análise - Responsável: ' + editar_analiseanalistanome);
                modal.find('#editar_analiseidanalise').val(editar_analiseidanalise);

                modal.find('#editar_analiseidanalista').val(editar_analiseidanalista);
                modal.find('#editar_analiseidmodulo').val(editar_analiseidmodulo);
                modal.find('#editar_analiseidrisco').val(editar_analiseidrisco);

                modal.find('#editar_analiseanalistanome').val(editar_analiseanalistanome);
                modal.find('#editar_analisemodulonome').val(editar_analisemodulonome);
                modal.find('#editar_analiserisconome').val(editar_analiserisconome);
                modal.find('#editar_analiseriscodescricao').val(editar_analiseriscodescricao);

                modal.find('#editar_analisesituacao').val(editar_analisesituacao);
                modal.find('#editar_analisedatainicio').val(editar_analisedatainicio);
                modal.find('#editar_analisedatafim').val(editar_analisedatafim);
                modal.find('#editar_analiseorcamento').val(editar_analiseorcamento);

                modal.find('#editar_analiseprobabilidade').val(editar_analiseprobabilidade);
                modal.find('#editar_analiseprobabilidadejustificativa').val(editar_analiseprobabilidadejustificativa);
                modal.find('#editar_analiseimpacto').val(editar_analiseimpacto);
                modal.find('#editar_analiseimpactojustificativa').val(editar_analiseimpactojustificativa);
                modal.find('#editar_analisemedidadorisco').val(editar_analisemedidadorisco);
                var situacaocolor = "text-success";
                if (editar_analisemedidadorisco > 0.24) {
                    situacaocolor = 'text-danger';
                } else if (editar_analisemedidadorisco > 0.08) {
                    situacaocolor = "text-warning";
                } else {
                    situacaocolor = "text-success";
                }
                $('#editar_analisemedidadorisco').html('<p><output type="text" class="' + situacaocolor + '" id="editar_analisemedidadorisco">' + medidadoriscoprint(editar_analisemedidadorisco) + '</output></p>');

            });
        </script>
        <!-- Fim Modal Editar-->

        <!-- Reseta Modal Cadastrar ao Fechar-->
        <script>
            $('#ModalCadastrarAnalise').on('hidden.bs.modal', function () {
                $(this).find("input,textarea,select").val('').end();

            });
        </script>
        <!-- Fim Reseta Modal Cadastrar ao Fechar-->

        <!-- Datatable-->
        <script>
            $(document).ready(function () {
                $('#DataTable').DataTable({
                    buttons: [
                        {
                            extend: 'copy',
                            text: '<i class="fas fa-print"></i> Copiar Tabela'
                        }, {
                            extend: 'excel',
                            text: '<i class="fas fa-file-excel"></i> Gerar Relatório: Excel'
                        }, {
                            extend: 'pdf',
                            text: '<i class="fas fa-file-pdf"></i> Gerar Relatório: PDF'
                        }
                    ], initComplete: function () {
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
        <!-- Fim Datatable-->

        <!-- JS Preview da Medida do Risco -->
        <script type="text/javascript">
            $(function () {
                $('#editar_analiseimpacto').change(function () {
                    if ($('#editar_analiseimpacto').val() !== "" && $('#editar_analiseprobabilidade').val() !== "") {
                        var impacto = $('#editar_analiseimpacto').val();
                        var probabilidade = $('#editar_analiseprobabilidade').val();
                        var resultado = parseFloat(impacto) * parseFloat(probabilidade);
                        var resultadodescricao = '';
                        var resultadocolor = '';
                        if (resultado > 0.24) {
                            resultadodescricao = 'Risco Alto';
                            resultadocolor = 'text-danger';
                        } else if (resultado > 0.08) {
                            resultadodescricao = 'Risco Médio';
                            resultadocolor = 'text-warning';
                        } else {
                            resultadodescricao = 'Risco Baixo';
                            resultadocolor = 'text-success';
                        }
                        $('#editar_analisemedidadorisco').html('<p><output type="text" class="' + resultadocolor + '" id="editar_analisemedidadorisco">' + resultado.toFixed(2) + ' - ' + resultadodescricao + '</output></p>');
                    } else {
                        $('#editar_analisemedidadorisco').html('<p><output type="text" id="editar_analisemedidadorisco">0</output></p>');
                    }
                });
                $('#editar_analiseprobabilidade').change(function () {
                    if ($('#editar_analiseimpacto').val() !== "" && $('#editar_analiseprobabilidade').val() !== "") {
                        var impacto = $('#editar_analiseimpacto').val();
                        var probabilidade = $('#editar_analiseprobabilidade').val();
                        var resultado = parseFloat(impacto) * parseFloat(probabilidade);
                        var resultadodescricao = '';
                        var resultadocolor = '';
                        if (resultado > 0.24) {
                            resultadodescricao = 'Risco Alto';
                            resultadocolor = 'text-danger';
                        } else if (resultado > 0.08) {
                            resultadodescricao = 'Risco Médio';
                            resultadocolor = 'text-warning';
                        } else {
                            resultadodescricao = 'Risco Baixo';
                            resultadocolor = 'text-success';
                        }
                        $('#editar_analisemedidadorisco').html('<p><output type="text" class="' + resultadocolor + '" id="editar_analisemedidadorisco">' + resultado.toFixed(2) + ' - ' + resultadodescricao + '</output></p>');
                    } else {
                        $('#editar_analisemedidadorisco').html('<p><output type="text" id="editar_analisemedidadorisco">0</output></p>');
                    }
                });

            });
        </script>
        <!-- Fim JS Preview da Medida do Risco -->
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

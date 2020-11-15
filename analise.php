<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php
    require_once("lib/Database/ConnectionAbstract.php");
    $conn = Database\ConnectionAbstract::getConn();
    //var_dump($conn);

    $titulo = "Análise do Gerente de Projeto";
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
                        <a href="risco.php"><button type="button" class="btn btn-outline-dark btn-lg mx-2">Risco</button></a>
                        <a href="analise.php"><button type="button" class="btn btn-outline-primary btn-lg mx-2">Análise do Gerente</button></a>
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
                        <h1 class="h3 mb-2 text-gray-800">Análise do Gerente de Projeto</h1>
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

                                </div>
                                <!-- Tabela -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-dark" id="DataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center" colspan="8">Informações</th>
                                                <th class="text-center" colspan="2">Ferramentas</th>
                                            </tr>
                                            <tr>
                                                <th>Status da Análise</th>
                                                <th>Sistema</th>
                                                <th>Analista</th>
                                                <!--<th>Módulo</th>-->
                                                <th>Risco</th>
                                                <th>Situação</th>
                                                <th>Data de Início</th>
                                                <th>Prazo Final</th>
                                                <th>Orçamento</th>
                                                <th class="text-center">Detalhe</th>
                                                <th class="text-center">Editar</th>
                                                <!--<th class="text-center">Excluir</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="m-0 font-weight-bold text-dark">
                                                <th>Status da Análise</th>
                                                <th>Sistema</th>
                                                <th>Analista</th>
                                                <!--<th>Módulo</th>-->
                                                <th>Risco</th>
                                                <th>Situação</th>
                                                <th>Data Início</th>
                                                <th>Prazo Final</th>
                                                <th>Orçamento</th>
                                                <th class="text-center">Detalhe</th>
                                                <th class="text-center">Editar</th>
                                                <!--<th class="text-center">Excluir</th>-->
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            require_once("lib/Database/Connection.php");
                                            if (isset($_GET['situacao'])) {
                                                $situacao_get = $_GET['situacao'];
                                                $query = "SELECT 
                                                        tbmodulo.nome AS modulo_nome, tbmodulo.ambiente AS modulo_ambiente,tbmodulo.idsistema AS modulo_idsistema,
                                                        tbrisco.nome AS risco_nome, tbrisco.descricao AS risco_descricao, tbrisco.idcategoria AS risco_idcategoria,
                                                        tbanalise.*,
                                                        tbanalista.nome AS analista_nome, tbanalista.email AS analista_email
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
                                                        tbrisco.idrisco = tbanalise.idrisco
                                                    WHERE
                                                        tbanalise.situacao = '$situacao_get'";
                                            } else {
                                                $query = "
                                                    SELECT 
                                                        tbmodulo.nome AS modulo_nome, tbmodulo.ambiente AS modulo_ambiente,tbmodulo.idsistema AS modulo_idsistema,
                                                        tbrisco.nome AS risco_nome, tbrisco.descricao AS risco_descricao, tbrisco.idcategoria AS risco_idcategoria,
                                                        tbanalise.*,
                                                        tbanalista.nome AS analista_nome, tbanalista.email AS analista_email
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
                                            }
                                            $result = mysqli_query($conn, $query);
                                            foreach ($result as $row) {
                                                if (isset($row['modulo_idsistema'])) {
                                                    $modulo_idsistema = $row['modulo_idsistema'];
                                                    $query_sistema = "SELECT 
                                                                tbsistema.nome AS sistema_nome, 
                                                                tbsistema.dataInicio AS sistema_dataInicio, 
                                                                tbsistema.dataFim AS sistema_dataFim 
                                                            FROM 
                                                                tbsistema 
                                                            WHERE 
                                                                idsistema = $modulo_idsistema LIMIT 1;";
                                                    //echo $query_sistema;
                                                    $result_sistema = mysqli_query($conn, $query_sistema);
                                                    foreach ($result_sistema as $row_sistema) {
                                                        
                                                    }
                                                }
                                                if ($row['risco_idcategoria'] != "") {
                                                    $risco_idcategoria = $row['risco_idcategoria'];
                                                    $query_categoria = "SELECT 
                                                                tbcategoria.nome AS categoria_nome, 
                                                                tbcategoria.nivel AS categoria_nivel
                                                            FROM 
                                                                tbcategoria 
                                                            WHERE 
                                                                idcategoria = $risco_idcategoria LIMIT 1";
                                                    $result_categoria = mysqli_query($conn, $query_categoria);
                                                    foreach ($result_categoria as $row_categoria) {
                                                        
                                                    }
                                                }

                                                include_once 'templates/function.php';
                                                ?>
                                                <tr>
                                                    <?php
                                                    if ($row['situacao'] == 'Em Análise' || $row['situacao'] == 'Bloqueada') {
                                                        ?><th class="text-success">Aberta</th><?php
                                                    } else {
                                                        ?><th>Encerrada</th><?php
                                                        }
                                                        ?>
                                                    <td><?= $row_sistema['sistema_nome']; ?></td>
                                                    <td><?= $row['analista_nome']; ?></td>
                                                    <!--<td><?= $row['modulo_nome']; ?></td>-->
                                                    <td><?= $row['risco_nome']; ?></td>
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
                                                    <td><?= $row['dataInicio']; ?></td>
                                                    <?php
                                                    $data_atual = date("Y/m/d");
                                                    $data_fim = $row['dataFim'];
                                                    if (strtotime($data_fim) < strtotime($data_atual) && $row['situacao'] !== 'Reprovada' && $row['situacao'] !== 'Aprovada') {
                                                        ?><td class="text-danger"><?= $data_fim; ?></td><?php
                                                    } else {
                                                        ?><td><?= $data_fim; ?></td><?php
                                                    }
                                                    ?>
                                                    <td><?= dinheiro($row['orcamento']); ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalDetalheAnalise"
                                                                data-analisemodulonome="<?= $row['modulo_nome']; ?>"
                                                                data-analisemoduloambiente="<?= $row['modulo_ambiente']; ?>"
                                                                data-analisemoduloidsistema="<?= $row['modulo_idsistema']; ?>"

                                                                data-analiserisconome="<?= $row['risco_nome']; ?>"
                                                                data-analiseriscodescricao="<?= $row['risco_descricao']; ?>"
                                                                data-analiseriscoidcategoria="<?= $row['risco_idcategoria']; ?>"

                                                                data-analisedatainicio="<?= $row['dataInicio']; ?>"
                                                                data-analisedatafim="<?= $row['dataFim']; ?>"
                                                                data-analisesituacao="<?= $row['situacao']; ?>"
                                                                data-analiseorcamento="<?= dinheiro($row['orcamento']); ?>"
                                                                data-analiseprobabilidade="<?= $row['probabilidade']; ?>"
                                                                data-analiseprobabilidadejustificativa="<?= $row['probabilidadeJustificativa']; ?>"
                                                                data-analiseimpacto="<?= $row['impacto']; ?>"
                                                                data-analiseimpactojustificativa="<?= $row['impactoJustificativa']; ?>"
                                                                data-analisemedidadorisco="<?= $row['medidaDoRisco']; ?>"

                                                                data-analiseanalistanome="<?= $row['analista_nome']; ?>"
                                                                data-analiseanalistaemail="<?= $row['analista_email']; ?>"

                                                                data-analisesistemanome="<?= $row_sistema['sistema_nome']; ?>"
                                                                data-analisesistemadatainicio="<?= $row_sistema['sistema_dataInicio']; ?>"
                                                                data-analisesistemadatafim="<?= $row_sistema['sistema_dataFim']; ?>"

                                                                data-analisecategorianome="<?= $row_categoria['categoria_nome']; ?>"
                                                                data-analisecategorianivel="<?= $row_categoria['categoria_nivel']; ?>"
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

                                                                data-analisedatainicio="<?= $row['dataInicio']; ?>"
                                                                data-analisedatafim="<?= $row['dataFim']; ?>"
                                                                data-analisesituacao="<?= $row['situacao']; ?>"
                                                                data-analiseorcamento="<?= $row['orcamento']; ?>"
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
                                        <label for="recipient-name" class="col-form-label">Sistema</label>
                                        <select class="form-control" id="analise_idsistema" name="analise_idsistema" required>
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_sistema_cad = "SELECT idsistema, nome FROM tbsistema";
                                            $result_sistema = mysqli_query($conn, $query_sistema_cad);
                                            foreach ($result_sistema as $row_sistema) {
                                                ?>
                                                <option value="<?= $row_sistema['idsistema']; ?>"><?= $row_sistema['nome']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
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
                                        <select class="form-control" id="analise_idmodulo" name="analise_idmodulo" required>
                                            <option value="">Selecione</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Risco(s) (Não atribuído(s))</label>
                                        <select class="form-control" name="analise_idrisco" required>
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_risco = "SELECT idrisco, nome FROM tbrisco WHERE idrisco NOT IN (SELECT idrisco FROM tbanalise)";
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
                                        <div class="d-flex p-2">Em Análise</div>
                                        <input type="hidden" class="form-control" name="analise_situacao" value="Em Análise">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Data de Início</label>
                                        <input type="date" class="form-control" name="analise_datainicio" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Data Fim</label>
                                        <input type="date" class="form-control" name="analise_datafim" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Orçamento (R$)</label>
                                        <input type="text" class="form-control" name="analise_orcamento" required>
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
                    <div class="modal-body" id="printThis">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="text-dark"><i class="fa fa-archive"></i> Informações do Risco</h5>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome do Risco</label>
                                    <p><output type="text" id="detalhe_analiserisconome"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Descrição</label>
                                    <p><output type="text" id="detalhe_analiseriscodescricao"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12 ">
                                <hr>
                                <h5 class="text-dark"><i class="fa fa-archive"></i> Informações da Categoria</h5>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome da Categoria</label>
                                    <p><output type="text" id="detalhe_analisecategorianome"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nível</label>
                                    <p><output type="text" id="detalhe_analisecategorianivel"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12 ">
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
                            <div class="col-lg-12">
                                <div>
                                    <label class="col-form-label font-weight-bold">Medida do Risco</label>
                                    <p><output type="text" id="detalhe_analisemedidadorisco"></output></p>
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
                                <h5 class="text-dark"><i class="fa fa-archive"></i> Informações do Sistema</h5>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome do Sistema</label>
                                    <p><output type="text" id="detalhe_analisesistemanome"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Data de Início</label>
                                    <p><output type="date" id="detalhe_analisesistemadatainicio"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Data Final</label>
                                    <p><output type="date" id="detalhe_analisesistemadatafim"></output></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <hr>
                                <h5 class="text-dark"><i class="fa fa-archive"></i> Informações do Módulo</h5>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome do Módulo</label>
                                    <p><output type="text" id="detalhe_analisemodulonome"></output></p>
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
                                <h5 class="text-dark"><i class="fa fa-archive"></i> Informações do Analista</h5>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <label class="col-form-label font-weight-bold">Nome do Analista Responsável</label>
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
                        <form method="post" action="action/editarAnalise.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5><i class="fa fa-list"></i> Informações da Análise</h5>
                                </div>
                                <input type="hidden" class="form-control" id="editar_analiseidanalise" name="editar_analiseidanalise" required>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Analista</label>
                                        <select class="form-control" id="editar_analiseidanalista" name="editar_analiseidanalista" required>
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_analista_edt = "SELECT idanalista, nome FROM tbanalista";
                                            $result_analista_edt = mysqli_query($conn, $query_analista_edt);
                                            foreach ($result_analista_edt as $row_analista_edt) {
                                                ?>
                                                <option value="<?= $row_analista_edt['idanalista']; ?>"><?= $row_analista_edt['nome']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Módulo</label>
                                        <select class="form-control" id="editar_analiseidmodulo" name="editar_analiseidmodulo" required>
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_modulo_edt = "SELECT idmodulo, nome FROM tbmodulo";
                                            $result_modulo_edt = mysqli_query($conn, $query_modulo_edt);
                                            foreach ($result_modulo_edt as $row_modulo_edt) {
                                                ?>
                                                <option value="<?= $row_modulo_edt['idmodulo']; ?>"><?= $row_modulo_edt['nome']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Risco</label>
                                        <select class="form-control" id="editar_analiseidrisco" name="editar_analiseidrisco" required>
                                            <option value="">Selecione</option>
                                            <?php
                                            $query_risco_edt = "SELECT idrisco, nome FROM tbrisco";
                                            $result_risco_edt = mysqli_query($conn, $query_risco_edt);
                                            foreach ($result_risco_edt as $row_risco_edt) {
                                                ?>
                                                <option value="<?= $row_risco_edt['idmodulo']; ?>"><?= $row_risco_edt['nome']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Situação</label>

                                        <select class="form-control" name="editar_analisesituacao" id="editar_analisesituacao" required>
                                            <option value="">Selecione</option>
                                            <option value="Em Análise">Em Análise</option>
                                            <option value="Bloqueada">Bloquear</option>
                                            <option value="Reprovada">Reprovar</option>
                                            <option value="Aprovada">Aprovar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Data de Início</label>
                                        <input type="date" class="form-control" id="editar_analisedatainicio" name="editar_analisedatainicio" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Data Fim</label>
                                        <input type="date" class="form-control" id="editar_analisedatafim" name="editar_analisedatafim" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Orçamento (R$)</label>
                                        <input type="text" class="form-control" id="editar_analiseorcamento" name="editar_analiseorcamento" required>
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

                var detalhe_analisemodulonome = button.data('analisemodulonome'); // Extract info from data-* attributes
                var detalhe_analisemoduloambiente = button.data('analisemoduloambiente');
                var detalhe_analisemoduloidsistema = button.data('analisemoduloidsistema');

                var detalhe_analiserisconome = button.data('analiserisconome');
                var detalhe_analiseriscodescricao = button.data('analiseriscodescricao');
                var detalhe_analiseriscoidcategoria = button.data('analiseriscoidcategoria');

                var detalhe_analisedatainicio = button.data('analisedatainicio');
                var detalhe_analisedatafim = button.data('analisedatafim');
                var detalhe_analisesituacao = button.data('analisesituacao');
                var detalhe_analiseorcamento = button.data('analiseorcamento');

                var detalhe_analiseprobabilidade = button.data('analiseprobabilidade');
                var detalhe_analiseprobabilidadejustificativa = button.data('analiseprobabilidadejustificativa');
                var detalhe_analiseimpacto = button.data('analiseimpacto');
                var detalhe_analiseimpactojustificativa = button.data('analiseimpactojustificativa');
                var detalhe_analisemedidadorisco = button.data('analisemedidadorisco');

                var detalhe_analiseanalistanome = button.data('analiseanalistanome');
                var detalhe_analiseanalistaemail = button.data('analiseanalistaemail');

                var detalhe_analisesistemanome = button.data('analisesistemanome');
                var detalhe_analisesistemadatainicio = button.data('analisesistemadatainicio');
                var detalhe_analisesistemadatafim = button.data('analisesistemadatafim');

                var detalhe_analisecategorianome = button.data('analisecategorianome');
                var detalhe_analisecategorianivel = button.data('analisecategorianivel');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Detalhe da Análise ');

                modal.find('#detalhe_analisemodulonome').val(detalhe_analisemodulonome);
                modal.find('#detalhe_analisemoduloambiente').val(detalhe_analisemoduloambiente);
                modal.find('#detalhe_analisemoduloidsistema').val(detalhe_analisemoduloidsistema);

                modal.find('#detalhe_analiserisconome').val(detalhe_analiserisconome);
                modal.find('#detalhe_analiseriscodescricao').val(detalhe_analiseriscodescricao);
                modal.find('#detalhe_analiseriscoidcategoria').val(detalhe_analiseriscoidcategoria);

                modal.find('#detalhe_analisedatainicio').val(detalhe_analisedatainicio);
                modal.find('#detalhe_analisedatafim').val(detalhe_analisedatafim);
                //modal.find('#detalhe_analisesituacao').val(detalhe_analisesituacao); //
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


                modal.find('#detalhe_analiseorcamento').val(detalhe_analiseorcamento);

                modal.find('#detalhe_analiseprobabilidade').val(detalhe_analiseprobabilidade);
                modal.find('#detalhe_analiseprobabilidadejustificativa').val(detalhe_analiseprobabilidadejustificativa);
                modal.find('#detalhe_analiseimpacto').val(detalhe_analiseimpacto);
                modal.find('#detalhe_analiseimpactojustificativa').val(detalhe_analiseimpactojustificativa);
                //modal.find('#detalhe_analisemedidadorisco').val(medidadoriscoprint(detalhe_analisemedidadorisco)); //
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

                modal.find('#detalhe_analisesistemanome').val(detalhe_analisesistemanome);
                modal.find('#detalhe_analisesistemadatainicio').val(detalhe_analisesistemadatainicio);
                modal.find('#detalhe_analisesistemadatafim').val(detalhe_analisesistemadatafim);

                modal.find('#detalhe_analisecategorianome').val(detalhe_analisecategorianome);
                modal.find('#detalhe_analisecategorianivel').val(detalhe_analisecategorianivel);
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

                var editar_analisesituacao = button.data('analisesituacao');
                var editar_analisedatainicio = button.data('analisedatainicio');
                var editar_analisedatafim = button.data('analisedatafim');
                var editar_analiseorcamento = button.data('analiseorcamento');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Editar Análise ');
                modal.find('#editar_analiseidanalise').val(editar_analiseidanalise);
                modal.find('#editar_analiseidanalista').val(editar_analiseidanalista);
                modal.find('#editar_analiseidmodulo').val(editar_analiseidmodulo);
                if (editar_analiseidrisco !== "") {
                    $.getJSON('action/selecionarRisco.php?search=', {editar_analiseidrisco: editar_analiseidrisco, ajax: 'true'}, function (j) {
                        var options = '<option value="">Selecione</option>';
                        for (var i = 0; i < j.length; i++) {
                            options += '<option value="' + j[i].idrisco + '">' + j[i].nome + '</option>';
                        }
                        $('#editar_analiseidrisco').html(options).show();
                        $('#editar_analiseidrisco').val(editar_analiseidrisco);
                    });
                }

                modal.find('#editar_analiseanalistanome').val(editar_analiseanalistanome);
                modal.find('#editar_analisemodulonome').val(editar_analisemodulonome);
                modal.find('#editar_analiserisconome').val(editar_analiserisconome);

                modal.find('#editar_analisesituacao').val(editar_analisesituacao);
                modal.find('#editar_analisedatainicio').val(editar_analisedatainicio);
                modal.find('#editar_analisedatafim').val(editar_analisedatafim);
                modal.find('#editar_analiseorcamento').val(editar_analiseorcamento);
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
        <!-- Fim Reseta Modal Cadastrar ao Fechar-->
        <!-- JS Selecionar Modulo -->
        <script type="text/javascript">
            $(function () {
                $('#analise_idsistema').change(function () {
                    if ($(this).val()) {
                        $.getJSON('action/selecionarModulo.php?search=', {
                            idsistema: $(this).val(),
                            ajax: 'true'
                        }, function (j) {
                            var options = '<option value="">Selecione</option>';
                            if (j.length > 0) {
                                for (var i = 0; i < j.length; i++) {
                                    options += '<option value="' + j[i].idmodulo + '">' + j[i].nome + '</option>';
                                }
                                $('#analise_idmodulo').html(options).show();
                            } else {
                                $('#analise_idmodulo').html('<option value="">*Não há opções para o atual sistema*</option>');
                            }
                        });
                    } else {
                        $('#analise_idmodulo').html('<option value="">Selecione</option>');
                    }
                });
            });
        </script>
        <!-- Fim JS Selecionar Modulo -->
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

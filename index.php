<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php
    require_once("lib/Database/ConnectionAbstract.php");
    $conn = Database\ConnectionAbstract::getConn();
    //var_dump($conn);

    $titulo = "Dashboard";
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
                        <a href="analise.php"><button type="button" class="btn btn-outline-dark btn-lg mx-2">Análise do Gerente</button></a>
                        <a href="analista.php"><button type="button" class="btn btn-outline-dark btn-lg mx-2">Analista</button></a>
                    </nav>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Nome do Sistema</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <select class="form-control" id="dashboard_nomesistema" name="dashboard_nomesistema" required>
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        require_once("lib/Database/Connection.php");
                                                        $query_index = "SELECT idsistema, nome FROM tbsistema";
                                                        $result_index = mysqli_query($conn, $query_index);
                                                        foreach ($result_index as $row_index) {
                                                            ?>
                                                            <option value="<?= $row_index['idsistema']; ?>"><?= $row_index['nome']; ?></option>
                                                        <?php } ?>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-list fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Módulos no sistema (Quantidade)</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="dashboard_modulo_qtd">Sistema não Selecionado</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-bookmark fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Medida de Risco Analisadas</div>
                                                <div id="dashboard_analise_medidadorisco">
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Sistema não Selecionado</div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Requests Card Example -->

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-danger shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Orçamento (Total)</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-left" id="dashboard_analise_orcamento_total"></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content Row -->

                        <div class="row">

                            <!-- Area Chart -->
                            <div class="col-xl-8 col-lg-7">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Status das Análises do Sistema SIS Industria Bell</h6>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div id="dashboard_analise_status_list"></div>
                                        
                                        <!--
                                        <h4 class="small font-weight-bold" >Risco: RIS Novidade<span class="float-right">Orçamento: R$ 5000,00</span></h4>
                                        <h4 class="small font-weight-bold" >Situação da Análise: Bloqueada<span class="float-right">Progresso: 20%</span></h4>
                                        <div class="progress mb-4">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        
                                        <h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>
                                        <div class="progress mb-4">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>
                                        <div class="progress mb-4">
                                            <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>
                                        <div class="progress mb-4">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <h4 class="small font-weight-bold">Account Setup <span class="float-right">Complete!</span></h4>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>

                            <!-- Pie Chart -->
                            <div class="col-xl-4 col-lg-5">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Situação das Análises Cadastradas</h6>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="chart-pie pt-4 pb-2">
                                            <canvas id="myPieChart"></canvas>
                                            <?php
                                            $qtdEmAnalise = 0;
                                            $qtdBloqueada = 0;
                                            $qtdAprovada = 0;
                                            $qtdReprovada = 0;
                                            $result_analise_situacao = mysqli_query($conn, "SELECT situacao FROM tbanalise");
                                            if ($result_analise_situacao) {
                                                foreach ($result_analise_situacao as $row_analise_situacao) {
                                                    if ($row_analise_situacao['situacao'] == 'Bloqueada') {
                                                        $qtdBloqueada++;
                                                    } elseif ($row_analise_situacao['situacao'] == 'Aprovada') {
                                                        $qtdAprovada++;
                                                    } elseif ($row_analise_situacao['situacao'] == 'Reprovada') {
                                                        $qtdReprovada++;
                                                    } else {
                                                        $qtdEmAnalise++;
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="mt-4 text-center small">
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-dark"></i><a href='analise.php?situacao=Bloqueada'> Bloqueada</a>
                                            </span>
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-success"></i><a href='analise.php?situacao=Aprovada'> Aprovada</a>
                                            </span>
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-danger"></i><a href='analise.php?situacao=Reprovada'> Reprovada</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
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
        <?php include_once "templates/frameworks.php"; ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.13/jquery.mask.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
        <script src="lib/jquery.inputmask.js"></script>
        <!-- JS Selecionar Modulo -->
        <script type="text/javascript">
            $(function () {
                $('#dashboard_nomesistema').change(function () {
                    if ($(this).val()) {
                        $.getJSON('action/dashboardSelecionarModulo.php?search=', {
                            idsistema: $(this).val(),
                            ajax: 'true'
                        }, function (j) {
                            if (j.length > 0) {

                                $('#dashboard_modulo_qtd').html(j.length);
                                var orcamento_total = 0;
                                var medidadorisco_analisadas_soma = 0;
                                var medidadorisco_total_soma = 0;
                                var status = '';
                                for (var i = 0; i < j.length; i++) {
                                    orcamento_total += j[i].soma_orcamento;
                                    //console.log(j[i]);
                                    medidadorisco_analisadas_soma += j[i].medidadorisco_analisada;
                                    medidadorisco_total_soma += j[i].medidadoriscototal;
                                    //console.log(j[i].analise);
                                    //console.log(j[i].analise.length);
                                    if (j[i].analise.length > 0) {
                                        for (var x = 0; x < j[i].analise.length; x++) {
                                            //console.log(j[i].analise[x].analise_situacao);
                                            var analise_situacao = j[i].analise[x].analise_situacao;
                                            var analise_risco_nome = j[i].analise[x].analise_risco_nome;
                                            var analise_orcamento = j[i].analise[x].analise_orcamento;
                                            var analise_porcentagem_value = 0;
                                            var analise_porcentagem_color = 0;
                                            if (analise_situacao === 'Bloqueada') {
                                                analise_porcentagem_value = 50;
                                                analise_porcentagem_color = 'bg-dark';
                                            } else if (analise_situacao === 'Em Análise') {
                                                analise_porcentagem_value = 25;
                                                analise_porcentagem_color = 'bg-info';
                                            } else if (analise_situacao === 'Aprovada') {
                                                analise_porcentagem_value = 100;
                                                analise_porcentagem_color = 'bg-success';
                                            } else if (analise_situacao === 'Reprovada') {
                                                analise_porcentagem_value = 100;
                                                analise_porcentagem_color = 'bg-danger';
                                            } else {
                                                analise_porcentagem_value = 0;
                                                analise_porcentagem_color = 'bg-dark';
                                            }
                                            status += '<h4 class="small font-weight-bold" >Risco: ' + analise_risco_nome + '<span class="float-right">Orçamento: R$ ' + analise_orcamento + ',00</span></h4>\n\
                                            <h4 class="small font-weight-bold" >Situação da Análise: ' + analise_situacao + '<span class="float-right">Progresso: ' + analise_porcentagem_value + '%</span></h4>\n\
                                            <div class="progress mb-4"><div class="progress-bar ' + analise_porcentagem_color + '" role="progressbar" style="width: ' + analise_porcentagem_value + '%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div></div>';
                                        }
                                    }


                                }

                                $('#dashboard_analise_status_list').html(status);
                                if (orcamento_total > 0) {
                                    $('#dashboard_analise_orcamento_total').html('<div class="h5 mb-0 font-weight-bold text-gray-800">R$ ' + orcamento_total + ',00</div>');
                                } else {
                                    $('#dashboard_analise_orcamento_total').html('<div class="h5 mb-0 font-weight-bold text-gray-800">R$ 0,00</div>');

                                }

                                if (medidadorisco_total_soma > 0) {
                                    var porcentagem = medidadorisco_analisadas_soma / (medidadorisco_total_soma / 100);
                                    var bar_color = "bg-success";
                                    if (porcentagem > 75) {
                                        bar_color = "bg-success";
                                    } else if (porcentagem > 50) {
                                        bar_color = "bg-warning";
                                    } else {
                                        bar_color = "bg-danger";
                                    }


                                    var resultado_porcentagem = "<div class='row no-gutters align-items-center'>\n\
                        <div class='col-auto'>\n\
<div class='h5 mb-0 mr-3 font-weight-bold text-gray-800'>" + medidadorisco_analisadas_soma + " de " + medidadorisco_total_soma + " (" + porcentagem + "%)</div>\n\
</div><div class='col'>\n\
<div class='progress progress-sm mr-2'>\n\
<div class='progress-bar " + bar_color + "' role='progressbar' style='width: " + porcentagem + "%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'>\n\
</div></div></div></div>";
                                    $('#dashboard_analise_medidadorisco').html(resultado_porcentagem);

                                } else {
                                    $('#dashboard_analise_medidadorisco').html('<div class="h5 mb-0 font-weight-bold text-gray-800">Não cadastrada</div>');
$('#dashboard_analise_status_list').html('<h4 class="small font-weight-bold" >Nenhum dado foi encontrado.</h4>');
                                }
                            } else {
                                $('#dashboard_modulo_qtd').html('Sem registros');
                                $('#dashboard_analise_orcamento_total').html('<div class="h5 mb-0 font-weight-bold text-gray-800">R$ 0,00</div>');
                                $('#dashboard_analise_medidadorisco').html('<div class="h5 mb-0 font-weight-bold text-gray-800">Sem registros</div>');
                            $('#dashboard_analise_status_list').html('<h4 class="small font-weight-bold" >Nenhum dado foi encontrado.</h4>');
                            }
                        });
                    } else {
                        $('#resposta_situacao').html('<option value="">Selecione</option>');
                        $('#dashboard_modulo_qtd').html('Sistema não selecionado');
                        $('#dashboard_analise_orcamento_total').html('Sistema não selecionado');
                        $('#dashboard_analise_medidadorisco').html('<div class="h5 mb-0 font-weight-bold text-gray-800">Sistema não selecionado</div>');
                        $('#dashboard_analise_status_list').html('<h4 class="small font-weight-bold" >Nenhum dado foi encontrado.</h4>');
                    }
                });
            });

        </script>
        <!-- Fim JS Selecionar Modulo -->
        <script>
            var ctx = document.getElementById('myPieChart');
            var myPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    datasets: [{
                            data: [<?= $qtdEmAnalise ?>, <?= $qtdAprovada ?>, <?= $qtdBloqueada ?>, <?= $qtdReprovada ?>],
                            backgroundColor: ["#36b9cc", "#1cc88a", "#5a5c69", "#e74a3b"],
                            hoverBackgroundColor: ["#36b9cc", "#1cc88a", "#5a5c69", "#e74a3b"]
                        }],
                    labels: [
                        'Em Análise',
                        'Aprovada',
                        'Bloqueada',
                        'Reprovada'
                    ]
                }
            });

        </script>
        <script>
            $(document).ready(function () {
                $("#dashboard_analise_orcamento_total").inputmask('decimal', {
                    'alias': 'numeric',
                    'groupSeparator': ',',
                    'autoGroup': true,
                    'digits': 2,
                    'radixPoint': ".",
                    'digitsOptional': false,
                    'allowMinus': false,
                    'prefix': 'R$ ',
                    'placeholder': ''
                });
            });
        </script>
    </body>

</html>

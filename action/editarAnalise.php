<?php

session_start();

require_once("../lib/Database/Connection.php");

$btnEditar = filter_input(INPUT_POST, 'btnEditar', FILTER_SANITIZE_STRING);
if (isset($btnEditar)) {
    $analiseidanalise = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_analiseidanalise', FILTER_SANITIZE_STRING));
    
    $analiseidanalista = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_analiseidanalista', FILTER_SANITIZE_STRING));
    $analiseidmodulo = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_analiseidmodulo', FILTER_SANITIZE_STRING)); //obrigatorio
    $analiseidrisco = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_analiseidrisco', FILTER_SANITIZE_STRING)); //obrigatorio
    
    $analisesituacao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_analisesituacao', FILTER_SANITIZE_STRING)); //obrigatorio
    $analisedatainicio = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_analisedatainicio', FILTER_SANITIZE_STRING)); //obrigatorio
    $analisedatafim = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_analisedatafim', FILTER_SANITIZE_STRING)); //obrigatorio
    
    $analiseorcamento = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_analiseorcamento', FILTER_SANITIZE_STRING)); //obrigatorio
    
    try {
        $db->update(
                'tbanalise',
                [
                    'idanalista' => $analiseidanalista,
                    'idmodulo' => $analiseidmodulo,
                    'idrisco' => $analiseidrisco,
                    'situacao' => $analisesituacao,
                    'dataInicio' => $analisedatainicio,
                    'dataFim' => $analisedatafim,
                    'orcamento' => $analiseorcamento
                ],
                [
                    'idanalise' => $analiseidanalise
                ]
            );

        if ($db->affected()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> A edição foi realizada com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            header('Location: ../analise.php');
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro 003!</strong> Falha ao realizar a edição. Tente novamente mais tarde.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            header('Location: ../analise.php');
        }
    } catch (Exception $ex) {
        $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 002!</strong> Falha ao realizar a edição.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
        header('Location: ../analise.php');
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 001!</strong> Entre em contato com o Administrador do Sistema.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../analise.php');
}
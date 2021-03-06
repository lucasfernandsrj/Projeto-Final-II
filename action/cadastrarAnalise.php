<?php

session_start();
require_once("../lib/Database/Connection.php");

$btnCadastrar = filter_input(INPUT_POST, 'btnCadastrar', FILTER_SANITIZE_STRING);

if (isset($btnCadastrar)) {
    $analise_idanalista = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'analise_idanalista', FILTER_SANITIZE_STRING)); //obrigatorio
    $analise_idmodulo = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'analise_idmodulo', FILTER_SANITIZE_STRING)); //obrigatorio
    $analise_idrisco = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'analise_idrisco', FILTER_SANITIZE_STRING)); //obrigatorio
    $analise_situacao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'analise_situacao', FILTER_SANITIZE_STRING)); //obrigatorio

    $analise_datainicio = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'analise_datainicio', FILTER_SANITIZE_STRING)); //obrigatorio
    $analise_datafim = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'analise_datafim', FILTER_SANITIZE_STRING));

    $analise_orcamento = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'analise_orcamento', FILTER_SANITIZE_STRING));
    //$analise_medidadorisco = $analise_probabilidade * $analise_impacto;

    if (strtotime($analise_datainicio) > strtotime($analise_datafim)) {
        $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro!</strong> Falha ao realizar o cadastro. A Data Final não pode ser anterior a Data de Início.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
        header('Location: ../analise.php');
    } else {
        try {
            $db->insert(
                    'tbanalise', [
                'idanalista' => $analise_idanalista,
                'idmodulo' => $analise_idmodulo,
                'idrisco' => $analise_idrisco,
                'situacao' => 'Em Análise',
                'datainicio' => $analise_datainicio,
                'datafim' => $analise_datafim,
                'orcamento' => $analise_orcamento
                    ]
            );

            if ($db->affected()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> O cadastro foi realizado com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                header('Location: ../analise.php');
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Erro!</strong> Falha ao realizar o cadastro.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                header('Location: ../analise.php');
            }
        } catch (Exception $ex) {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro!</strong> Falha ao realizar o cadastro.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
            header('Location: ../analise.php');
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro!</strong> Falha ao realizar o cadastro.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../analise.php');
}
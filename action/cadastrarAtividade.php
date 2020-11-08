<?php

session_start();

require_once("../lib/Database/Connection.php");
require_once("../templates/function.php");

$btnCadastrar = filter_input(INPUT_POST, 'btnCadastrar', FILTER_SANITIZE_STRING);
if (isset($btnCadastrar)) {
    $atividade_objetivo = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'atividade_objetivo', FILTER_SANITIZE_STRING)); //obrigatorio
    $atividade_descricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'atividade_descricao', FILTER_SANITIZE_STRING)); //obrigatorio
    $atividade_dt_inicio = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'atividade_dt_inicio', FILTER_SANITIZE_STRING)); //obrigatorio
    $atividade_dt_final = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'atividade_dt_final', FILTER_SANITIZE_STRING)); //obrigatorio

    $query = "SELECT * FROM tbatividade WHERE objetivo = '$atividade_objetivo' AND descricao = '$atividade_descricao' LIMIT 1";
    $resultado = mysqli_query($conn, $query);
    $row = mysqli_affected_rows($conn);

    if (strtotime($atividade_dt_inicio) > strtotime($atividade_dt_final)) {
        $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro!</strong> Falha ao realizar o cadastro. A Data Final não pode ser anterior a Data de Início.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
        header('Location: ../atividade.php');
    } elseif ($row == 1) {
        $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Falha!</strong> Um cadastro com as mesmas informações já existe. Tente outras informações ou entre em contato com o Administrador!
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
        header('Location: ../atividade.php');
    } else {
        try {
            $db->insert(
                    'tbatividade', [
                'objetivo' => $atividade_objetivo,
                'descricao' => $atividade_descricao,
                'datainicio' => $atividade_dt_inicio,
                'datafim' => $atividade_dt_final
                    ]
            );
            if ($db->affected()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> O cadastro foi realizado com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                header('Location: ../atividade.php');
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Erro!</strong> Falha ao realizar o cadastro.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                header('Location: ../atividade.php');
            }
        } catch (Exception $ex) {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro!</strong> Falha ao realizar o cadastro.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
            header('Location: ../atividade.php');
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro!</strong> Falha ao realizar o cadastro.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../atividade.php');
}
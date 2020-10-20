<?php

session_start();

require_once("../lib/Database/Connection.php");
require_once("../templates/function.php");

$btnCadastrar = filter_input(INPUT_POST, 'btnCadastrar', FILTER_SANITIZE_STRING);
if (isset($btnCadastrar)) {
    $atividade_descricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'atividade_descricao', FILTER_SANITIZE_STRING)); //obrigatorio
    $atividade_objetivo = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'atividade_objetivo', FILTER_SANITIZE_STRING)); //obrigatorio
    $atividade_dt_inicio = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'atividade_dt_inicio', FILTER_SANITIZE_STRING)); //obrigatorio
    $atividade_dt_final = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'atividade_dt_final', FILTER_SANITIZE_STRING)); //obrigatorio

    $query = "SELECT * FROM tbatividade where nome = '$atividade_objetivo' LIMIT 1";
    $resultado = mysqli_query($conn, $query);
    $row = mysqli_affected_rows($conn);

    if ($row == 1) {
        $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Falha!</strong> Um cadastro com o mesmo nome já existe. Tente outro nome ou entre em contato com o Administrador!
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
        header('Location: ../atividade.php');
    } else {
        try {
            $db->insert(
                    'tbatividade', [
                'descricao' => $atividade_descricao,
                'objetivo' => $atividade_objetivo,
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
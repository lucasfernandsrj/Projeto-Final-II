<?php

session_start();

require_once("../lib/Database/Connection.php");

$btnEditar = filter_input(INPUT_POST, 'btnEditar', FILTER_SANITIZE_STRING);
if (isset($btnEditar)) {
    $editar_atividadeidatividade = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_atividadeidatividade', FILTER_SANITIZE_STRING));
    $editar_atividadedescricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_atividadedescricao', FILTER_SANITIZE_STRING)); //obrigatorio
    $editar_atividadeobjetivo = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_atividadeobjetivo', FILTER_SANITIZE_STRING)); //obrigatorio
    $editar_atividadedatainicio = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_atividadedatainicio', FILTER_SANITIZE_STRING)); //obrigatorio
    $editar_atividadedatafim = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_atividadedatafim', FILTER_SANITIZE_STRING)); //obrigatorio
    
    
    try {
        $db->update(
                'tbatividade',
                [
                    'descricao' => $editar_atividadedescricao,
                    'objetivo' => $editar_atividadeobjetivo,
                    'dataInicio' => $editar_atividadedatainicio,
                    'dataFim' => $editar_atividadedatafim
                ],
                [
                    'idatividade' => $editar_atividadeidatividade
                ]
        );

        if ($db->affected()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> A edição foi realizada com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            header('Location: ../atividade.php');
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro 003!</strong> Falha ao realizar a edição. Tente novamente mais tarde.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            header('Location: ../atividade.php');
        }
    } catch (Exception $ex) {
        $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 002!</strong> Falha ao realizar a edição.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
        header('Location: ../atividade.php');
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 001!</strong> Entre em contato com o Administrador do Sistema.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../atividade.php');
}
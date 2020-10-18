<?php

session_start();

require_once("../lib/Database/Connection.php");

$btnEditar = filter_input(INPUT_POST, 'btnEditar', FILTER_SANITIZE_STRING);
if (isset($btnEditar)) {
    $sis_idsistema = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_sis_idsistema', FILTER_SANITIZE_STRING));
    $sis_nome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_sis_nome', FILTER_SANITIZE_STRING)); //obrigatorio
    $sis_descricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_sis_descricao', FILTER_SANITIZE_STRING)); //obrigatorio
    $sis_dt_inicio = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_sis_dataInicio', FILTER_SANITIZE_STRING)); //obrigatorio
    $sis_dt_final = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_sis_dataFim', FILTER_SANITIZE_STRING));


    try {
        if(!empty($sis_dt_final)){
            $db->update(
                'tbsistema',
                [
                    'nome' => $sis_nome,
                    'descricao' => $sis_descricao,
                    'dataInicio' => $sis_dt_inicio,
                    'dataFim' => $sis_dt_final
                ],
                [
                    'idsistema' => $sis_idsistema
                ]
            );
        }else{
          $db->update(
                'tbsistema',
                [
                    'nome' => $sis_nome,
                    'descricao' => $sis_descricao,
                    'dataInicio' => $sis_dt_inicio
                ],
                [
                    'idsistema' => $sis_idsistema
                ]
            );  
        }

        if ($db->affected()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> A edição foi realizada com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            header('Location: ../sistema.php');
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro 003!</strong> Falha ao realizar a edição. Tente novamente mais tarde.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            header('Location: ../sistema.php');
        }
    } catch (Exception $ex) {
        $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 002!</strong> Falha ao realizar a edição.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
        header('Location: ../sistema.php');
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 001!</strong> Entre em contato com o Administrador do Sistema.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../sistema.php');
}
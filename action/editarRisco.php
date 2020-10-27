<?php

session_start();

require_once("../lib/Database/Connection.php");

$btnEditar = filter_input(INPUT_POST, 'btnEditar', FILTER_SANITIZE_STRING);
if (isset($btnEditar)) {
    $risidrisco = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_riscoidrisco', FILTER_SANITIZE_STRING));
    $risnome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_risconome', FILTER_SANITIZE_STRING)); //obrigatorio
    $risdescricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_riscodescricao', FILTER_SANITIZE_STRING)); //obrigatorio
    
    $categoriaidcategoria2 = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_categoriaidcategoria2', FILTER_SANITIZE_STRING)); //obrigatorio
    

    try {
        $db->update(
                'tbrisco',
                [
                    'nome' => $risnome,
                    'descricao' => $risdescricao,
                    'idcategoria' => $categoriaidcategoria2
                ],
                [
                    'idrisco' => $risidrisco
                ]
            );
        if ($db->affected()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> A edição foi realizada com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            header('Location: ../risco.php');
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro 003!</strong> Falha ao realizar a edição. Tente novamente mais tarde.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            header('Location: ../risco.php');
        }
    } catch (Exception $ex) {
        $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 002!</strong> Falha ao realizar a edição.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
        header('Location: ../risco.php');
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 001!</strong> Entre em contato com o Administrador do Sistema.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../risco.php');
}
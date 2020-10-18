<?php

session_start();

require_once("../lib/Database/Connection.php");

$btnEditar = filter_input(INPUT_POST, 'btnEditar', FILTER_SANITIZE_STRING);
if (isset($btnEditar)) {
    $mod_idmodulo = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_mod_idmodulo', FILTER_SANITIZE_STRING));
    $mod_nome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_mod_nome', FILTER_SANITIZE_STRING)); //obrigatorio
    $mod_descricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_mod_descricao', FILTER_SANITIZE_STRING)); //obrigatorio
    $mod_ambiente = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_mod_ambiente', FILTER_SANITIZE_STRING)); //obrigatorio


    try {
        $db->update(
                'tbmodulo',
                [
                    'nome' => $mod_nome,
                    'descricao' => $mod_descricao,
                    'ambiente' => $mod_ambiente
                ],
                [
                    'idmodulo' => $mod_idmodulo
                ]
            );

        if ($db->affected()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> A edição foi realizada com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            header('Location: ../modulo.php');
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro 003!</strong> Falha ao realizar a edição. Tente novamente mais tarde.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            header('Location: ../modulo.php');
        }
    } catch (Exception $ex) {
        $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 002!</strong> Falha ao realizar a edição.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
        header('Location: ../modulo.php');
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 001!</strong> Entre em contato com o Administrador do Sistema.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../modulo.php');
}
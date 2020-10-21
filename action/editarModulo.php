<?php

session_start();

require_once("../lib/Database/Connection.php");

$btnEditar = filter_input(INPUT_POST, 'btnEditar', FILTER_SANITIZE_STRING);
if (isset($btnEditar)) {
    $moduloidmodulo = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_moduloidmodulo', FILTER_SANITIZE_STRING));
    $modulonome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_modulonome', FILTER_SANITIZE_STRING)); //obrigatorio
    $modulodescricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_modulodescricao', FILTER_SANITIZE_STRING)); //obrigatorio
    $moduloambiente = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_moduloambiente', FILTER_SANITIZE_STRING)); //obrigatorio


    try {
        $db->update(
                'tbmodulo',
                [
                    'nome' => $modulonome,
                    'descricao' => $modulodescricao,
                    'ambiente' => $moduloambiente
                ],
                [
                    'idmodulo' => $moduloidmodulo
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
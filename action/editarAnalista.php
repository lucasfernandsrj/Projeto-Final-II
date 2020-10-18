<?php

session_start();

require_once("../lib/Database/Connection.php");

$btnEditar = filter_input(INPUT_POST, 'btnEditar', FILTER_SANITIZE_STRING);
if (isset($btnEditar)) {
    $analistaidanalista = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_analistaidanalista', FILTER_SANITIZE_STRING));
    $analistanome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_analistanome', FILTER_SANITIZE_STRING)); //obrigatorio
    $analistaemail = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_analistaemail', FILTER_SANITIZE_STRING)); //obrigatorio
    $analistacpf = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_analistacpf', FILTER_SANITIZE_STRING)); //obrigatorio


    try {
        $db->update(
                'tbanalista',
                [
                    'nome' => $analistanome,
                    'email' => $analistaemail,
                    'cpf' => $analistacpf
                ],
                [
                    'idanalista' => $analistaidanalista
                ]
            );

        if ($db->affected()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> A edição foi realizada com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            header('Location: ../analista.php');
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro 003!</strong> Falha ao realizar a edição. Tente novamente mais tarde.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            header('Location: ../analista.php');
        }
    } catch (Exception $ex) {
        $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 002!</strong> Falha ao realizar a edição.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
        header('Location: ../analista.php');
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 001!</strong> Entre em contato com o Administrador do Sistema.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../analista.php');
}
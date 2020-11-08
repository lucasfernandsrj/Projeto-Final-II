<?php

session_start();

require_once("../lib/Database/Connection.php");

$btnEditar = filter_input(INPUT_POST, 'btnEditar', FILTER_SANITIZE_STRING);
if (isset($btnEditar)) {
    $sistemaidsistema = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_sistemaidsistema', FILTER_SANITIZE_STRING));
    $sistemanome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_sistemanome', FILTER_SANITIZE_STRING)); //obrigatorio
    $sistemadescricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_sistemadescricao', FILTER_SANITIZE_STRING)); //obrigatorio
    
    $sistemadatainicio = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_sistemadatainicio', FILTER_SANITIZE_STRING)); //obrigatorio
    $sistemadatafim = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_sistemadatafim', FILTER_SANITIZE_STRING));
    
    if (strtotime($sistemadatainicio) > strtotime($sistemadatafim)) {
        $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro 003!</strong> Falha ao realizar a alteração. A Data Final não pode ser anterior a Data Inicial.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
        header('Location: ../sistema.php');
    } else {
        try {
            if (!empty($sistemadatafim)) {
                $db->update(
                        'tbsistema',
                        [
                            'nome' => $sistemanome,
                            'descricao' => $sistemadescricao,
                            'datainicio' => $sistemadatainicio,
                            'datafim' => $sistemadatafim
                        ],
                        [
                            'idsistema' => $sistemaidsistema
                        ]
                );
            } else {
                $db->update(
                        'tbsistema',
                        [
                            'nome' => $sistemanome,
                            'descricao' => $sistemadescricao,
                            'datainicio' => $sistemadatainicio
                        ],
                        [
                            'idsistema' => $sistemaidsistema
                        ]
                );
            }

            if ($db->affected()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Alterado!</strong> A edição foi realizada com sucesso.
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
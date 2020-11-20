<?php

session_start();
require_once("../lib/Database/Connection.php");
require_once("../mailer_contato.php");

$btnContact = filter_input(INPUT_POST, 'btnContact', FILTER_SANITIZE_STRING);

if (isset($btnContact)) {
    $nome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING)); //obrigatorio
    $email = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)); //obrigatorio
    $assunto = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'assunto', FILTER_SANITIZE_STRING)); //obrigatorio
    $mensagem = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING)); //obrigatorio


    $resultado = enviar_email($email, $nome, $assunto, $mensagem);

    if ($resultado) {
        $_SESSION['msgcontato'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> A mensagem foi enviada com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
        header('Location: ../contato.php');
    } else {
        $_SESSION['msgcontato'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Erro!</strong> Falha ao realizar o envio da mensagem.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
        header('Location: ../contato.php');
    }
} else {
    $_SESSION['msgcontato'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro!</strong> Falha ao realizar o envio.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../contato.php');
}
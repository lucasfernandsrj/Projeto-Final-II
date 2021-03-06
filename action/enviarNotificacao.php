<?php

session_start();
require_once("../lib/Database/Connection.php");
require_once("../mailer.php");

$btnEmail = filter_input(INPUT_POST, 'btnEmail', FILTER_SANITIZE_STRING);

if (isset($btnEmail)) {
    try {

        $nome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'analistanome', FILTER_SANITIZE_STRING)); //obrigatorio
        $nome_split = preg_split('/ /',$nome, -1,PREG_SPLIT_NO_EMPTY);
        $email = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'analistaemail', FILTER_SANITIZE_EMAIL)); //obrigatorio
        $risconome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'risconome', FILTER_SANITIZE_STRING)); //obrigatorio
        
        $analisedatainicio = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'analisedatainicio', FILTER_SANITIZE_STRING)); //obrigatorio
        $analisedatafim = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'analisedatafim', FILTER_SANITIZE_STRING)); //obrigatorio
        $dt_atual = date("Y-m-d");
        $assunto = 'Analista, uma nova Análise de Risco foi atribuída a você.';
        $mensagem = 'Prezado(a) ' . $nome_split[0] . ',<p><br>
Estamos entrando em contato no dia ' . $dt_atual . ' para informar que a Análise do Risco "' . $risconome . '" foi atribuída a você!
<p>Data de Início da Análise: '.$analisedatainicio.'<p> Prazo Final: '.$analisedatafim.';
<p><br>
Att,<p>
Equipe de Notificação<p>
Gerenciamento de Risco 2020';

        $resultado = enviar_email($email, $assunto, $mensagem);

        if ($resultado) {
            $_SESSION['msgs'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> A mensagem foi enviada com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            header('Location: ../analise.php');
        } else {
            $_SESSION['msgs'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Erro!</strong> Falha ao realizar o envio da mensagem.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            header('Location: ../analise.php');
        }
    } catch (Exception $ex) {
        $_SESSION['msgs'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Erro!</strong> Falha ao realizar o envio da mensagem.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
        header('Location: ../analise.php');
    }
} else {
    $_SESSION['msgs'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro!</strong> Falha ao realizar o envio.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../analise.php');
}
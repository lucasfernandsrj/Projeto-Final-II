<?php

session_start();

require_once("../lib/Database/Connection.php");

$btnEditar = filter_input(INPUT_POST, 'btnEditar', FILTER_SANITIZE_STRING);
if (isset($btnEditar)) {
    $analiseidanalise = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_analiseidanalise', FILTER_SANITIZE_STRING));
    
    $analiseprobabilidade = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_analiseprobabilidade', FILTER_SANITIZE_STRING));
    $analiseimpacto = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_analiseimpacto', FILTER_SANITIZE_STRING)); //obrigatorio
    $analisemedidadorisco = $analiseprobabilidade * $analiseimpacto;
    $analisemedidadorisco_format = strval(number_format($analisemedidadorisco, 2));

    try {
        $db->update(
                'tbanalise',
                [
                    'probabilidade' => $analiseprobabilidade,
                    'impacto' => $analiseimpacto,
                    'medidadorisco' => $analisemedidadorisco_format
                ],
                [
                    'idanalise' => $analiseidanalise
                ]
            );

        if ($db->affected()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> A edição foi realizada com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            header('Location: ../analise2.php');
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro 003!</strong> Falha ao realizar a edição. Tente novamente mais tarde.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            header('Location: ../analise2.php');
        }
    } catch (Exception $ex) {
        $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 002!</strong> Falha ao realizar a edição.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
        header('Location: ../analise2.php');
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 001!</strong> Entre em contato com o Administrador do Sistema.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../analise2.php');
}
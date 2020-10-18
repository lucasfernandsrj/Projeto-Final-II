<?php
session_start();

require_once("../lib/Database/Connection.php");

$btnCadastrar = filter_input(INPUT_POST, 'btnCadastrar', FILTER_SANITIZE_STRING);
if (isset($btnCadastrar)) {
    $risnome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'risnome', FILTER_SANITIZE_STRING)); //obrigatorio
    $risdescricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'risdescricao', FILTER_SANITIZE_STRING)); //obrigatorio
    $catidcategoria1 = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'catidcategoria1', FILTER_SANITIZE_STRING)); //obrigatorio
    $catidcategoria2 = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'catidcategoria2', FILTER_SANITIZE_STRING)); //obrigatorio

    $query = "SELECT * FROM tbrisco where nome = '$risnome' LIMIT 1";
    $resultado = mysqli_query($conn, $query);
    $row = mysqli_affected_rows($conn);
    
    if($row == 1){
        $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Falha!</strong> Um cadastro com o mesmo nome já existe. Tente outro nome ou entre em contato com o Administrador!
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
        header('Location: ../risco.php');
    }else{
        try {
            $db->insert(
                'tbrisco', [
                    'nome' => $risnome,
                    'descricao' => $risdescricao,
                    'idcategoria' => $catidcategoria2
                        ]
                );
            if ($db->affected()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> O cadastro foi realizado com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                header('Location: ../risco.php');
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Erro!</strong> Falha ao realizar o cadastro.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                header('Location: ../risco.php');
            }
        } catch (Exception $ex) {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro!</strong> Falha ao realizar o cadastro.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
            header('Location: ../risco.php');
        }
    }
}else{
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro!</strong> Falha ao realizar o cadastro.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../risco.php');
}
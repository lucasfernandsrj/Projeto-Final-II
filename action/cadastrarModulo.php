<?php
session_start();

require_once("../lib/Database/Connection.php");

$btnCadastrar = filter_input(INPUT_POST, 'btnCadastrar', FILTER_SANITIZE_STRING);
if (isset($btnCadastrar)) {
    $modulonome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'modulonome', FILTER_SANITIZE_STRING)); //obrigatorio
    $modulodescricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'modulodescricao', FILTER_SANITIZE_STRING)); //obrigatorio
    $moduloambiente = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'moduloambiente', FILTER_SANITIZE_STRING)); //obrigatorio
    
    $moduloidsistema = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'moduloidsistema', FILTER_SANITIZE_STRING)); //obrigatorio

    $query = "SELECT * FROM tbmodulo where nome = '$modulonome' LIMIT 1";
    $resultado = mysqli_query($conn, $query);
    $row = mysqli_affected_rows($conn);
    
    if($row == 1){
        $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Falha!</strong> Um cadastro com o mesmo nome já existe. Tente outro nome ou entre em contato com o Administrador!
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
        header('Location: ../modulo.php');
    }else{
        try {
            $db->insert(
                'tbmodulo', [
                    'nome' => $modulonome,
                    'descricao' => $modulodescricao,
                    'ambiente' => $moduloambiente,
                    'idsistema' => $moduloidsistema,
                    'nivel' => 1
                        ]
                );
            if ($db->affected()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> O cadastro foi realizado com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                header('Location: ../modulo.php');
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Erro!</strong> Falha ao realizar o cadastro.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                header('Location: ../modulo.php');
            }
        } catch (Exception $ex) {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro!</strong> Falha ao realizar o cadastro.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
            header('Location: ../modulo.php');
        }
    }
}else{
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro!</strong> Falha ao realizar o cadastro.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../modulo.php');
}
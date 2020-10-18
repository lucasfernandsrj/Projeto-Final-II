<?php
session_start();

require_once("../lib/Database/Connection.php");

$btnCadastrar = filter_input(INPUT_POST, 'btnCadastrar', FILTER_SANITIZE_STRING);
if (isset($btnCadastrar)) {
    $mod_nome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'mod_nome', FILTER_SANITIZE_STRING)); //obrigatorio
    $mod_descricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'mod_descricao', FILTER_SANITIZE_STRING)); //obrigatorio
    $mod_ambiente = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'mod_ambiente', FILTER_SANITIZE_STRING)); //obrigatorio
    
    $mod_idsistema = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'mod_idsistema', FILTER_SANITIZE_STRING)); //obrigatorio

    $query = "SELECT * FROM tbmodulo where nome = '$mod_nome' LIMIT 1";
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
                    'nome' => $mod_nome,
                    'descricao' => $mod_descricao,
                    'ambiente' => $mod_ambiente,
                    'idsistema' => $mod_idsistema
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
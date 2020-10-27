<?php
session_start();

require_once("../lib/Database/Connection.php");

$btnCadastrar = filter_input(INPUT_POST, 'btnCadastrar', FILTER_SANITIZE_STRING);
if (isset($btnCadastrar)) {
    $sistema_nome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'sistema_nome', FILTER_SANITIZE_STRING)); //obrigatorio
    $sistema_descricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'sistema_descricao', FILTER_SANITIZE_STRING)); //obrigatorio
    $sistema_dt_inicio = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'sistema_dt_inicio', FILTER_SANITIZE_STRING)); //obrigatorio
    $sistema_dt_final = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'sistema_dt_final', FILTER_SANITIZE_STRING));

    $query = "SELECT * FROM tbsistema where nome = '$sistema_nome' LIMIT 1";
    $resultado = mysqli_query($conn, $query);
    $row = mysqli_affected_rows($conn);
    
    if($row == 1){
        $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Falha!</strong> Um cadastro com o mesmo nome já existe. Tente outro nome ou entre em contato com o Administrador!
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
        header('Location: ../sistema.php');
    }else if(strtotime($sistema_dt_inicio) > strtotime($sistema_dt_final) ){
        $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro!</strong> Falha ao realizar o cadastro. A Data Final não pode ser anterior a Data de Início.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                header('Location: ../sistema.php');
    }else{
        try {
            $db->insert(
                'tbsistema', [
                    'nome' => $sistema_nome,
                    'descricao' => $sistema_descricao,
                    'dataInicio' => $sistema_dt_inicio,
                    'dataFim' => $sistema_dt_final
                        ]
                );
            
            if ($db->affected()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> O cadastro foi realizado com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                header('Location: ../sistema.php');
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Erro!</strong> Falha ao realizar o cadastro.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                header('Location: ../sistema.php');
            }
        } catch (Exception $ex) {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro!</strong> Falha ao realizar o cadastro.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
            header('Location: ../sistema.php');
        }
    }
}else{
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro!</strong> Falha ao realizar o cadastro.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../sistema.php');
}
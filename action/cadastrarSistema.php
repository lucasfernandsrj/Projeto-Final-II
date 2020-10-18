<?php
session_start();

require_once("../lib/Database/Connection.php");

$btnCadastrar = filter_input(INPUT_POST, 'btnCadastrar', FILTER_SANITIZE_STRING);
if (isset($btnCadastrar)) {
    $sis_nome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'sis_nome', FILTER_SANITIZE_STRING)); //obrigatorio
    $sis_descricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'sis_descricao', FILTER_SANITIZE_STRING)); //obrigatorio
    $sis_dt_inicio = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'sis_dt_inicio', FILTER_SANITIZE_STRING)); //obrigatorio
    $sis_dt_final = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'sis_dt_final', FILTER_SANITIZE_STRING));
    
    $mod_nome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'mod_nome', FILTER_SANITIZE_STRING)); //obrigatorio
    $mod_descricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'mod_descricao', FILTER_SANITIZE_STRING)); //obrigatorio
    $mod_ambiente = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'mod_ambiente', FILTER_SANITIZE_STRING)); //obrigatorio

    $query = "SELECT * FROM tbsistema where nome = '$sis_nome' LIMIT 1";
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
    }else{
        try {
            $db->insert(
                'tbsistema', [
                    'nome' => $sis_nome,
                    'descricao' => $sis_descricao,
                    'dataInicio' => $sis_dt_inicio,
                    'dataFim' => $sis_dt_final
                        ]
                );
            
            $query2 = "SELECT idsistema FROM tbsistema where nome = '$sis_nome' LIMIT 1";
            $result2 = mysqli_query($conn, $query2);
            $row2 = mysqli_fetch_assoc($result2);
            $bd_idsistema = $row2['idsistema'];
            
            $db->insert(
                'tbmodulo', [
                    'nome' => $mod_nome,
                    'descricao' => $mod_descricao,
                    'ambiente' => $mod_ambiente,
                    'idsistema' => $bd_idsistema
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
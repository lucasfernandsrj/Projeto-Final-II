<?php

session_start();

require_once("../lib/Database/Connection.php");

$btnEditar = filter_input(INPUT_POST, 'btnEditar', FILTER_SANITIZE_STRING);
if (isset($btnEditar)) {
    $moduloidmodulo = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_moduloidmodulo', FILTER_SANITIZE_STRING));
    
    $modulonome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_modulonome', FILTER_SANITIZE_STRING)); //obrigatorio
    $modulodescricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_modulodescricao', FILTER_SANITIZE_STRING)); //obrigatorio
    $moduloambiente = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_moduloambiente', FILTER_SANITIZE_STRING)); //obrigatorio
    
    $modulofkidmodulo = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_modulofkidmodulo', FILTER_SANITIZE_STRING)); //obrigatorio
    
    $query = "SELECT * FROM tbmodulo WHERE nome = '$modulonome' AND fk_idmodulo = '$modulofkidmodulo' AND idmodulo!='$moduloidmodulo' LIMIT 1";
    $resultado = mysqli_query($conn, $query);
    $row = mysqli_affected_rows($conn);
    
    $query2 = "SELECT * FROM tbmodulo WHERE idmodulo='$modulofkidmodulo' LIMIT 1";
    $resultado2 = mysqli_query($conn, $query2);
    $row2 = mysqli_affected_rows($conn);
    
    if ($row == 1 || $row2 == 1) {
        $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Falha!</strong> Um vínculo com o mesmo nome já existe. Tente outro nome ou entre em contato com o Administrador!
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
        header('Location: ../modulo.php');
    } else {
        $query_fk = "SELECT nivel,ambiente FROM tbmodulo WHERE idmodulo = '$modulofkidmodulo' LIMIT 1";
        $resultado_fk = mysqli_query($conn, $query_fk);
        $row_fk = mysqli_fetch_row($resultado_fk);
        
        $fk_nivel = $row_fk[0];
        $fk_ambiente = $row_fk[1];
        $novo_nivel = intval($fk_nivel) + 1;
        
        try {
            $db->update(
                    'tbmodulo',
                    [
                        'nome' => $modulonome,
                        'descricao' => $modulodescricao,
                        'ambiente' => $moduloambiente,
                        'fk_idmodulo' => $modulofkidmodulo,
                        'nivel' => $novo_nivel
                    ],
                    [
                        'idmodulo' => $moduloidmodulo
                    ]
            );

            if ($db->affected()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> A edição foi realizada com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                header('Location: ../modulo.php');
            } else {
                $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro 003!</strong> Falha ao realizar a edição. Tente novamente mais tarde.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                header('Location: ../modulo.php');
            }
        } catch (Exception $ex) {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 002!</strong> Falha ao realizar a edição.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
            header('Location: ../modulo.php');
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 001!</strong> Entre em contato com o Administrador do Sistema.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../modulo.php');
}
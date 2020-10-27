<?php

session_start();

require_once("../lib/Database/Connection.php");

$btnCadastrar = filter_input(INPUT_POST, 'btnCadastrar', FILTER_SANITIZE_STRING);
if (isset($btnCadastrar)) {
    $modulonome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'modulonome', FILTER_SANITIZE_STRING)); //obrigatorio
    $modulodescricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'modulodescricao', FILTER_SANITIZE_STRING)); //obrigatorio

    $modulofk_idmodulo = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'modulofk_idmodulo', FILTER_SANITIZE_STRING)); //obrigatorio

    $query = "SELECT * FROM tbmodulo WHERE nome = '$modulonome' AND fk_idmodulo = '$modulofk_idmodulo' LIMIT 1";
    $resultado = mysqli_query($conn, $query);
    $row = mysqli_affected_rows($conn);

    if ($row == 1) {
        $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Falha!</strong> Um vínculo com o mesmo nome já existe. Tente outro nome ou entre em contato com o Administrador!
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
        header('Location: ../modulo.php');
    } else {

        $query_fk = "SELECT nivel,ambiente FROM tbmodulo WHERE idmodulo = '$modulofk_idmodulo' LIMIT 1";
        $resultado_fk = mysqli_query($conn, $query_fk);
        $row_fk = mysqli_fetch_row($resultado_fk);
        
        $fk_nivel = $row_fk[0];
        $fk_ambiente = $row_fk[1];
        $novo_nivel = intval($fk_nivel) + 1;

        try {
            $db->insert(
                    'tbmodulo', [
                'nome' => $modulonome,
                'descricao' => $modulodescricao,
                'fk_idmodulo' => $modulofk_idmodulo,
                'nivel' => $novo_nivel,
                'ambiente' => $fk_ambiente
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
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro!</strong> Falha ao realizar o cadastro.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../modulo.php');
}
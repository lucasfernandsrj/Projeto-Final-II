<?php

session_start();

require_once("../lib/Database/Connection.php");

$btnCadastrar = filter_input(INPUT_POST, 'btnCadastrar', FILTER_SANITIZE_STRING);
if (isset($btnCadastrar)) {
    $resposta_nome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'resposta_nome', FILTER_SANITIZE_STRING)); //obrigatorio
    $resposta_descricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'resposta_descricao', FILTER_SANITIZE_STRING)); //obrigatorio
    $resposta_situacao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'resposta_situacao', FILTER_SANITIZE_STRING)); //obrigatorio

    $resposta_idanalise = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'resposta_idanalise', FILTER_SANITIZE_STRING)); //obrigatorio
    $resposta_idatividade = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'resposta_idatividade', FILTER_SANITIZE_STRING));

    $query = "SELECT * FROM tbresposta WHERE nome = '$resposta_nome' AND idanalise = '$resposta_idanalise' LIMIT 1";
    $resultado = mysqli_query($conn, $query);
    $row = mysqli_affected_rows($conn);

    if ($row == 1) {
        $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Falha!</strong> Um cadastro com o mesmo nome já existe para esse risco. Tente outro nome para a resposta ou entre em contato com o Administrador!
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
        header('Location: ../resposta.php');
    } else {
        if ($resposta_situacao == 'Aceito') {
            if ($resposta_idatividade == "") {
                try {
                    $db->insert(
                            'tbresposta', [
                        'nome' => $resposta_nome,
                        'descricao' => $resposta_descricao,
                        'situacao' => $resposta_situacao,
                        'idanalise' => $resposta_idanalise
                            ]
                    );
                    if ($db->affected()) {
                        $db->update(
                                'tbanalise',
                                [
                                    'situacao' => 'Bloqueada'
                                ],
                                [
                                    'idanalise' => $resposta_idanalise
                                ]
                        );
                        $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> O cadastro foi realizado com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                        header('Location: ../resposta.php');
                    } else {
                        $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Erro 003!</strong> Falha ao realizar o cadastro.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                        header('Location: ../resposta.php');
                    }
                } catch (Exception $ex) {
                    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 002!</strong> Falha ao realizar a edição.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
                    header('Location: ../resposta.php');
                }
            } else {
                try {
                    $db->insert(
                            'tbresposta', [
                        'nome' => $resposta_nome,
                        'descricao' => $resposta_descricao,
                        'situacao' => $resposta_situacao,
                        'idanalise' => $resposta_idanalise,
                        'idatividade' => $resposta_idatividade
                            ]
                    );
                    if ($db->affected()) {
                        $db->update(
                                'tbanalise',
                                [
                                    'situacao' => 'Bloqueada'
                                ],
                                [
                                    'idanalise' => $resposta_idanalise
                                ]
                        );
                        $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> O cadastro foi realizado com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                        header('Location: ../resposta.php');
                    } else {
                        $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Erro 003!</strong> Falha ao realizar o cadastro.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                </div>";
                        header('Location: ../resposta.php');
                    }
                } catch (Exception $ex) {
                    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 002!</strong> Falha ao realizar a edição.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
                    header('Location: ../resposta.php');
                }
            }
        } else {
            try {
                $db->insert(
                        'tbresposta', [
                    'nome' => $resposta_nome,
                    'descricao' => $resposta_descricao,
                    'situacao' => $resposta_situacao,
                    'idanalise' => $resposta_idanalise,
                    'idatividade' => $resposta_idatividade
                        ]
                );
                if ($db->affected()) {
                    $db->update(
                            'tbanalise',
                            [
                                'situacao' => 'Bloqueada'
                            ],
                            [
                                'idanalise' => $resposta_idanalise
                            ]
                    );
                    $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Adicionado!</strong> O cadastro foi realizado com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                    header('Location: ../resposta.php');
                } else {
                    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Erro 003!</strong> Falha ao realizar o cadastro.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                </div>";
                    header('Location: ../resposta.php');
                }
            } catch (Exception $ex) {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 002!</strong> Falha ao realizar a edição.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
                header('Location: ../resposta.php');
            }
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 001!</strong> Falha ao realizar o cadastro.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../resposta.php');
}
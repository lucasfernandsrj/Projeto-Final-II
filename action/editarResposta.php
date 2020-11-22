<?php

session_start();

require_once("../lib/Database/Connection.php");

$btnEditar = filter_input(INPUT_POST, 'btnEditar', FILTER_SANITIZE_STRING);
if (isset($btnEditar)) {
    $respostaidresposta = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_respostaidresposta', FILTER_SANITIZE_STRING));
    $respostaidanalise = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_respostaidanalise', FILTER_SANITIZE_STRING));

    $respostanome = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_respostanome', FILTER_SANITIZE_STRING)); //obrigatorio
    $respostadescricao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_respostadescricao', FILTER_SANITIZE_STRING)); //obrigatorio
    $respostaidatividade = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_respostaidatividade', FILTER_SANITIZE_STRING)); //obrigatorio
    $respostasituacao2 = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_respostasituacao2', FILTER_SANITIZE_STRING)); //obrigatorio
    $respostasituacao = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'editar_respostasituacao', FILTER_SANITIZE_STRING)); //obrigatorio
    if ($respostasituacao2 == 'Aceito') {
        $situacao = $respostasituacao2;
        if ($respostaidatividade !== '') {
            try {
                $db->update(
                        'tbresposta',
                        [
                            'nome' => $respostanome,
                            'descricao' => $respostadescricao,
                            'situacao' => $situacao,
                            'idatividade' => $respostaidatividade
                        ],
                        [
                            'idresposta' => $respostaidresposta
                        ]
                );

                if ($db->affected()) {
                    $db->update(
                            'tbanalise',
                            [
                                'situacao' => 'Bloqueada'
                            ],
                            [
                                'idanalise' => $respostaidanalise
                            ]
                    );
                    $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Alterado!</strong> A edição foi realizada com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                    header('Location: ../resposta.php');
                } else {
                    $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro 003!</strong> Falha ao realizar a edição. Tente novamente mais tarde.
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
                $db->update(
                        'tbresposta',
                        [
                            'nome' => $respostanome,
                            'descricao' => $respostadescricao,
                            'situacao' => $situacao,
                            'idatividade' => NULL
                        ],
                        [
                            'idresposta' => $respostaidresposta
                        ]
                );
                if ($db->affected()) {
                    $db->update(
                            'tbanalise',
                            [
                                'situacao' => 'Bloqueada'
                            ],
                            [
                                'idanalise' => $respostaidanalise
                            ]
                    );
                    $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Alterado!</strong> A edição foi realizada com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                    </div>";
                    header('Location: ../resposta.php');
                } else {
                    $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro 003!</strong> Falha ao realizar a edição. Tente novamente mais tarde.
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
        }
    } else {
        $situacao = $respostasituacao;
        try {
            $db->update(
                    'tbresposta',
                    [
                        'nome' => $respostanome,
                        'descricao' => $respostadescricao,
                        'situacao' => $situacao,
                        'idatividade' => $respostaidatividade
                    ],
                    [
                        'idresposta' => $respostaidresposta
                    ]
            );

            if ($db->affected()) {
                $db->update(
                        'tbanalise',
                        [
                            'situacao' => 'Bloqueada'
                        ],
                        [
                            'idanalise' => $respostaidanalise
                        ]
                );
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Alterado!</strong> A edição foi realizada com sucesso.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
                header('Location: ../resposta.php');
            } else {
                $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro 003!</strong> Falha ao realizar a edição. Tente novamente mais tarde.
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
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Erro 001!</strong> Entre em contato com o Administrador do Sistema.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
    header('Location: ../resposta.php');
}
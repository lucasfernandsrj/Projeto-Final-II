<?php

require_once("../lib/Database/Connection.php");
$idanalise = $_REQUEST['idanalise'];
//$idcategoria = filter_input(INPUT_REQUEST, 'idcategoria', FILTER_SANITIZE_STRING);
$query_resposta = "SELECT 
    tbresposta.*,
    tbatividade.objetivo AS atividade_objetivo,
    tbatividade.descricao AS atividade_descricao,
    tbatividade.dataInicio AS atividade_datainicio,
    tbatividade.dataFim AS atividade_datafim
FROM
    tbresposta
        LEFT JOIN
    tbatividade ON tbatividade.idatividade = tbresposta.idatividade
WHERE
    idanalise = $idanalise";
$result_resposta = mysqli_query($conn, $query_resposta);
$array_resposta = [];
while ($row_resposta = mysqli_fetch_assoc($result_resposta)) {
    $array_resposta[] = array(
        'respostanome' => $row_resposta['nome'],
        'respostadescricao' => $row_resposta['descricao'],
        'respostasituacao' => $row_resposta['situacao'],
        'atividadeobjetivo' => $row_resposta['atividade_objetivo'],
        'atividadedescricao' => $row_resposta['atividade_descricao'],
        'atividadedatainicio' => $row_resposta['atividade_datainicio'],
        'atividadedatafim' => $row_resposta['atividade_datafim'],
    );
}
if(empty($array_resposta)){
    echo(json_encode($array_resposta));
}else{
    echo(json_encode($array_resposta));
}


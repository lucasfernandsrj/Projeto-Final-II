<?php

require_once("../lib/Database/Connection.php");
$idanalise = $_REQUEST['idanalise'];
//$idcategoria = filter_input(INPUT_REQUEST, 'idcategoria', FILTER_SANITIZE_STRING);
$query_resposta = "SELECT 
            medidadorisco 
        FROM 
            tbanalise
        WHERE 
            idanalise=$idanalise";
$result_resposta = mysqli_query($conn, $query_resposta);
$array_resposta = [];
while ($row_resposta = mysqli_fetch_assoc($result_resposta)) {
    if ($row_resposta['medidadorisco'] < 0.08) {
        $array_resposta[] = array(
            'riscobaixo' => 1
        );
    } else {
        $array_resposta[] = array(
            'riscobaixo' => 0
        );
    }
}
echo(json_encode($array_resposta));

<?php
require_once("../lib/Database/Connection.php");
$idsistema = $_REQUEST['idsistema'];
//$idcategoria = filter_input(INPUT_REQUEST, 'idcategoria', FILTER_SANITIZE_STRING);
$query_categoria2 = "SELECT 
            * 
        FROM 
            tbsistema
        WHERE 
            idsistema=$idsistema
        ;";
$result_categoria2 = mysqli_query($conn, $query_categoria2);
$array_categoria2 = [];
while ($row_categoria2 = mysqli_fetch_assoc($result_categoria2)) {
    $array_categoria2[] = array(
        'idcategoria' => $row_categoria2['idcategoria'],
        'nome' => $row_categoria2['nome']
    );
}
echo(json_encode($array_categoria2));

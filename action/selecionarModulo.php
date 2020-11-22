<?php
require_once("../lib/Database/Connection.php");
$idsistema = $_REQUEST['idsistema'];
$query_modulo = 
        "SELECT 
            idmodulo, nome, descricao 
        FROM 
            tbmodulo
        WHERE 
            idsistema=$idsistema";
$result_modulo = mysqli_query($conn, $query_modulo);
$array_modulo = [];
while ($row_modulo = mysqli_fetch_assoc($result_modulo)) {
    $array_modulo[] = array(
        'idmodulo' => $row_modulo['idmodulo'],
        'nome' => $row_modulo['nome']
    );
}
echo(json_encode($array_modulo));

<?php
require_once("../lib/Database/Connection.php");
$idrisco = $_REQUEST['editar_analiseidrisco'];
//$idcategoria = filter_input(INPUT_REQUEST, 'idcategoria', FILTER_SANITIZE_STRING);
$query = "SELECT 
            idrisco, nome 
        FROM 
            tbrisco
        WHERE 
            idrisco=$idrisco 
        OR
            idrisco NOT IN (SELECT idrisco FROM tbanalise)";
$result = mysqli_query($conn, $query);
$array_risco = [];
while ($row = mysqli_fetch_assoc($result)) {
        $array_risco[] = array(
            'idrisco' => $row['idrisco'],
            'nome' => $row['nome']
        );
}
echo(json_encode($array_risco));

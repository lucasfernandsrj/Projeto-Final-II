<?php
require_once("../lib/Database/Connection.php");
$nivel = $_REQUEST['nivel'];
$query_modulo = 
        "SELECT 
    tbsistema.nome AS sistema_nome,
    tbmodulo.idmodulo,
    tbmodulo.nome AS modulo_nome
FROM
    tbmodulo
        LEFT JOIN
    tbsistema ON tbsistema.idsistema = tbmodulo.idsistema
WHERE
    nivel = $nivel
ORDER BY sistema_nome ASC;";
$result_modulo = mysqli_query($conn, $query_modulo);
$array_modulo = [];
while ($row_modulo = mysqli_fetch_assoc($result_modulo)) {
    $array_modulo[] = array(
        'idmodulo' => $row_modulo['idmodulo'],
        'modulonome' => $row_modulo['modulo_nome'],
        'sistemanome' => $row_modulo['sistema_nome']
    );
}
echo(json_encode($array_modulo));

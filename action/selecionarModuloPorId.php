<?php

require_once("../lib/Database/Connection.php");
$idmodulo = $_REQUEST['idmodulo'];
$query_modulo = "SELECT 
    tbmodulo.idmodulo,
    tbmodulo.nome AS modulo_nome,
    tbmodulo.descricao modulo_descricao,
    tbmodulo.ambiente AS modulo_ambiente,
    tbmodulo.nivel AS modulo_nivel,
    tbmodulo.fk_idmodulo AS modulo_fk_idmodulo
FROM
    tbmodulo
WHERE
    idmodulo = $idmodulo LIMIT 1";
$result_modulo = mysqli_query($conn, $query_modulo);
$array_modulo = [];
while ($row_modulo = mysqli_fetch_assoc($result_modulo)) {
    $array_modulo[] = array(
        'idmodulo' => $row_modulo['idmodulo'],
        'nome' => $row_modulo['modulo_nome'],
        'descricao' => $row_modulo['modulo_descricao'],
        'ambiente' => $row_modulo['modulo_ambiente'],
        'nivel' => $row_modulo['modulo_nivel']
    );
    if ($row_modulo['modulo_nivel'] == 2 && $row_modulo['modulo_fk_idmodulo'] != '') {
        $fk_idmodulo = $row_modulo['modulo_fk_idmodulo'];
        $query_modulo = "SELECT 
    tbmodulo.idmodulo,
    tbmodulo.nome AS modulo_nome,
    tbmodulo.descricao modulo_descricao,
    tbmodulo.ambiente AS modulo_ambiente,
    tbmodulo.nivel AS modulo_nivel,
    tbmodulo.fk_idmodulo AS modulo_fk_idmodulo
FROM
    tbmodulo
WHERE
    idmodulo = $fk_idmodulo LIMIT 1";
        $result_modulo2 = mysqli_query($conn, $query_modulo);
        $array_modulo = [];
        while ($row_modulo2 = mysqli_fetch_assoc($result_modulo2)) {
            $array_modulo[] = array(
                'idmodulo' => $row_modulo2['idmodulo'],
                'nome' => $row_modulo2['modulo_nome'],
                'descricao' => $row_modulo2['modulo_descricao'],
                'ambiente' => $row_modulo2['modulo_ambiente'],
                'nivel' => $row_modulo2['modulo_nivel']
            );
        }
    }
}
echo(json_encode($array_modulo));

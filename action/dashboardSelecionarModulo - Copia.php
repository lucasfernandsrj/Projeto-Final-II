<?php

require_once("../lib/Database/Connection.php");
$idsistema = $_REQUEST['idsistema'];
$query_modulo1 = "SELECT 
    idmodulo, nome, nivel
FROM
    projetofinal2.tbmodulo
WHERE
    idsistema = $idsistema;";
$result_modulo1 = mysqli_query($conn, $query_modulo1);
$array_modulo1 = [];
while ($row_modulo1 = mysqli_fetch_assoc($result_modulo1)) {
    //echo json_encode($row_modulo1);
    $array_modulo1[] = array(
        'idmodulo' => $row_modulo1['idmodulo'],
        'nome' => $row_modulo1['nome'],
        'nivel' => $row_modulo1['nivel']
    );
    $idmodulo1 = $row_modulo1['idmodulo'];
    //echo $idmodulo1;
    $query_modulo2 = "SELECT 
    idmodulo, nome, nivel, fk_idmodulo
FROM
    projetofinal2.tbmodulo
WHERE
    fk_idmodulo = $idmodulo1";
    $result_modulo2 = mysqli_query($conn, $query_modulo2);
    
    while ($row_modulo2 = mysqli_fetch_assoc($result_modulo2)) {
        //echo json_encode($row_modulo2);
        $array_modulo1[] = array(
            'idmodulo' => $row_modulo2['idmodulo'],
            'nome' => $row_modulo2['nome'],
            'nivel' => $row_modulo2['nivel'],
            'fk_idmodulo' => $row_modulo2['fk_idmodulo']
        );
        $idmodulo2 = $row_modulo2['idmodulo'];
        //echo $idmodulo2;
        $query_modulo3 = "SELECT 
    idmodulo, nome, nivel, fk_idmodulo
FROM
    projetofinal2.tbmodulo
WHERE
    fk_idmodulo = $idmodulo2";
        $result_modulo3 = mysqli_query($conn, $query_modulo3);
        while ($row_modulo3 = mysqli_fetch_assoc($result_modulo3)) {
            $array_modulo1[] = array(
                'idmodulo' => $row_modulo3['idmodulo'],
                'nome' => $row_modulo3['nome'],
                'nivel' => $row_modulo3['nivel'],
                'fk_idmodulo' => $row_modulo3['fk_idmodulo']
            );
        }
    }
}

if($array_modulo1){
    echo(json_encode($array_modulo1));
}else{
    echo(json_encode($array_modulo1));
}


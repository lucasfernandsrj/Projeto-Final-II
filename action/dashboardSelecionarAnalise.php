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
    $idmodulo1 = $row_modulo1['idmodulo']; //nivel 1
    $query_analise1 = "SELECT 
    orcamento,medidaDoRisco,situacao
FROM
    projetofinal2.tbanalise
WHERE
    idmodulo = $idmodulo1;";
    $result_analise1 = mysqli_query($conn, $query_analise1);
    $soma_orcamento1 = 0;
    $soma_medidadorisco1 = 0;
    $soma_medidadorisco_total1 = 0;
    while ($row_analise1 = mysqli_fetch_assoc($result_analise1)) {
        $soma_orcamento1 += $row_analise1['orcamento']; //orcamento
        $soma_medidadorisco_total1 += 1;
        if ($row_analise1['medidaDoRisco'] != NULL) {
            $soma_medidadorisco1 += 1;
            //echo $soma_medidadorisco;
        }
    }
    $array_modulo1[] = array(
        'idmodulo' => $row_modulo1['idmodulo'],
        'nome' => $row_modulo1['nome'],
        'nivel' => $row_modulo1['nivel'],
        'orcamento' => $soma_orcamento1,
        'medidadorisco' => $soma_medidadorisco1,
        'medidadoriscototal' => $soma_medidadorisco_total1
    );
    $query_modulo2 = "SELECT 
    idmodulo, nome, nivel, fk_idmodulo
FROM
    projetofinal2.tbmodulo
WHERE
    fk_idmodulo = $idmodulo1";
    $result_modulo2 = mysqli_query($conn, $query_modulo2);
    while ($row_modulo2 = mysqli_fetch_assoc($result_modulo2)) {
        //echo json_encode($row_modulo2);
        $idmodulo2 = $row_modulo2['idmodulo']; //nivel 2
        $query_analise2 = "SELECT 
    orcamento,medidaDoRisco
FROM
    projetofinal2.tbanalise
WHERE
    idmodulo = $idmodulo2;";
        $result_analise2 = mysqli_query($conn, $query_analise2);
        $soma_orcamento2 = 0;
        $soma_medidadorisco2 = 0;
        $soma_medidadorisco_total2 = 0;
        while ($row_analise2 = mysqli_fetch_assoc($result_analise2)) {
            $soma_orcamento2 += $row_analise2['orcamento'];
            $soma_medidadorisco_total2 += 1;
            if ($row_analise2['medidaDoRisco'] != NULL) {
                $soma_medidadorisco2 += 1;
                //echo $soma_medidadorisco;
            }
        }
        $array_modulo1[] = array(
            'idmodulo' => $row_modulo2['idmodulo'],
            'nome' => $row_modulo2['nome'],
            'nivel' => $row_modulo2['nivel'],
            'fk_idmodulo' => $row_modulo2['fk_idmodulo'],
            'orcamento' => $soma_orcamento2,
            'medidadorisco' => $soma_medidadorisco2,
            'medidadoriscototal' => $soma_medidadorisco_total2
        );
        $query_modulo3 = "SELECT 
    idmodulo, nome, nivel, fk_idmodulo
FROM
    projetofinal2.tbmodulo
WHERE
    fk_idmodulo = $idmodulo2";
        $result_modulo3 = mysqli_query($conn, $query_modulo3);
        while ($row_modulo3 = mysqli_fetch_assoc($result_modulo3)) {
            $idmodulo3 = $row_modulo3['idmodulo']; //nivel 3
            $query_analise3 = "SELECT 
    orcamento,medidaDoRisco
FROM
    projetofinal2.tbanalise
WHERE
    idmodulo = $idmodulo3;";
            $result_analise3 = mysqli_query($conn, $query_analise3);
            $soma_orcamento3 = 0;
            $soma_medidadorisco3 = 0;
            $soma_medidadorisco_total3 = 0;
            while ($row_analise3 = mysqli_fetch_assoc($result_analise3)) {
                $soma_orcamento3 += $row_analise3['orcamento'];
                $soma_medidadorisco_total3 += 1;
            if ($row_analise3['medidaDoRisco'] != NULL) {
                $soma_medidadorisco3 += 1;
                //echo $soma_medidadorisco;
            }
            }
            $array_modulo1[] = array(
                'idmodulo' => $row_modulo3['idmodulo'],
                'nome' => $row_modulo3['nome'],
                'nivel' => $row_modulo3['nivel'],
                'fk_idmodulo' => $row_modulo3['fk_idmodulo'],
                'orcamento' => $soma_orcamento3,
                'medidadorisco' => $soma_medidadorisco3,
                'medidadoriscototal' => $soma_medidadorisco_total3
            );
        }
    }
}

if ($array_modulo1) {
    echo(json_encode($array_modulo1));
} else {
    echo(json_encode($array_modulo1));
}


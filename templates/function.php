<?php

function dinheiro($valor) {
    $fmt = new \NumberFormatter('pt_BR', NumberFormatter::CURRENCY);
    return $fmt->formatCurrency($valor, "BRL");
}

function montacpf($nbr_cpf) {
    $parte_um = substr($nbr_cpf, 0, 3);
    $parte_dois = substr($nbr_cpf, 3, 3);
    $parte_tres = substr($nbr_cpf, 6, 3);
    $parte_quatro = substr($nbr_cpf, 9, 2);

    $monta_cpf = "$parte_um.$parte_dois.$parte_tres-$parte_quatro";

    return $monta_cpf;
}

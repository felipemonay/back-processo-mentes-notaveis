<?php

$mysql = new mysqli('localhost', 'root', '', 'mentes_notaveis');
$mysql->set_charset('utf8');

if ($mysql == FALSE) {
    echo "Erro na conexão";
}

<?php

require '../config.php';
require '../src/Usuario.php';

$teste = new Usuario($mysql);

$cidades = $teste->buscaCidades($_POST['id']);
$idCidade = $_POST['idCidade'];


foreach($cidades as $cidade){
    $selected = $cidade['id'] == $idCidade ? 'selected' : '';
    echo '<option value="'.$cidade['id'].'" '.$selected.' >'.$cidade['nome'].'</option>';
}

?>
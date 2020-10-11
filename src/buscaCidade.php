<?php

require '../config.php';
require '../src/Usuario.php';

$usuario = new Usuario($mysql);

$cidades = $usuario->buscaCidades($_POST['id']);


foreach($cidades as $cidade){
    echo '<option value="'.$cidade['id'].'">'.$cidade['nome'].'</option>';
}
?>
<?php

require '../config.php';
include '../src/Usuario.php';
require '../src/redireciona.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($mysql);
    $usuario->editar($_POST['idUsuario'], $_POST['nome'], $_POST['cep'], $_POST['rua'], $_POST['numero'], $_POST['estado'], $_POST['cidade']);

    redireciona('/phpweb/admin/index.php');
}

$usuario = new Usuario($mysql);
$user = $usuario->encontrarPorId($_GET['id']);
$listaEstados = $usuario->listarEstados();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
      <script type="text/javascript" src="../jquery.js"></script>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
</head>

<body>
    <div id="container">
        <h1>Editar Usuario</h1>
        <form action="editar-usuario.php" method="post">

            <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $user['id']; ?>" />
            
            <label class="mt-2" for="nome">Nome</label>
            <input class="form-control mb-1" required type="text" name="nome" id="nome" value="<?php echo $user['nome']; ?>"/>

            <label class="mt-2" for="nome">Nome</label>
            <input class="form-control mb-1" required type="text" name="nome" id="nome" value="<?php echo $user['nome']; ?>"/>
            
            <h2 class="mt-3"> Endereço </h2>
            <label class="mt-2" for="cep">CEP</label>
            <input class="form-control mb-1" required  type="number" name="cep" id="cep" value="<?php echo $user['cep']; ?>"></input>
        
            <label class="mt-2" for="rua">Rua</label>
            <input class="form-control mb-1" required  type="text" name="rua" id="rua" value="<?php echo $user['rua']; ?>"></input>
        
            <label class="mt-2" for="numero">Número</label>
            <input class="form-control mb-1" required  type="text" name="numero" id="numero" value="<?php echo $user['numero']; ?>"></input>
        
            <label class="mt-2" for="estado">Estado</label>
            <select class="form-control mb-1" name="estado" id="estado">
                <?php foreach ($listaEstados as $estado) { ?>
                    <option value="<?php echo $estado['id']; ?>" <?php echo $estado['id'] == $user['estado'] ? 'selected' : '' ?>><?php echo $estado['nome']; ?></option>
                <?php } ?>
            </select> 
            <input type="hidden" name="idCidade" id="idCidade" value="<?php echo $user['cidade']; ?>" />
            <label class="mt-2" for="cidade">Cidade</label>
            <select class="form-control mb-1" name="cidade" id="cidade">
            </select>
            <div class="text-center mt-4">
                <button class="btn btn-primary my-2 text-center">Editar Usuario</button>
            </div>
        </form>          
    </div>
</body>
</html>
<script>
    $("#estado").on("change",function(){
        var idEstado = $("#estado").val();
        var idCidade = $("#idCidade").val();
        
        $.ajax({
            url: '../src/editaCidade.php',
            type: 'POST',
            data: {id:idEstado, idCidade:idCidade},
            beforeSend: function(){
                $('#cidade').html("Carregando...");
            },
            success: function(data){
                $('#cidade').html(data);
            },
            error: function(data){
                $('#cidade').html("Houve um erro ao carregar");
            }
        });
    });
    $("#estado").ready(function(){
        var idEstado = $("#estado").val();
        var idCidade = $("#idCidade").val();
        
        $.ajax({
            url: '../src/editaCidade.php',
            type: 'POST',
            data: {id:idEstado, idCidade:idCidade},
            beforeSend: function(){
                $('#cidade').html("Carregando...");
            },
            success: function(data){
                $('#cidade').html(data);
            },
            error: function(data){
                $('#cidade').html("Houve um erro ao carregar");
            }
        });
    });
</script>
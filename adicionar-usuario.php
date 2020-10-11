<?php

require '../config.php';
require '../src/Usuario.php';
require '../src/redireciona.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($mysql);
    $usuario->adicionar($_POST['nome'], $_POST['cep'], $_POST['rua'], $_POST['numero'], $_POST['cidade'], $_POST['estado']);
    redireciona('/phpweb/admin/index.php');
}

$usuario = new Usuario($mysql);
$listaEstados = $usuario->listarEstados();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <link rel="stylesheet" type="text/css" href="../style.css">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
      <script type="text/javascript" src="../jquery.js"></script>
        
    <title>Adicionar Usuario</title>
    
</head>

<body>
    <div id="container">
        <h1>Adicionar Usuario</h1>
        <form action="adicionar-usuario.php" method="POST">
            
            <label class="mt-2" for="nome">Nome</label>
            <input class="form-control mb-1" required type="text" name="nome" id="nome" />
            
            <h2 class="mt-3"> Endereço </h2>
            <label class="mt-2" for="cep">CEP</label>
            <input class="form-control mb-1" required  type="number" name="cep" id="cep"></input>
        
            <label class="mt-2" for="rua">Rua</label>
            <input class="form-control mb-1" required  type="text" name="rua" id="rua"></input>
        
            <label class="mt-2" for="numero">Número</label>
            <input class="form-control mb-1" required  type="text" name="numero" id="numero"></input>
        
            <label class="mt-2" for="estado">Estado</label>
            <select class="form-control mb-1" name="estado" id="estado">
                <?php foreach ($listaEstados as $estado) { ?>
                    <option value="<?php echo $estado['id']; ?>"><?php echo $estado['nome']; ?></option>
                <?php } ?>
            </select> 

            <label class="mt-2" for="cidade">Cidade</label>
            <select class="form-control mb-1" name="cidade" id="cidade">
            </select>
            <div class="text-center mt-4">
                <button class="btn btn-primary my-2 text-center">Criar Usuario</button>
            </div>
        </form>
    </div>
</body>

</html>
<script>
    $("#estado").on("change",function(){
        var idEstado = $("#estado").val();
        
        $.ajax({
            url: '../src/buscaCidade.php',
            type: 'POST',
            data: {id:idEstado},
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
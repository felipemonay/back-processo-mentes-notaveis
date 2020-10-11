<?php

require '../config.php';
include '../src/Usuario.php';
require '../src/redireciona.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($mysql);
    $usuario->remover($_POST['id']);

    redireciona('/phpweb/admin/index.php');
}


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <meta charset="UTF-8">
    <title>Excluir Usuario</title>
</head>

<body>
    <div id="container">
        <h1>Você realmente deseja excluir o usuario?</h1>
        <form method="post" action="excluir-usuario.php">
            <p>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                <button class="botao">Excluir</button>
            </p>
        </form>
    </div>
</body>

</html>
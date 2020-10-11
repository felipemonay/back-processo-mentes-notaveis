<?php

require '../config.php';
include '../src/Usuario.php';

$usuario = new Usuario($mysql);
$usuarios = $usuario->exibirTodos();
$cidades = $usuario->contagemCidades();
$estados = $usuario->contagemEstados();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>CRUD Usuarios</title>
    <meta charset="UTF-8">
    <!-- <link rel="stylesheet" type="text/css" href="../style.css"> -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
    <div class="card mt-5">
        <h1>Lista de usuarios</h1>
        <div class="card-body">
            <div>
                <table class="table">
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">CEP</th>
                        <th scope="col">Rua</th>
                        <th scope="col">Número</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Cidade</th>
                        <th scope="col">Ações<th>
                    </tr>
                    <?php foreach ($usuarios as $user) { ?>
                        <tr>
                            <td scope="row"><p><?php echo $user['nome']; ?></p></td>
                            <td><p><?php echo $user['cep']; ?></p></td>
                            <td><p><?php echo $user['rua']; ?></p></td>
                            <td><p><?php echo $user['numero']; ?></p></td>
                            <td><p><?php echo $user['estado']; ?></p></td>
                            <td><p><?php echo $user['cidade']; ?></p></td>
                            <td>
                                <a class="btn btn-outline-primary" href="editar-usuario.php?id=<?php echo $user['id']; ?>">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                                </a>
                                <a class="btn btn-outline-primary" href="excluir-usuario.php?id=<?php echo $user['id']; ?>">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>                
            </div>
        <a class="btn btn-primary float-right" href="adicionar-usuario.php">Adicionar Usuario</a>
        </div>
    </div>

    <div class="card d-flex flex-row justify-content-around mt-3">
        <div>
            <h1>Contagem de cidades</h1>
            <div>
                <table class="table">
                    <tr>
                        <th scope="col">Cidade</th>
                        <th scope="col">Contagem</th>
                    </tr>
                    <?php foreach ($cidades as $cidade) { ?>
                        <tr>
                            <td scope="row"><p><?php echo $cidade['nome']; ?></p></td>
                            <td><p><?php echo $cidade['contagem']; ?></p></td>
                        </tr>
                    <?php } ?>
                </table>                
            </div>
        </div>
        <div>
            <h1>Contagem de estados</h1>
            <div>
                <table class="table">
                    <tr>
                        <th scope="col">Cidade</th>
                        <th scope="col">Contagem</th>
                    </tr>
                    <?php foreach ($estados as $estado) { ?>
                        <tr>
                            <td><p><?php echo $estado['nome']; ?></p></td>
                            <td><p><?php echo $estado['contagem']; ?></p></td>
                        </tr>
                    <?php } ?>
                </table>                
            </div>
        </div>
    </div>
</body>

</html>
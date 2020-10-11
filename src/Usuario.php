<?php

class Usuario
{

    private $mysql;

    public function __construct(mysqli $mysql)
    {
        $this->mysql = $mysql;
    }

    public function adicionar(string $nome, string $cep, string $rua, string $numero, string $cidade, string $estado): void
    {
        $insereUsuario = $this->mysql->prepare('INSERT INTO usuarios (nome) VALUES(?);');
        $insereUsuario->bind_param('s', $nome);
        $insereUsuario->execute();
        $idUsuario = $insereUsuario->insert_id;
        $insereEndereco = $this->mysql->prepare(
            'INSERT INTO enderecos(idUsuario, cep, rua, numero, idCidade, idEstado)
             VALUES (?,?,?,?,?,?)'
        );
        $insereEndereco->bind_param('ssssss', $idUsuario, $cep, $rua, $numero, $cidade, $estado );
        $insereEndereco->execute();
    }

    public function remover(string $id): void
    {
        $removerEndereco = $this->mysql->prepare('DELETE FROM enderecos WHERE idUsuario = ?');
        $removerEndereco->bind_param('s', $id);
        $removerEndereco->execute();

        $removerUsuario = $this->mysql->prepare('DELETE FROM usuarios WHERE id = ?');
        $removerUsuario->bind_param('s', $id);
        $removerUsuario->execute();
    }

    public function exibirTodos(): array
    {

        $resultado = $this->mysql->query('SELECT usuarios.id, usuarios.nome, enderecos.cep, enderecos.rua, enderecos.numero,
            cidades.nome AS cidade, estados.nome AS estado FROM `usuarios` 
            INNER JOIN enderecos ON usuarios.id = enderecos.idUsuario 
            INNER JOIN cidades ON enderecos.idCidade = cidades.id
            INNER JOIN estados ON cidades.id_estado = estados.id');
        $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);

        return $usuarios;
    }

    public function encontrarPorId(string $id): array
    {
        $selecionaUsuario = $this->mysql->prepare("SELECT usuarios.id, usuarios.nome, enderecos.cep, enderecos.rua, enderecos.numero,
            cidades.id AS cidade, estados.id AS estado FROM `usuarios` 
            INNER JOIN enderecos ON usuarios.id = enderecos.idUsuario 
            INNER JOIN cidades ON enderecos.idCidade = cidades.id
            INNER JOIN estados ON cidades.id_estado = estados.id
            WHERE usuarios.id = ?");
        $selecionaUsuario->bind_param('s', $id);
        $selecionaUsuario->execute();

        $usuario = $selecionaUsuario->get_result()->fetch_assoc();
        return $usuario;
    }

    public function editar(string $idUsuario, string $nome, string $cep, string $rua, string $numero, string $estado, string $cidade): void
    {
        $editaUsuario = $this->mysql->prepare('UPDATE usuarios SET nome = ? WHERE id = ?');
        $editaUsuario->bind_param('ss', $nome, $idUsuario);
        $editaUsuario->execute();

        $editaEndereco = $this->mysql->prepare('UPDATE enderecos SET cep = ?, rua = ?, numero = ?, idEstado = ?, idCidade = ? 
                                                WHERE idUsuario = ?');
        $editaEndereco->bind_param('ssssss', $cep, $rua, $numero, $estado, $cidade, $idUsuario);
        $editaEndereco->execute();
    }

    public function listarEstados(): array
    {

        $resultado = $this->mysql->query('SELECT id as id, nome as nome from estados');
        $listaEstados = $resultado->fetch_all(MYSQLI_ASSOC);

        return $listaEstados;
    }

    public function listarCidades(string $id): array
    {

        $resultado = $this->mysql->query(
            'SELECT cidades.id as id, cidades.nome as nome from cidades
            INNER JOIN estados on cidades.id_estado = estados.id
            WHERE cidades.id_estado = ?');
        $resultado->bind_param('s', $id);
        $resultado->execute();
        $listaCidades = $resultado->fetch_all(MYSQLI_ASSOC);

        return $listaCidades;
    }

    
    
    public function contagemCidades() 
    {

        $resultado = $this->mysql->query('SELECT cidades.nome, count(enderecos.idCidade) AS contagem FROM enderecos
            INNER JOIN cidades ON enderecos.idCidade = cidades.id
            GROUP BY cidades.id');
        $cidades = $resultado->fetch_all(MYSQLI_ASSOC);

        return $cidades;
    }
    
    public function contagemEstados() 
    {

        $resultado = $this->mysql->query('SELECT estados.nome, count(enderecos.idEstado) AS contagem FROM enderecos
            INNER JOIN estados ON enderecos.idEstado = estados.id
            GROUP BY estados.id');
        $estados = $resultado->fetch_all(MYSQLI_ASSOC);

        return $estados;
    }

    public function buscaCidades(string $id) : array 
    {
        $resultado = $this->mysql->query('
            SELECT cidades.id, cidades.nome from cidades
            INNER JOIN estados on cidades.id_estado = estados.id
            WHERE estados.id ='.$id.'');
        $cidades = $resultado->fetch_all(MYSQLI_ASSOC);
        return $cidades;        
    }
}

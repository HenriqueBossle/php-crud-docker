<?php
require_once __DIR__ . '/../config/database.php';

class Personagem
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = getPDO();
    }

    public function all()
    {
        $stmt = $this->pdo->query('SELECT * FROM tabela_personagens ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM tabela_personagens WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO tabela_personagens (nome, franquia, descricao) VALUES (:nome, :franquia, :descricao) RETURNING id');
        $stmt->execute([
            'nome' => $data['nome'],
            'franquia' => $data['franquia'],
            'descricao' => $data['descricao']
        ]);
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare('UPDATE tabela_personagens SET nome = :nome, franquia = :franquia, descricao = :descricao WHERE id = :id');
        return $stmt->execute([
            'nome' => $data['nome'],
            'franquia' => $data['franquia'],
            'descricao' => $data['descricao'],
            'id' => $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM tabela_personagens WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
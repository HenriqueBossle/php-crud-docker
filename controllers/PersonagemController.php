<?php
require_once __DIR__ . '/../models/Personagem.php';

class PersonagemController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Personagem();
    }

    protected function render($view, $data = [])
    {
        extract($data);
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/' . $view . '.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    public function index()
    {
        $personagens = $this->model->all();
        $this->render('personagens/list', compact('personagens'));
    }

    public function create()
    {
        $this->render('personagens/form', ['action' => 'store', 'personagem' => null]);
    }

    public function store()
    {
        $nome = trim($_POST['nome'] ?? '');
        $franquia = trim($_POST['franquia'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');

        if ($nome === '') {
            $_SESSION['error'] = 'O nome é obrigatório.';
            header('Location: index.php?controller=personagem&action=create');
            exit;
        }

        $this->model->create(['nome' => $nome, 'franquia' => $franquia, 'descricao' => $descricao]);
        $_SESSION['success'] = 'Personagem criado com sucesso.';
        header('Location: index.php');
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: index.php'); exit; }
        $personagem = $this->model->find($id);
        $this->render('personagens/form', ['action' => 'update', 'personagem' => $personagem]);
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) { header('Location: index.php'); exit; }

        $nome = trim($_POST['nome'] ?? '');
        $franquia = trim($_POST['franquia'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');

        if ($nome === '') {
            $_SESSION['error'] = 'O nome é obrigatório.';
            header('Location: index.php?controller=personagem&action=edit&id=' . $id);
            exit;
        }

        $this->model->update($id, ['nome' => $nome, 'franquia' => $franquia, 'descricao' => $descricao]);
        $_SESSION['success'] = 'Personagem atualizado.';
        header('Location: index.php');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->delete($id);
            $_SESSION['success'] = 'Personagem removido.';
        }
        header('Location: index.php');
        exit;
    }

    public function view()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: index.php'); exit; }
        $personagem = $this->model->find($id);
        $this->render('personagens/view', compact('personagem'));
    }
}

// Iniciar sessão para mensagens flash
if (session_status() === PHP_SESSION_NONE) session_start();
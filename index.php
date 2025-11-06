<?php
// Front controller simples: roteia por controller/action via query string
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/PersonagemController.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'personagem';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Roteamento mínimo
if ($controller === 'personagem') {
    $c = new PersonagemController();
    switch ($action) {
        case 'create': $c->create(); break;
        case 'store': $c->store(); break;
        case 'edit': $c->edit(); break;
        case 'update': $c->update(); break;
        case 'delete': $c->delete(); break;
        case 'view': $c->view(); break;
        default: $c->index(); break;
    }
} else {
    echo "Controller não encontrado";
}
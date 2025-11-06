<h2><?php echo ($personagem ? 'Editar' : 'Novo'); ?> Personagem</h2>

<?php
$id = $personagem['id'] ?? '';
$nome = $personagem['nome'] ?? '';
$franquia = $personagem['franquia'] ?? '';
$descricao = $personagem['descricao'] ?? '';

$formAction = $action === 'store' ? 'index.php?controller=personagem&action=store' : 'index.php?controller=personagem&action=update';
?>

<form method="post" action="<?php echo $formAction; ?>">
    <?php if ($id): ?>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label class="form-label">Nome</label>
        <input class="form-control" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Franquia</label>
        <input class="form-control" name="franquia" value="<?php echo htmlspecialchars($franquia); ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Descrição</label>
        <textarea class="form-control" name="descricao" rows="4"><?php echo htmlspecialchars($descricao); ?></textarea>
    </div>

    <div>
        <button class="btn btn-primary" type="submit">Salvar</button>
        <a class="btn btn-secondary" href="index.php">Cancelar</a>
    </div>
</form>
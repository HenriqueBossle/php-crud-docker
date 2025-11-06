<h2>Ver Personagem</h2>

<?php if (!$personagem): ?>
    <p>Personagem não encontrado.</p>
<?php else: ?>
    <dl class="row">
        <dt class="col-sm-2">ID</dt>
        <dd class="col-sm-10"><?php echo htmlspecialchars($personagem['id']); ?></dd>

        <dt class="col-sm-2">Nome</dt>
        <dd class="col-sm-10"><?php echo htmlspecialchars($personagem['nome']); ?></dd>

        <dt class="col-sm-2">Franquia</dt>
        <dd class="col-sm-10"><?php echo htmlspecialchars($personagem['franquia']); ?></dd>

        <dt class="col-sm-2">Descrição</dt>
        <dd class="col-sm-10"><?php echo nl2br(htmlspecialchars($personagem['descricao'])); ?></dd>
    </dl>

    <a class="btn btn-warning" href="index.php?controller=personagem&action=edit&id=<?php echo $personagem['id']; ?>">Editar</a>
    <a class="btn btn-secondary" href="index.php">Voltar</a>
<?php endif; ?>
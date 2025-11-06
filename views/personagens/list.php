<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Personagens</h1>
    <a class="btn btn-primary" href="index.php?controller=personagem&action=create">Criar novo</a>
</div>

<?php if (empty($personagens)): ?>
    <p>Nenhum personagem cadastrado.</p>
<?php else: ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Franquia</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($personagens as $p): ?>
            <tr>
                <td><?php echo htmlspecialchars($p['id']); ?></td>
                <td><?php echo htmlspecialchars($p['nome']); ?></td>
                <td><?php echo htmlspecialchars($p['franquia']); ?></td>
                <td>
                    <a class="btn btn-sm btn-secondary" href="index.php?controller=personagem&action=view&id=<?php echo $p['id']; ?>">Ver</a>
                    <a class="btn btn-sm btn-warning" href="index.php?controller=personagem&action=edit&id=<?php echo $p['id']; ?>">Editar</a>
                    <a class="btn btn-sm btn-danger" href="index.php?controller=personagem&action=delete&id=<?php echo $p['id']; ?>" onclick="return confirm('Remover este personagem?');">Remover</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
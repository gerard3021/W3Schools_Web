<h1>Nueva Categoría</h1>
<?php if (!empty($errores)): ?><div class="error-lista"><?php foreach ($errores as $e): ?><div>• <?= esc($e) ?></div><?php endforeach; ?></div><?php endif; ?>
<form action="<?= base_url('categories/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="campo"><label>Nombre: *</label><input type="text" name="CategoryName" value="<?= esc($old['CategoryName'] ?? '') ?>" required></div>
    <div class="campo"><label>Descripción: *</label><textarea name="Description" required><?= esc($old['Description'] ?? '') ?></textarea></div>
    <br><input type="submit" value="Registrar">&nbsp;<a href="<?= base_url('categories') ?>" class="btn btn-gray">Cancelar</a>
</form>

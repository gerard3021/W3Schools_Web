<h1>Editar Categoría</h1>
<?php if (!empty($errores)): ?><div class="error-lista"><?php foreach ($errores as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?></div><?php endif; ?>
<form action="<?= base_url('categories/update/' . $item['CategoryID']) ?>" method="post">
    <?= csrf_field() ?>
    <div class="campo"><label>Nombre:</label><input type="text" name="CategoryName" value="<?= esc($item['CategoryName']) ?>" required></div>
    <div class="campo"><label>Descripción:</label><textarea name="Description"><?= esc($item['Description']) ?></textarea></div>
    <br>
    <input type="submit" value="Actualizar">
    &nbsp;<a href="<?= base_url('categories') ?>" class="btn btn-gray">Cancelar</a>
</form>

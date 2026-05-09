<h1>Nuevo Empleado</h1>
<?php if (!empty($errores)): ?><div class="error-lista"><?php foreach ($errores as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?></div><?php endif; ?>
<form action="<?= base_url('employees/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="campo"><label>Apellido:*</label><input type="text" name="LastName" value="<?= esc($old['LastName'] ?? '') ?>" required></div>
    <div class="campo"><label>Nombre:*</label><input type="text" name="FirstName" value="<?= esc($old['FirstName'] ?? '') ?>" required></div>
    <div class="campo"><label>Fecha de Nacimiento:</label><input type="date" name="BirthDate" value="<?= esc($old['BirthDate'] ?? '') ?>"></div>
    <div class="campo"><label>Foto (archivo):</label><input type="text" name="Photo" value="<?= esc($old['Photo'] ?? '') ?>"></div>
    <div class="campo"><label>Notas:</label><textarea name="Notes"><?= esc($old['Notes'] ?? '') ?></textarea></div>
    <br><input type="submit" value="Registrar">&nbsp;<a href="<?= base_url('employees') ?>" class="btn btn-gray">Cancelar</a>
</form>

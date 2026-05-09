<h1>Editar Empleado</h1>
<?php if (!empty($errores)): ?><div class="error-lista"><?php foreach ($errores as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?></div><?php endif; ?>
<form action="<?= base_url('employees/update/' . $item['EmployeeID']) ?>" method="post">
    <?= csrf_field() ?>
    <div class="campo"><label>Apellido:*</label><input type="text" name="LastName" value="<?= esc($item['LastName']) ?>" required></div>
    <div class="campo"><label>Nombre:*</label><input type="text" name="FirstName" value="<?= esc($item['FirstName']) ?>" required></div>
    <div class="campo"><label>Fecha de Nacimiento:</label><input type="date" name="BirthDate" value="<?= esc($item['BirthDate']) ?>"></div>
    <div class="campo"><label>Foto (archivo):</label><input type="text" name="Photo" value="<?= esc($item['Photo']) ?>"></div>
    <div class="campo"><label>Notas:</label><textarea name="Notes"><?= esc($item['Notes']) ?></textarea></div>
    <br><input type="submit" value="Actualizar">&nbsp;<a href="<?= base_url('employees') ?>" class="btn btn-gray">Cancelar</a>
</form>

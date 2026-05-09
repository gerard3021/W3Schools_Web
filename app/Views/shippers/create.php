<h1>Nueva Empresa de Envío</h1>
<?php if (!empty($errores)): ?><div class="error-lista"><?php foreach ($errores as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?></div><?php endif; ?>
<form action="<?= base_url('shippers/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="campo"><label>Nombre:*</label><input type="text" name="ShipperName" value="<?= esc($old['ShipperName'] ?? '') ?>" required></div>
    <div class="campo"><label>Teléfono:</label><input type="text" name="Phone" value="<?= esc($old['Phone'] ?? '') ?>"></div>
    <br><input type="submit" value="Registrar">&nbsp;<a href="<?= base_url('shippers') ?>" class="btn btn-gray">Cancelar</a>
</form>

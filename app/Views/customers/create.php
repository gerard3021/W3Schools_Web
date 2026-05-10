<h1>Nuevo Cliente</h1>
<?php if (!empty($errores)): ?><div class="error-lista"><?php foreach ($errores as $e): ?><div>• <?= esc($e) ?></div><?php endforeach; ?></div><?php endif; ?>
<form action="<?= base_url('customers/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="campo"><label>Nombre Cliente: *</label><input type="text" name="CustomerName" value="<?= esc($old['CustomerName'] ?? '') ?>" required></div>
    <div class="campo"><label>Contacto: *</label><input type="text" name="ContactName" value="<?= esc($old['ContactName'] ?? '') ?>" required></div>
    <div class="campo"><label>Dirección: *</label><input type="text" name="Address" value="<?= esc($old['Address'] ?? '') ?>" required></div>
    <div class="campo"><label>Ciudad: *</label><input type="text" name="City" value="<?= esc($old['City'] ?? '') ?>" required></div>
    <div class="campo"><label>Código Postal: *</label><input type="text" name="PostalCode" value="<?= esc($old['PostalCode'] ?? '') ?>" required></div>
    <div class="campo"><label>País: *</label><input type="text" name="Country" value="<?= esc($old['Country'] ?? '') ?>" required></div>
    <br><input type="submit" value="Registrar">&nbsp;<a href="<?= base_url('customers') ?>" class="btn btn-gray">Cancelar</a>
</form>

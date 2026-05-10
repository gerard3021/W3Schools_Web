<h1>Nuevo Proveedor</h1>
<?php if (!empty($errores)): ?><div class="error-lista"><?php foreach ($errores as $e): ?><div>• <?= esc($e) ?></div><?php endforeach; ?></div><?php endif; ?>
<form action="<?= base_url('suppliers/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="campo"><label>Nombre Proveedor: *</label><input type="text" name="SupplierName" value="<?= esc($old['SupplierName'] ?? '') ?>" required></div>
    <div class="campo"><label>Contacto: *</label><input type="text" name="ContactName" value="<?= esc($old['ContactName'] ?? '') ?>" required></div>
    <div class="campo"><label>Dirección: *</label><input type="text" name="Address" value="<?= esc($old['Address'] ?? '') ?>" required></div>
    <div class="campo"><label>Ciudad: *</label><input type="text" name="City" value="<?= esc($old['City'] ?? '') ?>" required></div>
    <div class="campo"><label>Código Postal: *</label><input type="text" name="PostalCode" value="<?= esc($old['PostalCode'] ?? '') ?>" required></div>
    <div class="campo"><label>País: *</label><input type="text" name="Country" value="<?= esc($old['Country'] ?? '') ?>" required></div>
    <div class="campo"><label>Teléfono: *</label><input type="text" name="Phone" value="<?= esc($old['Phone'] ?? '') ?>" required></div>
    <br><input type="submit" value="Registrar">&nbsp;<a href="<?= base_url('suppliers') ?>" class="btn btn-gray">Cancelar</a>
</form>

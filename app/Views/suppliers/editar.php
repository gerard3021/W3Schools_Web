<h1>Editar Proveedor</h1>
<?php if (!empty($errores)): ?><div class="error-lista"><?php foreach ($errores as $e): ?><div>• <?= esc($e) ?></div><?php endforeach; ?></div><?php endif; ?>
<form action="<?= base_url('suppliers/update/' . $item['SupplierID']) ?>" method="post">
    <?= csrf_field() ?>
    <div class="campo"><label>Nombre Proveedor: *</label><input type="text" name="SupplierName" value="<?= esc($item['SupplierName']) ?>" required></div>
    <div class="campo"><label>Contacto: *</label><input type="text" name="ContactName" value="<?= esc($item['ContactName']) ?>" required></div>
    <div class="campo"><label>Dirección: *</label><input type="text" name="Address" value="<?= esc($item['Address']) ?>" required></div>
    <div class="campo"><label>Ciudad: *</label><input type="text" name="City" value="<?= esc($item['City']) ?>" required></div>
    <div class="campo"><label>Código Postal: *</label><input type="text" name="PostalCode" value="<?= esc($item['PostalCode']) ?>" required></div>
    <div class="campo"><label>País: *</label><input type="text" name="Country" value="<?= esc($item['Country']) ?>" required></div>
    <div class="campo"><label>Teléfono: *</label><input type="text" name="Phone" value="<?= esc($item['Phone']) ?>" required></div>
    <br><input type="submit" value="Actualizar">&nbsp;<a href="<?= base_url('suppliers') ?>" class="btn btn-gray">Cancelar</a>
</form>

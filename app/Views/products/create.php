<h1>Nuevo Producto</h1>
<?php if (!empty($errores)): ?><div class="error-lista"><?php foreach ($errores as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?></div><?php endif; ?>
<form action="<?= base_url('products/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="campo"><label>Nombre Producto:*</label><input type="text" name="ProductName" value="<?= esc($old['ProductName'] ?? '') ?>" required></div>
    <div class="campo"><label>Categoría:</label>
        <select name="CategoryID">
            <option value="">-- Seleccionar --</option>
            <?php foreach ($categories as $c): ?>
            <option value="<?= $c['CategoryID'] ?>" <?= (($old['CategoryID'] ?? '') == $c['CategoryID'] ? 'selected' : '') ?>><?= esc($c['CategoryName']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="campo"><label>Proveedor:</label>
        <select name="SupplierID">
            <option value="">-- Seleccionar --</option>
            <?php foreach ($suppliers as $s): ?>
            <option value="<?= $s['SupplierID'] ?>" <?= (($old['SupplierID'] ?? '') == $s['SupplierID'] ? 'selected' : '') ?>><?= esc($s['SupplierName']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="campo"><label>Unidad:</label><input type="text" name="Unit" value="<?= esc($old['Unit'] ?? '') ?>"></div>
    <div class="campo"><label>Precio:*</label><input type="number" name="Price" step="0.01" min="0" value="<?= esc($old['Price'] ?? '') ?>" required></div>
    <br><input type="submit" value="Registrar">&nbsp;<a href="<?= base_url('products') ?>" class="btn btn-gray">Cancelar</a>
</form>

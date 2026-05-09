<?php if (session()->getFlashdata('mensaje')): ?><div class="alerta"><?= session()->getFlashdata('mensaje') ?></div><?php endif; ?>
<?php
$catIdx = []; foreach ($categories as $c) { $catIdx[$c['CategoryID']] = $c['CategoryName']; }
$supIdx = []; foreach ($suppliers  as $s) { $supIdx[$s['SupplierID']] = $s['SupplierName']; }
?>
<div class="top-bar">
    <h1>Productos</h1>
    <a href="<?= base_url('products/create') ?>" class="btn btn-green">+ Nuevo Producto</a>
</div>
<table>
    <thead><tr><th>#ID</th><th>Producto</th><th>Categoría</th><th>Proveedor</th><th>Unidad</th><th>Precio</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php if (!empty($items)): foreach ($items as $r): ?>
    <tr>
        <td><?= esc($r['ProductID']) ?></td>
        <td><?= esc($r['ProductName']) ?></td>
        <td><?= esc($catIdx[$r['CategoryID']] ?? '-') ?></td>
        <td><?= esc($supIdx[$r['SupplierID']] ?? '-') ?></td>
        <td><?= esc($r['Unit']) ?></td>
        <td>$ <?= number_format($r['Price'], 2) ?></td>
        <td>
            <a class="btn btn-blue btn-sm" href="<?= base_url('products/editar/' . $r['ProductID']) ?>">Editar</a>
            <a class="btn btn-red btn-sm"  href="<?= base_url('products/delete/' . $r['ProductID']) ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; else: ?><tr><td colspan="7">No hay registros.</td></tr><?php endif; ?>
    </tbody>
</table>

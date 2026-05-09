<?php if (session()->getFlashdata('mensaje')): ?><div class="alerta"><?= session()->getFlashdata('mensaje') ?></div><?php endif; ?>
<div class="top-bar">
    <h1>Proveedores</h1>
    <a href="<?= base_url('suppliers/create') ?>" class="btn btn-green">+ Nuevo Proveedor</a>
</div>
<table>
    <thead><tr><th>#ID</th><th>Proveedor</th><th>Contacto</th><th>Ciudad</th><th>País</th><th>Teléfono</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php if (!empty($items)): foreach ($items as $r): ?>
    <tr>
        <td><?= esc($r['SupplierID']) ?></td>
        <td><?= esc($r['SupplierName']) ?></td>
        <td><?= esc($r['ContactName']) ?></td>
        <td><?= esc($r['City']) ?></td>
        <td><?= esc($r['Country']) ?></td>
        <td><?= esc($r['Phone']) ?></td>
        <td>
            <a class="btn btn-blue btn-sm" href="<?= base_url('suppliers/editar/' . $r['SupplierID']) ?>">Editar</a>
            <a class="btn btn-red btn-sm"  href="<?= base_url('suppliers/delete/' . $r['SupplierID']) ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; else: ?><tr><td colspan="7">No hay registros.</td></tr><?php endif; ?>
    </tbody>
</table>

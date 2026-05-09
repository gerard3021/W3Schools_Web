<?php if (session()->getFlashdata('mensaje')): ?><div class="alerta"><?= session()->getFlashdata('mensaje') ?></div><?php endif; ?>
<div class="top-bar">
    <h1>Clientes</h1>
    <a href="<?= base_url('customers/create') ?>" class="btn btn-green">+ Nuevo Cliente</a>
</div>
<table>
    <thead><tr><th>#ID</th><th>Cliente</th><th>Contacto</th><th>Ciudad</th><th>País</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php if (!empty($items)): foreach ($items as $r): ?>
    <tr>
        <td><?= esc($r['CustomerID']) ?></td>
        <td><?= esc($r['CustomerName']) ?></td>
        <td><?= esc($r['ContactName']) ?></td>
        <td><?= esc($r['City']) ?></td>
        <td><?= esc($r['Country']) ?></td>
        <td>
            <a class="btn btn-blue btn-sm" href="<?= base_url('customers/editar/' . $r['CustomerID']) ?>">Editar</a>
            <a class="btn btn-red btn-sm"  href="<?= base_url('customers/delete/' . $r['CustomerID']) ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; else: ?><tr><td colspan="6">No hay registros.</td></tr><?php endif; ?>
    </tbody>
</table>

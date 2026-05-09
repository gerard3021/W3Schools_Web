<?php if (session()->getFlashdata('mensaje')): ?><div class="alerta"><?= session()->getFlashdata('mensaje') ?></div><?php endif; ?>
<div class="top-bar">
    <h1>Empresas de Envío</h1>
    <a href="<?= base_url('shippers/create') ?>" class="btn btn-green">+ Nueva Empresa</a>
</div>
<table>
    <thead><tr><th>#ID</th><th>Nombre</th><th>Teléfono</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php if (!empty($items)): foreach ($items as $r): ?>
    <tr>
        <td><?= esc($r['ShipperID']) ?></td>
        <td><?= esc($r['ShipperName']) ?></td>
        <td><?= esc($r['Phone']) ?></td>
        <td>
            <a class="btn btn-blue btn-sm" href="<?= base_url('shippers/editar/' . $r['ShipperID']) ?>">Editar</a>
            <a class="btn btn-red btn-sm"  href="<?= base_url('shippers/delete/' . $r['ShipperID']) ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; else: ?><tr><td colspan="4">No hay registros.</td></tr><?php endif; ?>
    </tbody>
</table>

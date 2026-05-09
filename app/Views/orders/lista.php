<?php if (session()->getFlashdata('mensaje')): ?><div class="alerta"><?= session()->getFlashdata('mensaje') ?></div><?php endif; ?>
<div class="top-bar">
    <h1>Órdenes</h1>
    <a href="<?= base_url('orders/create') ?>" class="btn btn-green">+ Nueva Orden</a>
</div>
<table>
    <thead><tr><th>#Orden</th><th>Cliente</th><th>Empleado</th><th>Fecha</th><th>Envío</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php if (!empty($items)): foreach ($items as $r): ?>
    <tr>
        <td><?= esc($r['OrderID']) ?></td>
        <td><?= esc($r['CustomerName']) ?></td>
        <td><?= esc($r['FirstName'] . ' ' . $r['LastName']) ?></td>
        <td><?= esc($r['OrderDate']) ?></td>
        <td><?= esc($r['ShipperName']) ?></td>
        <td>
            <a class="btn btn-green btn-sm" href="<?= base_url('orders/detalles/' . $r['OrderID']) ?>">Ver Detalles</a>
            <a class="btn btn-blue btn-sm"  href="<?= base_url('orders/editar/' . $r['OrderID']) ?>">Editar</a>
            <a class="btn btn-red btn-sm"   href="<?= base_url('orders/delete/' . $r['OrderID']) ?>" onclick="return confirm('¿Eliminar orden?')">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; else: ?><tr><td colspan="6">No hay registros.</td></tr><?php endif; ?>
    </tbody>
</table>

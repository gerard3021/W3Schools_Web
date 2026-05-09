<?php if (session()->getFlashdata('mensaje')): ?><div class="alerta"><?= session()->getFlashdata('mensaje') ?></div><?php endif; ?>
<div class="top-bar">
    <h1>Categorías</h1>
    <a href="<?= base_url('categories/create') ?>" class="btn btn-green">+ Nueva Categoría</a>
</div>
<table>
    <thead><tr><th>#ID</th><th>Nombre</th><th>Descripción</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php if (!empty($items)): foreach ($items as $r): ?>
    <tr>
        <td><?= esc($r['CategoryID']) ?></td>
        <td><?= esc($r['CategoryName']) ?></td>
        <td><?= esc($r['Description']) ?></td>
        <td>
            <a class="btn btn-blue btn-sm" href="<?= base_url('categories/editar/' . $r['CategoryID']) ?>">Editar</a>
            <a class="btn btn-red btn-sm"  href="<?= base_url('categories/delete/' . $r['CategoryID']) ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; else: ?>
    <tr><td colspan="4">No hay registros.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

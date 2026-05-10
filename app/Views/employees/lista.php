<?php if (session()->getFlashdata('mensaje')): ?><div class="alerta"><?= session()->getFlashdata('mensaje') ?></div><?php endif; ?>
<div class="top-bar">
    <h1>Empleados</h1>
    <a href="<?= base_url('employees/create') ?>" class="btn btn-green">+ Nuevo Empleado</a>
</div>
<table>
    <thead><tr><th>#ID</th><th>Foto</th><th>Apellido</th><th>Nombre</th><th>Fecha Nac.</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php if (!empty($items)): foreach ($items as $r): ?>
    <tr>
        <td><?= esc($r['EmployeeID']) ?></td>
        <td style="text-align:center;">
            <img src="<?= base_url('uploads/' . esc($r['Photo'] ?? '')) ?>"
            style="width:40px;height:40px;object-fit:cover;border-radius:50%;border:2px solid #04AA6D;"
            onerror="this.outerHTML='<span style=\'color:#ccc;font-size:11px;\'>Sin foto</span>'">
        </td>
        <td><?= esc($r['LastName']) ?></td>
        <td><?= esc($r['FirstName']) ?></td>
        <td><?= esc($r['BirthDate']) ?></td>
        <td>
            <a class="btn btn-blue btn-sm" href="<?= base_url('employees/editar/' . $r['EmployeeID']) ?>">Editar</a>
            <a class="btn btn-red btn-sm"  href="<?= base_url('employees/delete/' . $r['EmployeeID']) ?>" onclick="return confirm('¿Eliminar empleado?')">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; else: ?>
    <tr><td colspan="6">No hay registros.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<?php if (session()->getFlashdata('mensaje')): ?><div class="alerta"><?= session()->getFlashdata('mensaje') ?></div><?php endif; ?>
<div class="top-bar">
    <h1>Empleados</h1>
    <a href="<?= base_url('employees/create') ?>" class="btn btn-green">+ Nuevo Empleado</a>
</div>
<table>
    <thead><tr><th>#ID</th><th>Foto</th><th>Apellido</th><th>Nombre</th><th>Fecha Nac.</th><th>Notas</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php if (!empty($items)): foreach ($items as $r): ?>
    <tr>
        <td><?= esc($r['EmployeeID']) ?></td>
        <td style="text-align:center;">
           <?php if (!empty(trim((string)($r['Photo'] ?? '')))): ?>
           <img src="<?= base_url('uploads/' . esc($r['Photo'])) ?>"
                style="width:40px;height:40px;object-fit:cover;border-radius:50%;border:2px solid #04AA6D;"
                onerror="this.outerHTML='<span style=\'color:#ccc;font-size:11px;\'>Sin foto</span>'">
            <?php else: ?>
                <span style="color:#ccc;font-size:11px;">Sin foto</span>
            <?php endif; ?>
        </td>
        <td><?= esc($r['LastName']) ?></td>
        <td><?= esc($r['FirstName']) ?></td>
        <td><?= esc($r['BirthDate']) ?></td>
        <td style="text-align:center;">
            <?php if (!empty(trim($r['Notes'] ?? ''))): ?>
                <button type="button" class="btn btn-gray btn-sm" onclick="document.getElementById('modal-<?= $r['EmployeeID'] ?>').style.display='flex'">Ver notas</button>
                <div id="modal-<?= $r['EmployeeID'] ?>"
                    style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:999;align-items:center;justify-content:center;">
                    <div style="background:#fff;border-radius:8px;padding:24px;max-width:480px;width:90%;position:relative;">
                        <strong style="display:block;margin-bottom:10px;">Notas de <?= esc($r['FirstName'] . ' ' . $r['LastName']) ?></strong>
                        <p style="white-space:pre-wrap;color:#444;"><?= esc($r['Notes']) ?></p>
                        <button type="button" class="btn btn-gray btn-sm" style="margin-top:14px;"onclick="document.getElementById('modal-<?= $r['EmployeeID'] ?>').style.display='none'">
                            Cerrar</button>
                    </div>
                </div>
            <?php else: ?>
                <span style="color:#ccc;font-size:11px;">Sin notas</span>
            <?php endif; ?>
        </td>
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

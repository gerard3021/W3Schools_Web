<h1>Editar Orden #<?= esc($item['OrderID']) ?></h1>
<?php if (!empty($errores)): ?><div class="error-lista"><?php foreach ($errores as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?></div><?php endif; ?>
<form action="<?= base_url('orders/update/' . $item['OrderID']) ?>" method="post">
    <?= csrf_field() ?>
    <div class="campo"><label>Cliente:*</label>
        <select name="CustomerID" required>
            <option value="">-- Seleccionar --</option>
            <?php foreach ($customers as $c): ?>
            <option value="<?= $c['CustomerID'] ?>" <?= ($item['CustomerID'] == $c['CustomerID'] ? 'selected' : '') ?>><?= esc($c['CustomerName']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="campo"><label>Empleado:*</label>
        <select name="EmployeeID" required>
            <option value="">-- Seleccionar --</option>
            <?php foreach ($employees as $e): ?>
            <option value="<?= $e['EmployeeID'] ?>" <?= ($item['EmployeeID'] == $e['EmployeeID'] ? 'selected' : '') ?>><?= esc($e['LastName'] . ', ' . $e['FirstName']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="campo"><label>Fecha de Orden:*</label><input type="date" name="OrderDate" value="<?= esc($item['OrderDate']) ?>" required></div>
    <div class="campo"><label>Empresa Envío:*</label>
        <select name="ShipperID" required>
            <option value="">-- Seleccionar --</option>
            <?php foreach ($shippers as $s): ?>
            <option value="<?= $s['ShipperID'] ?>" <?= ($item['ShipperID'] == $s['ShipperID'] ? 'selected' : '') ?>><?= esc($s['ShipperName']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <br><input type="submit" value="Actualizar">&nbsp;<a href="<?= base_url('orders') ?>" class="btn btn-gray">Cancelar</a>
</form>

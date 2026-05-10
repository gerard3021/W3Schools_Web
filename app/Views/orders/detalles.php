<?php if (session()->getFlashdata('mensaje')): ?>
<div class="alerta"><?= session()->getFlashdata('mensaje') ?></div>
<?php endif; ?>

<?php $o = $orden; $total = 0; ?>

<div class="top-bar">
    <h1>Orden #<?= esc($orderId) ?></h1>
    <div style="display:flex;gap:8px;">
        <a href="<?= base_url('orders/editar/' . $orderId) ?>" class="btn btn-blue">Editar orden</a>
        <a href="<?= base_url('orders') ?>" class="btn btn-gray">← Volver</a>
    </div>
</div>

<div style="background:#f0faf4;border:1px solid #c3e6cb;border-radius:6px;padding:12px 18px;margin-bottom:22px;display:flex;gap:32px;flex-wrap:wrap;">
    <div><strong>Fecha:</strong> <?= esc($o['OrderDate']) ?></div>
    <div><strong>Cliente ID:</strong> <?= esc($o['CustomerID']) ?></div>
    <div><strong>Empleado ID:</strong> <?= esc($o['EmployeeID']) ?></div>
    <div><strong>Shipper ID:</strong> <?= esc($o['ShipperID']) ?></div>
</div>

<h2 style="margin-bottom:12px;">Productos en esta orden</h2>
<table>
    <thead>
        <tr><th>#</th><th>Producto</th><th>Cantidad</th><th>Precio Unit.</th><th>Subtotal</th></tr>
    </thead>
    <tbody>
    <?php if (!empty($detalles)): ?>
        <?php foreach ($detalles as $d): $total += $d['Subtotal']; ?>
        <tr>
            <td><?= esc($d['OrderDetailID']) ?></td>
            <td><?= esc($d['ProductName']) ?></td>
            <td><?= esc($d['Quantity']) ?></td>
            <td>$ <?= number_format($d['Price'], 2) ?></td>
            <td>$ <?= number_format($d['Subtotal'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
        <tr style="font-weight:bold;background:#e8f5ee">
            <td colspan="4" style="text-align:right">TOTAL:</td>
            <td>$ <?= number_format($total, 2) ?></td>
        </tr>
    <?php else: ?>
        <tr><td colspan="5" style="color:#888;font-style:italic">Esta orden no tiene productos aún.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

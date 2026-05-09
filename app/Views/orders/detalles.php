<?php if (session()->getFlashdata('mensaje')): ?>
<div class="alerta"><?= session()->getFlashdata('mensaje') ?></div>
<?php endif; ?>

<?php $o = $orden; $total = 0; ?>

<div class="top-bar">
    <h1>Orden #<?= esc($orderId) ?></h1>
    <a href="<?= base_url('orders') ?>" class="btn btn-gray">← Volver a Órdenes</a>
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
        <tr><th>#</th><th>Producto</th><th>Cantidad</th><th>Precio Unit.</th><th>Subtotal</th><th>Acciones</th></tr>
    </thead>
    <tbody>
    <?php if (!empty($detalles)): ?>
        <?php foreach ($detalles as $d): $total += $d['Subtotal']; ?>
        <tr <?= ($editando && $editando['OrderDetailID'] == $d['OrderDetailID']) ? 'style="background:#fff8e1"' : '' ?>>
            <td><?= esc($d['OrderDetailID']) ?></td>

            <?php if ($editando && $editando['OrderDetailID'] == $d['OrderDetailID']): ?>
            <form action="<?= base_url('orders/detalle_update/' . $orderId . '/' . $d['OrderDetailID']) ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="ProductID" value="<?= esc($editando['ProductID']) ?>">
                <td><strong><?= esc($d['ProductName']) ?></strong></td>
                <td>
                    <input type="number" name="Quantity" id="edit_qty" min="1"
                        value="<?= esc($editando['Quantity']) ?>"
                        oninput="recalcEdit()" required style="width:70px">
                </td>
                <td id="edit_price">$ <?= number_format($d['Price'], 2) ?></td>
                <td id="edit_subtotal">$ <?= number_format($d['Subtotal'], 2) ?></td>
                <td>
                    <input type="submit" value="Guardar" class="btn btn-green btn-sm" style="border:none;cursor:pointer">
                    <a href="<?= base_url('orders/detalles/' . $orderId) ?>" class="btn btn-gray btn-sm">Cancelar</a>
                </td>
            </form>

            <?php else: ?>
            <td><?= esc($d['ProductName']) ?></td>
            <td><?= esc($d['Quantity']) ?></td>
            <td>$ <?= number_format($d['Price'], 2) ?></td>
            <td>$ <?= number_format($d['Subtotal'], 2) ?></td>
            <td>
                <a class="btn btn-blue btn-sm" href="<?= base_url('orders/detalle_editar/' . $orderId . '/' . $d['OrderDetailID']) ?>">Editar</a>
                <a class="btn btn-red btn-sm"
                   href="<?= base_url('orders/detalle_delete/' . $orderId . '/' . $d['OrderDetailID']) ?>"
                   onclick="return confirm('¿Eliminar este producto de la orden?')">Eliminar</a>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
        <tr style="font-weight:bold;background:#e8f5ee">
            <td colspan="4" style="text-align:right">TOTAL:</td>
            <td>$ <?= number_format($total, 2) ?></td>
            <td></td>
        </tr>
    <?php else: ?>
        <tr><td colspan="6" style="color:#888;font-style:italic">Esta orden no tiene productos aún.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<?php if (!$editando):
    $disponibles = array_values(array_filter($products, function($p) use ($productos_usados) {
        return !in_array((int)$p['ProductID'], array_map('intval', $productos_usados));
    }));
?>
<div style="margin-top:28px;padding:18px 20px;background:#f8f9fa;border:1px solid #dee2e6;border-radius:6px;">
    <h2 style="margin-bottom:14px;">Agregar producto a la orden</h2>

    <?php if (empty($disponibles)): ?>
        <p style="color:#888;font-style:italic">Todos los productos ya están en esta orden.</p>
    <?php else: ?>
    <form action="<?= base_url('orders/detalle_store/' . $orderId) ?>" method="post">
        <?= csrf_field() ?>
        <div style="display:flex;gap:16px;align-items:flex-end;flex-wrap:wrap;">
            <div>
                <label style="display:block;font-weight:bold;margin-bottom:4px;">Producto:</label>
                <select name="ProductID" id="add_product" required
                    style="min-width:220px;padding:6px 9px;border:1px solid #ccc;border-radius:4px;"
                    onchange="recalcAdd()">
                    <option value="" data-price="0">-- Seleccionar --</option>
                    <?php foreach ($disponibles as $p): ?>
                    <option value="<?= $p['ProductID'] ?>" data-price="<?= $p['Price'] ?>">
                        <?= esc($p['ProductName']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label style="display:block;font-weight:bold;margin-bottom:4px;">Cantidad:</label>
                <input type="number" name="Quantity" id="add_qty" min="1" value="1" required
                    style="width:80px;padding:6px 9px;border:1px solid #ccc;border-radius:4px;"
                    oninput="recalcAdd()">
            </div>
            <div>
                <label style="display:block;font-weight:bold;margin-bottom:4px;">Precio Unit.:</label>
                <span id="add_price" style="display:inline-block;padding:6px 0;color:#555;">$ 0.00</span>
            </div>
            <div>
                <label style="display:block;font-weight:bold;margin-bottom:4px;">Subtotal:</label>
                <span id="add_subtotal" style="display:inline-block;padding:6px 0;font-size:15px;font-weight:bold;color:#04AA6D;">$ 0.00</span>
            </div>
            <div>
                <input type="submit" value="+ Agregar"
                    style="padding:7px 18px;background:#04AA6D;color:white;border:none;border-radius:4px;font-size:14px;cursor:pointer;">
            </div>
        </div>
    </form>
    <?php endif; ?>
</div>
<?php endif; ?>

<script>
function recalcAdd() {
    const sel   = document.getElementById('add_product');
    const qty   = parseFloat(document.getElementById('add_qty').value) || 0;
    const price = parseFloat(sel.options[sel.selectedIndex]?.dataset?.price || 0);
    document.getElementById('add_price').textContent    = '$ ' + price.toFixed(2);
    document.getElementById('add_subtotal').textContent = '$ ' + (price * qty).toFixed(2);
}
<?php if ($editando):
    $precioEdit = 0;
    foreach ($detalles as $d) {
        if ($d['OrderDetailID'] == $editando['OrderDetailID']) {
            $precioEdit = (float)$d['Price'];
            break;
        }
    }
?>
const editPrice = <?= $precioEdit ?>;
function recalcEdit() {
    const qty = parseFloat(document.getElementById('edit_qty')?.value) || 0;
    document.getElementById('edit_price').textContent    = '$ ' + editPrice.toFixed(2);
    document.getElementById('edit_subtotal').textContent = '$ ' + (editPrice * qty).toFixed(2);
}
window.addEventListener('DOMContentLoaded', recalcEdit);
<?php endif; ?>
</script>

<h1>Nueva Orden</h1>
<?php if (!empty($errores)): ?><div class="error-lista"><?php foreach ($errores as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?></div><?php endif; ?>
<form action="<?= base_url('orders/store') ?>" method="post" id="order-form" data-testid="order-create-form">
    <?= csrf_field() ?>
    <div class="campo"><label>Cliente:*</label>
        <select name="CustomerID" required data-testid="order-customer-select">
            <option value="">-- Seleccionar --</option>
            <?php foreach ($customers as $c): ?>
            <option value="<?= $c['CustomerID'] ?>" <?= (($old['CustomerID'] ?? '') == $c['CustomerID'] ? 'selected' : '') ?>><?= esc($c['CustomerName']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="campo"><label>Empleado:*</label>
        <select name="EmployeeID" required data-testid="order-employee-select">
            <option value="">-- Seleccionar --</option>
            <?php foreach ($employees as $e): ?>
            <option value="<?= $e['EmployeeID'] ?>" <?= (($old['EmployeeID'] ?? '') == $e['EmployeeID'] ? 'selected' : '') ?>><?= esc($e['LastName'] . ', ' . $e['FirstName']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="campo">
        <label>Fecha de Orden:</label>
        <span style="padding:6px 0;display:inline-block;color:#555;"><?= date('Y-m-d') ?></span>
        <input type="hidden" name="OrderDate" value="<?= date('Y-m-d') ?>" data-testid="order-date-input">
    </div>
    <div class="campo"><label>Empresa Envío:*</label>
        <select name="ShipperID" required data-testid="order-shipper-select">
            <option value="">-- Seleccionar --</option>
            <?php foreach ($shippers as $s): ?>
            <option value="<?= $s['ShipperID'] ?>" <?= (($old['ShipperID'] ?? '') == $s['ShipperID'] ? 'selected' : '') ?>><?= esc($s['ShipperName']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div style="margin-top:28px;padding:18px 20px;background:#f8f9fa;border:1px solid #dee2e6;border-radius:6px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
            <h2 style="margin:0">Productos de la orden</h2>
            <button type="button" id="add-row-btn" data-testid="add-product-row-btn"
                style="padding:7px 16px;background:#04AA6D;color:white;border:none;border-radius:4px;font-size:14px;cursor:pointer;">
                + Agregar producto
            </button>
        </div>

        <table id="products-table" data-testid="order-products-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th style="width:110px">Cantidad</th>
                    <th style="width:130px">Precio Unit.</th>
                    <th style="width:130px">Subtotal</th>
                    <th style="width:90px">Acción</th>
                </tr>
            </thead>
            <tbody id="products-tbody">
                <?php
                $oldProducts   = $old['ProductID']  ?? [];
                $oldQuantities = $old['Quantity']   ?? [];
                $rowCount      = max(count($oldProducts), 1);
                for ($i = 0; $i < $rowCount; $i++):
                    $selProd = $oldProducts[$i]   ?? '';
                    $selQty  = $oldQuantities[$i] ?? 1;
                ?>
                <tr class="product-row">
                    <td>
                        <select name="ProductID[]" class="product-select" required
                                style="min-width:220px;padding:6px 9px;border:1px solid #ccc;border-radius:4px;">
                            <option value="" data-price="0">-- Seleccionar --</option>
                            <?php foreach ($products as $p): ?>
                            <option value="<?= $p['ProductID'] ?>" data-price="<?= $p['Price'] ?>"
                                <?= ($selProd == $p['ProductID']) ? 'selected' : '' ?>>
                                <?= esc($p['ProductName']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="Quantity[]" class="product-qty" min="1"
                               value="<?= esc($selQty) ?>" required
                               style="width:80px;padding:6px 9px;border:1px solid #ccc;border-radius:4px;">
                    </td>
                    <td class="product-price">$ 0.00</td>
                    <td class="product-subtotal" style="font-weight:bold;color:#04AA6D;">$ 0.00</td>
                    <td>
                        <button type="button" class="remove-row-btn btn btn-red btn-sm"
                                style="border:none;cursor:pointer">Quitar</button>
                    </td>
                </tr>
                <?php endfor; ?>
            </tbody>
            <tfoot>
                <tr style="font-weight:bold;background:#e8f5ee">
                    <td colspan="3" style="text-align:right">TOTAL:</td>
                    <td id="grand-total" data-testid="order-grand-total">$ 0.00</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <p style="color:#666;font-size:13px;margin-top:8px;">
            Debes agregar al menos un producto.
        </p>
    </div>

    <br>
    <input type="submit" value="Registrar" data-testid="order-submit-btn">&nbsp;
    <a href="<?= base_url('orders') ?>" class="btn btn-gray">Cancelar</a>
</form>

<script>
(function () {
    const tbody = document.getElementById('products-tbody');

    const allProducts = [];
    document.querySelectorAll('#products-tbody .product-row:first-child .product-select option').forEach(opt => {
        if (opt.value) allProducts.push({ id: opt.value, name: opt.textContent.trim(), price: opt.dataset.price });
    });

    function getSelectedIds() {
        const ids = [];
        tbody.querySelectorAll('.product-select').forEach(sel => {
            if (sel.value) ids.push(sel.value);
        });
        return ids;
    }

    function refreshOptions() {
        const selectedIds = getSelectedIds();
        tbody.querySelectorAll('.product-row').forEach(row => {
            const sel = row.querySelector('.product-select');
            const currentVal = sel.value;

            while (sel.options.length > 0) sel.remove(0);
            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.dataset.price = '0';
            placeholder.textContent = '-- Seleccionar --';
            sel.appendChild(placeholder);
            allProducts.forEach(p => {
                if (p.id === currentVal || !selectedIds.includes(p.id)) {
                    const opt = document.createElement('option');
                    opt.value = p.id;
                    opt.dataset.price = p.price;
                    opt.textContent = p.name;
                    if (p.id === currentVal) opt.selected = true;
                    sel.appendChild(opt);
                }
            });
        });
    }

    function recalcRow(row) {
        const sel   = row.querySelector('.product-select');
        const qty   = parseFloat(row.querySelector('.product-qty').value) || 0;
        const price = parseFloat(sel.options[sel.selectedIndex]?.dataset?.price || 0);
        row.querySelector('.product-price').textContent    = '$ ' + price.toFixed(2);
        row.querySelector('.product-subtotal').textContent = '$ ' + (price * qty).toFixed(2);
    }

    function recalcAll() {
        let total = 0;
        tbody.querySelectorAll('.product-row').forEach(row => {
            recalcRow(row);
            const sel   = row.querySelector('.product-select');
            const qty   = parseFloat(row.querySelector('.product-qty').value) || 0;
            const price = parseFloat(sel.options[sel.selectedIndex]?.dataset?.price || 0);
            total += price * qty;
        });
        document.getElementById('grand-total').textContent = '$ ' + total.toFixed(2);
    }

    function bindRow(row) {
        row.querySelector('.product-select').addEventListener('change', () => {
            refreshOptions();
            recalcAll();
        });
        row.querySelector('.product-qty').addEventListener('input', recalcAll);
        row.querySelector('.remove-row-btn').addEventListener('click', () => {
            if (tbody.querySelectorAll('.product-row').length <= 1) {
                alert('Debe haber al menos un producto.');
                return;
            }
            row.remove();
            refreshOptions();
            recalcAll();
        });
    }

    document.getElementById('add-row-btn').addEventListener('click', () => {
        const first = tbody.querySelector('.product-row');
        const clone = first.cloneNode(true);
        clone.querySelector('.product-select').value = '';
        clone.querySelector('.product-qty').value    = 1;
        clone.querySelector('.product-price').textContent    = '$ 0.00';
        clone.querySelector('.product-subtotal').textContent = '$ 0.00';
        tbody.appendChild(clone);
        bindRow(clone);
        refreshOptions();
        recalcAll();
    });

    tbody.querySelectorAll('.product-row').forEach(bindRow);
    refreshOptions();
    recalcAll();

    document.getElementById('order-form').addEventListener('submit', (ev) => {
        const rows = tbody.querySelectorAll('.product-row');
        if (rows.length === 0) {
            ev.preventDefault();
            alert('Debes agregar al menos un producto.');
            return;
        }
        const ids = [];
        for (const r of rows) {
            const v = r.querySelector('.product-select').value;
            if (!v) {
                ev.preventDefault();
                alert('Debes seleccionar un producto en cada fila.');
                return;
            }
            ids.push(v);
        }
        if (ids.length === 0) {
            ev.preventDefault();
            alert('Debes seleccionar al menos un producto.');
        }
    });
})();
</script>

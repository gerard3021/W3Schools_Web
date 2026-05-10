<h1>Editar Empleado</h1>
<?php if (!empty($errores)): ?>
<div class="error-lista"><?php foreach ($errores as $e): ?><div>• <?= esc($e) ?></div><?php endforeach; ?></div>
<?php endif; ?>
<form action="<?= base_url('employees/update/' . $item['EmployeeID']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="campo"><label>Apellido: *</label><input type="text" name="LastName" value="<?= esc($item['LastName']) ?>" required></div>
    <div class="campo"><label>Nombre: *</label><input type="text" name="FirstName" value="<?= esc($item['FirstName']) ?>" required></div>
    <div class="campo"><label>Fecha de Nacimiento: *</label><input type="date" name="BirthDate" value="<?= esc($item['BirthDate']) ?>" required></div>
    <div class="campo"><label>Notas: </label><textarea name="Notes" required><?= esc($item['Notes']) ?></textarea></div>
    <div class="campo">
        <label>Foto:</label>
        <div>
            <?php if (!empty($item['Photo'])): ?>
            <div style="margin-bottom:8px;">
                <img src="<?= base_url('uploads/' . esc($item['Photo'])) ?>"
                     style="max-width:120px;max-height:120px;border-radius:6px;border:1px solid #ccc;"
                     onerror="this.style.display='none'">
                <p style="font-size:12px;color:#888;margin-top:4px;">Foto actual</p>
            </div>
            <?php endif; ?>
            <input type="file" name="Photo" id="fotoInput" accept="image/*" onchange="previsualizarFoto(this)">
            <div id="preview" style="margin-top:8px;display:none;">
                <img id="previewImg" src="" style="max-width:150px;max-height:150px;border-radius:6px;border:1px solid #ccc;">
                <p style="font-size:12px;color:#04AA6D;margin-top:4px;">Nueva foto seleccionada</p>
            </div>
            <small style="color:#888;display:block;margin-top:4px;">Dejar vacío para conservar la foto actual. JPG, PNG</small>
        </div>
    </div>
    <br>
    <input type="submit" value="Actualizar">
    &nbsp;<a href="<?= base_url('employees') ?>" class="btn btn-gray">Cancelar</a>
</form>
<script>
function previsualizarFoto(input) {
    const preview = document.getElementById('preview');
    const img = document.getElementById('previewImg');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

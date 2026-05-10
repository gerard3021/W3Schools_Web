<h1>Nuevo Empleado</h1>
<?php if (!empty($errores)): ?>
<div class="error-lista"><?php foreach ($errores as $e): ?><div>• <?= esc($e) ?></div><?php endforeach; ?></div>
<?php endif; ?>
<form action="<?= base_url('employees/store') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="campo"><label>Apellido: *</label><input type="text" name="LastName" value="<?= esc($old['LastName'] ?? '') ?>" required></div>
    <div class="campo"><label>Nombre: *</label><input type="text" name="FirstName" value="<?= esc($old['FirstName'] ?? '') ?>" required></div>
    <div class="campo"><label>Fecha de Nacimiento: *</label><input type="date" name="BirthDate" value="<?= esc($old['BirthDate'] ?? '') ?>" required></div>
    <div class="campo"><label>Notas: </label><textarea name="Notes" required><?= esc($old['Notes'] ?? '') ?></textarea></div>
    <div class="campo">
        <label>Foto: </label>
        <div>
            <input type="file" name="Photo" id="fotoInput" accept="image/*" required onchange="previsualizarFoto(this)">
            <div id="preview" style="margin-top:8px;display:none;">
                <img id="previewImg" src="" style="max-width:150px;max-height:150px;border-radius:6px;border:1px solid #ccc;">
            </div>
            <small style="color:#888;display:block;margin-top:4px;">JPG, PNG, GIF</small>
        </div>
    </div>
    <br>
    <input type="submit" value="Registrar">
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

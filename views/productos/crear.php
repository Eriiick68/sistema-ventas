<?php
$pageTitle = 'Agregar Producto – Sistema de Ventas';
require 'views/layout/header.php';

// Recuperar valores previos si hubo error
$vNombre      = htmlspecialchars($_POST['nombre']      ?? '');
$vDescripcion = htmlspecialchars($_POST['descripcion'] ?? '');
$vPrecio      = htmlspecialchars($_POST['precio']      ?? '');
$vStock       = htmlspecialchars($_POST['stock']       ?? '');
?>

<div class="row justify-content-center">
<div class="col-lg-6">

<div class="d-flex align-items-center mb-4">
    <a href="index.php?controller=productos" class="btn btn-outline-secondary btn-sm me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h2 class="mb-0"><i class="bi bi-plus-circle text-primary"></i> Agregar Producto</h2>
</div>

<?php if (!empty($errores)): ?>
<div class="alert alert-danger">
    <strong><i class="bi bi-exclamation-triangle-fill"></i> Corrige los siguientes errores:</strong>
    <ul class="mb-0 mt-2">
        <?php foreach ($errores as $e): ?>
            <li><?= $e ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-box-seam"></i> Datos del producto
    </div>
    <div class="card-body p-4">
        <form method="POST" action="index.php?controller=productos&action=guardar" novalidate>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="nombre" class="form-control"
                       placeholder="Ej. Laptop Lenovo"
                       value="<?= $vNombre ?>" maxlength="120">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Descripción <span class="text-danger">*</span></label>
                <textarea name="descripcion" class="form-control" rows="3"
                          placeholder="Breve descripción del producto"><?= $vDescripcion ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Precio (MXN) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" name="precio" class="form-control"
                               placeholder="0.00" step="0.01" min="0.01"
                               value="<?= $vPrecio ?>">
                    </div>
                    <div class="form-text">Debe ser un número mayor a 0.</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Stock inicial</label>
                    <input type="number" name="stock" class="form-control"
                           placeholder="0" min="0" step="1"
                           value="<?= $vStock ?>">
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-save2"></i> Guardar Producto
                </button>
                <a href="index.php?controller=productos" class="btn btn-outline-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

</div>
</div>

<?php require 'views/layout/footer.php'; ?>

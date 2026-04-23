<?php
$pageTitle = 'Productos – Sistema de Ventas';
require 'views/layout/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-box-seam text-primary"></i> Catálogo de Productos</h2>
    <a href="index.php?controller=productos&action=crear" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Agregar Producto
    </a>
</div>

<?php if (isset($_GET['exito'])): ?>
<div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-check-circle-fill"></i> Producto registrado exitosamente.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (isset($_GET['eliminado'])): ?>
<div class="alert alert-info alert-dismissible fade show">
    <i class="bi bi-trash3"></i> Producto eliminado.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header bg-primary text-white py-3">
        <i class="bi bi-list-ul"></i> Lista de productos disponibles
        <span class="badge bg-light text-primary ms-2"><?= count($productos) ?> productos</span>
    </div>
    <div class="card-body p-0">
        <?php if (empty($productos)): ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox" style="font-size:3rem;"></i>
                <p class="mt-2">No hay productos registrados aún.</p>
                <a href="index.php?controller=productos&action=crear" class="btn btn-primary">
                    Agregar el primero
                </a>
            </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class="text-end">Precio</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($productos as $p): ?>
                    <tr>
                        <td class="text-muted"><?= $p['id'] ?></td>
                        <td><strong><?= htmlspecialchars($p['nombre']) ?></strong></td>
                        <td class="text-muted" style="max-width:280px;">
                            <?= htmlspecialchars($p['descripcion']) ?>
                        </td>
                        <td class="text-end">
                            <span class="badge bg-success badge-precio">
                                $<?= number_format($p['precio'], 2) ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <?php
                            $stockBadge = $p['stock'] > 10 ? 'bg-primary' : ($p['stock'] > 0 ? 'bg-warning text-dark' : 'bg-danger');
                            ?>
                            <span class="badge <?= $stockBadge ?>"><?= $p['stock'] ?></span>
                        </td>
                        <td class="text-center">
                            <a href="index.php?controller=productos&action=eliminar&id=<?= $p['id'] ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('¿Eliminar «<?= htmlspecialchars($p['nombre']) ?>»?')">
                                <i class="bi bi-trash3"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require 'views/layout/footer.php'; ?>

<?php
$pageTitle = 'Ventas – Sistema de Ventas';
require 'views/layout/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-receipt text-primary"></i> Historial de Ventas</h2>
    <a href="index.php?controller=ventas&action=nueva" class="btn btn-warning">
        <i class="bi bi-plus-lg"></i> Nueva Venta
    </a>
</div>

<div class="card">
    <div class="card-header bg-primary text-white py-3">
        <i class="bi bi-clock-history"></i> Todas las ventas registradas
        <span class="badge bg-light text-primary ms-2"><?= count($ventas) ?> registros</span>
    </div>
    <div class="card-body p-0">
        <?php if (empty($ventas)): ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-receipt" style="font-size:3rem;"></i>
                <p class="mt-2">No hay ventas registradas aún.</p>
                <a href="index.php?controller=ventas&action=nueva" class="btn btn-warning">
                    Registrar primera venta
                </a>
            </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Folio</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th class="text-center">Productos</th>
                        <th class="text-end">Subtotal</th>
                        <th class="text-end">IVA (16%)</th>
                        <th class="text-end">Total</th>
                        <th class="text-center">Detalle</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($ventas as $v): ?>
                    <tr>
                        <td><span class="badge bg-secondary">#<?= str_pad($v['id'], 4, '0', STR_PAD_LEFT) ?></span></td>
                        <td><?= htmlspecialchars($v['cliente']) ?></td>
                        <td class="text-muted" style="font-size:.9rem;">
                            <?= date('d/m/Y H:i', strtotime($v['fecha'])) ?>
                        </td>
                        <td class="text-center"><?= $v['num_productos'] ?></td>
                        <td class="text-end">$<?= number_format($v['subtotal'], 2) ?></td>
                        <td class="text-end text-muted">$<?= number_format($v['iva'], 2) ?></td>
                        <td class="text-end fw-bold text-success">$<?= number_format($v['total'], 2) ?></td>
                        <td class="text-center">
                            <a href="index.php?controller=ventas&action=detalle&id=<?= $v['id'] ?>"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
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

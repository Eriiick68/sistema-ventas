<?php
$pageTitle = 'Detalle de Venta #' . $venta['id'];
require 'views/layout/header.php';
?>

<div class="row justify-content-center">
<div class="col-lg-6">

<div class="d-flex align-items-center mb-4">
    <a href="index.php?controller=ventas" class="btn btn-outline-secondary btn-sm me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h2 class="mb-0">
        <i class="bi bi-receipt-cutoff text-success"></i>
        Venta #<?= str_pad($venta['id'], 4, '0', STR_PAD_LEFT) ?>
    </h2>
</div>

<!-- Ticket -->
<div class="ticket p-4">
    <div class="text-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-shop"></i> SistemaVentas</h4>
        <small class="text-muted">Comprobante de venta</small>
        <hr>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <div class="text-muted small">Cliente</div>
            <div class="fw-semibold"><?= htmlspecialchars($venta['cliente']) ?></div>
        </div>
        <div class="col-6 text-end">
            <div class="text-muted small">Fecha</div>
            <div><?= date('d/m/Y H:i', strtotime($venta['fecha'])) ?></div>
        </div>
    </div>

    <table class="table table-sm">
        <thead class="table-light">
            <tr>
                <th>Producto</th>
                <th class="text-center">Cant.</th>
                <th class="text-end">P. Unit.</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($venta['detalle'] as $d): ?>
            <tr>
                <td><?= htmlspecialchars($d['nombre']) ?></td>
                <td class="text-center"><?= $d['cantidad'] ?></td>
                <td class="text-end">$<?= number_format($d['precio_unit'], 2) ?></td>
                <td class="text-end">$<?= number_format($d['subtotal'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end text-muted">Subtotal:</td>
                <td class="text-end">$<?= number_format($venta['subtotal'], 2) ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text-end text-muted">IVA (16%):</td>
                <td class="text-end">$<?= number_format($venta['iva'], 2) ?></td>
            </tr>
            <tr class="table-success">
                <td colspan="3" class="text-end fw-bold">TOTAL:</td>
                <td class="text-end fw-bold fs-5">$<?= number_format($venta['total'], 2) ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="text-center mt-3">
        <small class="text-muted">¡Gracias por su compra! — IVA incluido al 16%</small>
    </div>
</div>

<div class="d-grid gap-2 mt-3">
    <a href="index.php?controller=ventas&action=nueva" class="btn btn-warning">
        <i class="bi bi-plus-circle"></i> Nueva Venta
    </a>
    <a href="index.php?controller=ventas" class="btn btn-outline-secondary">
        Ver todas las ventas
    </a>
</div>

</div>
</div>

<?php require 'views/layout/footer.php'; ?>

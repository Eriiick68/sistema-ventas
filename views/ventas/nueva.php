<?php
$pageTitle = 'Nueva Venta – Sistema de Ventas';
require 'views/layout/header.php';

$old = $old ?? [
    'cliente' => '',
    'producto_id' => [],
    'cantidad' => []
];
?>  

<div class="row">
<div class="col-lg-8">

<div class="d-flex align-items-center mb-4">
    <a href="index.php?controller=ventas" class="btn btn-outline-secondary btn-sm me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h2 class="mb-0"><i class="bi bi-cart-plus text-warning"></i> Nueva Venta</h2>
</div>

<?php if (!empty($errores)): ?>
<div class="alert alert-danger">
    <strong>Errores encontrados:</strong>
    <ul class="mb-0 mt-2">
        <?php foreach ($errores as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form method="POST" action="index.php?controller=ventas&action=registrar" id="formVenta">

<!-- CLIENTE -->
<div class="card mb-4">
    <div class="card-header bg-warning text-dark">Datos del cliente</div>
    <div class="card-body">
        <label class="form-label fw-semibold">Nombre del cliente *</label>
        <input type="text" name="cliente" class="form-control"
               value="<?= htmlspecialchars($old['cliente']) ?>">
    </div>
</div>

<!-- PRODUCTOS -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between">
        <span>Productos</span>
        <button type="button" class="btn btn-sm btn-light" id="btnAgregar">
            + Agregar
        </button>
    </div>
    <div class="card-body">
        <div id="lineas"></div>
        <p id="sinProductos" class="text-muted text-center">
            Agrega productos
        </p>
    </div>
</div>

<!-- RESUMEN -->
<div class="card mb-4">
    <div class="card-header bg-success text-white">Resumen</div>
    <div class="card-body">
        <p>Subtotal: <span id="resSubtotal">$0.00</span></p>
        <p>IVA: <span id="resIva">$0.00</span></p>
        <p><strong>Total: <span id="resTotal">$0.00</span></strong></p>

        <button type="submit" class="btn btn-success" id="btnRegistrar" disabled>
            Registrar Venta
        </button>
    </div>
</div>

</form> 

</div>

<!-- SIDEBAR -->
<div class="col-lg-4">
<div class="card">
    <div class="card-header">Productos</div>
    <div class="card-body">
        <ul>
        <?php foreach ($productos as $p): ?>
            <li><?= htmlspecialchars($p['nombre']) ?> ($<?= $p['precio'] ?>)</li>
        <?php endforeach; ?>
        </ul>
    </div>
</div>
</div>

</div>

<!-- TEMPLATE -->
<template id="tplLinea">
<div class="linea-producto mb-2">
    <select name="producto_id[]" class="sel-producto">
        <option value="">Selecciona</option>
        <?php foreach ($productos as $p): ?>
        <option value="<?= $p['id'] ?>" data-precio="<?= $p['precio'] ?>">
            <?= $p['nombre'] ?>
        </option>
        <?php endforeach; ?>
    </select>

    <input type="number" name="cantidad[]" value="1" class="inp-cantidad">
    <span class="sub-linea">$0</span>
    <button type="button" class="btn-eliminar-linea">X</button>
</div>
</template>

<script>
const IVA = 0.16;
const lineasContainer = document.getElementById('lineas');
const btnRegistrar = document.getElementById('btnRegistrar');

document.getElementById('btnAgregar').addEventListener('click', () => {
    const tpl = document.getElementById('tplLinea').content.cloneNode(true);
    lineasContainer.appendChild(tpl);

    const linea = lineasContainer.lastElementChild;

    linea.querySelector('.sel-producto').addEventListener('change', calcular);
    linea.querySelector('.inp-cantidad').addEventListener('input', calcular);

    linea.querySelector('.btn-eliminar-linea').addEventListener('click', () => {
        linea.remove();
        calcular();
    });

    calcular();
});

function calcular() {
    let subtotal = 0;

    document.querySelectorAll('.linea-producto').forEach(linea => {
        const sel = linea.querySelector('.sel-producto');
        const cant = linea.querySelector('.inp-cantidad').value;
        const precio = sel.selectedOptions[0]?.dataset.precio || 0;

        const sub = precio * cant;
        linea.querySelector('.sub-linea').textContent = '$' + sub;

        subtotal += sub;
    });

    const iva = subtotal * IVA;
    const total = subtotal + iva;

    document.getElementById('resSubtotal').textContent = subtotal;
    document.getElementById('resIva').textContent = iva;
    document.getElementById('resTotal').textContent = total;

    btnRegistrar.disabled = subtotal === 0;
}
</script>

<?php require 'views/layout/footer.php'; ?>

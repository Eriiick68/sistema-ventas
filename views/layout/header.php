<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Sistema de Ventas' ?></title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
        .card-header { border-radius: 12px 12px 0 0 !important; }
        .table thead th { font-size: .85rem; text-transform: uppercase; letter-spacing: .5px; }
        .badge-precio { font-size: .95rem; }
        .ticket { border: 2px dashed #adb5bd; border-radius: 8px; background: #fff; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="index.php">
        <i class="bi bi-shop"></i> SistemaVentas
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link <?= (($_GET['controller'] ?? 'productos') === 'productos') ? 'active fw-bold' : '' ?>"
                   href="index.php?controller=productos">
                    <i class="bi bi-box-seam"></i> Productos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (($_GET['controller'] ?? '') === 'ventas') ? 'active fw-bold' : '' ?>"
                   href="index.php?controller=ventas">
                    <i class="bi bi-receipt"></i> Ventas
                </a>
            </li>
            <li class="nav-item ms-2">
                <a class="btn btn-warning btn-sm mt-1" href="index.php?controller=ventas&action=nueva">
                    <i class="bi bi-plus-circle"></i> Nueva Venta
                </a>
            </li>
        </ul>
    </div>
  </div>
</nav>

<div class="container py-4">

<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/Carrito.php';

// Inicializar el carrito
$carrito = new Carrito();

// Procesar acciones del carrito
if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'agregar':
            if (isset($_POST['producto_id'], $_POST['cantidad'])) {
                $carrito->agregar($_POST['producto_id'], $_POST['cantidad']);
            }
            break;
        case 'actualizar':
            if (isset($_POST['producto_id'], $_POST['cantidad'])) {
                $carrito->actualizarCantidad($_POST['producto_id'], $_POST['cantidad']);
            }
            break;
        case 'eliminar':
            if (isset($_POST['producto_id'])) {
                $carrito->eliminar($_POST['producto_id']);
            }
            break;
        case 'vaciar':
            $carrito->vaciar();
            break;
    }
    
    // Redireccionar para evitar reenvío del formulario
    header('Location: carrito.php');
    exit;
}

include 'includes/header.php';
?>

<div class="container my-5">
    <h1 class="text-center mb-4">Mi Carrito</h1>

    <?php if ($carrito->estaVacio()): ?>
        <div class="text-center">
            <p class="lead">Tu carrito está vacío</p>
            <a href="index.php" class="btn btn-primary">Seguir Comprando</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <?php foreach ($carrito->obtenerItems() as $item): ?>
                            <div class="cart-item mb-4">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="<?php echo $item['imagen']; ?>" alt="<?php echo $item['nombre']; ?>" class="img-fluid rounded">
                                    </div>
                                    <div class="col-md-4">
                                        <h5><?php echo $item['nombre']; ?></h5>
                                        <p class="text-muted">€<?php echo number_format($item['precio'], 2); ?> por unidad</p>
                                    </div>
                                    <div class="col-md-3">
                                        <form action="carrito.php" method="POST" class="d-flex align-items-center">
                                            <input type="hidden" name="accion" value="actualizar">
                                            <input type="hidden" name="producto_id" value="<?php echo $item['id']; ?>">
                                            <input type="number" name="cantidad" value="<?php echo $item['cantidad']; ?>" 
                                                   min="1" max="99" class="form-control me-2" 
                                                   onchange="this.form.submit()">
                                        </form>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <p class="fw-bold">€<?php echo number_format($item['subtotal'], 2); ?></p>
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <form action="carrito.php" method="POST">
                                            <input type="hidden" name="accion" value="eliminar">
                                            <input type="hidden" name="producto_id" value="<?php echo $item['id']; ?>">
                                            <button type="submit" class="btn btn-link text-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Resumen del Pedido</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal</span>
                            <span>€<?php echo number_format($carrito->obtenerSubtotal(), 2); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>IVA (21%)</span>
                            <span>€<?php echo number_format($carrito->obtenerIVA(), 2); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Gastos de envío</span>
                            <span>€<?php echo number_format($carrito->obtenerGastosEnvio(), 2); ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total</strong>
                            <strong>€<?php echo number_format($carrito->obtenerTotal(), 2); ?></strong>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="checkout.php" class="btn btn-primary">Realizar Pedido</a>
                            <form action="carrito.php" method="POST">
                                <input type="hidden" name="accion" value="vaciar">
                                <button type="submit" class="btn btn-outline-danger w-100">Vaciar Carrito</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?> 
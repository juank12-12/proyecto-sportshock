<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/Pedido.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Instanciar la clase Pedido
$pedido = new Pedido($conn);
$pedidos = $pedido->obtenerPorUsuario($usuario_id);

include 'includes/header.php';
?>

<div class="container my-5">
    <h1 class="text-center mb-4">Mis Pedidos</h1>

    <?php if (empty($pedidos)): ?>
        <div class="text-center">
            <p class="lead">No tienes pedidos realizados</p>
            <a href="index.php" class="btn btn-primary">Ir a la Tienda</a>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($pedidos as $pedido): ?>
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Pedido #<?php echo $pedido['id']; ?></h5>
                            <span class="badge bg-<?php 
                                echo $pedido['estado'] == 'Pendiente' ? 'warning' : 
                                    ($pedido['estado'] == 'Completado' ? 'success' : 
                                    ($pedido['estado'] == 'Cancelado' ? 'danger' : 'primary')); 
                            ?>">
                                <?php echo $pedido['estado']; ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])); ?></p>
                                    <p><strong>Dirección de envío:</strong> <?php echo $pedido['direccion_envio']; ?></p>
                                    <p><strong>Método de pago:</strong> <?php echo $pedido['metodo_pago']; ?></p>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <h4 class="text-primary mb-3">Total: €<?php echo number_format($pedido['total'], 2); ?></h4>
                                    <a href="pedido.php?id=<?php echo $pedido['id']; ?>" class="btn btn-outline-primary">
                                        Ver Detalles
                                    </a>
                                    <?php if ($pedido['estado'] == 'Pendiente'): ?>
                                        <form action="cancelar_pedido.php" method="post" class="d-inline">
                                            <input type="hidden" name="pedido_id" value="<?php echo $pedido['id']; ?>">
                                            <button type="submit" class="btn btn-outline-danger ms-2" 
                                                    onclick="return confirm('¿Estás seguro de que deseas cancelar este pedido?')">
                                                Cancelar Pedido
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?> 
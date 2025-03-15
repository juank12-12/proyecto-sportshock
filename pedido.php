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

// Verificar si se proporcionó un ID de pedido
if (!isset($_GET['id'])) {
    header('Location: perfil.php');
    exit;
}

$pedido_id = $_GET['id'];
$usuario_id = $_SESSION['usuario_id'];

// Instanciar la clase Pedido
$pedido = new Pedido($conn);
$detalles_pedido = $pedido->obtenerPorId($pedido_id);

// Verificar si el pedido existe y pertenece al usuario actual
if (!$detalles_pedido || $detalles_pedido['usuario_id'] != $usuario_id) {
    header('Location: perfil.php');
    exit;
}

include 'includes/header.php';
?>

<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Detalles del Pedido #<?php echo $pedido_id; ?></h3>
                    <span class="badge bg-<?php 
                        echo $detalles_pedido['estado'] == 'Pendiente' ? 'warning' : 
                            ($detalles_pedido['estado'] == 'Completado' ? 'success' : 
                            ($detalles_pedido['estado'] == 'Cancelado' ? 'danger' : 'primary')); 
                    ?>">
                        <?php echo $detalles_pedido['estado']; ?>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Información del Pedido</h5>
                            <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($detalles_pedido['fecha_pedido'])); ?></p>
                            <p><strong>Dirección de Envío:</strong> <?php echo $detalles_pedido['direccion_envio']; ?></p>
                            <p><strong>Método de Pago:</strong> <?php echo $detalles_pedido['metodo_pago']; ?></p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h5>Total del Pedido</h5>
                            <h3 class="text-primary">€<?php echo number_format($detalles_pedido['total'], 2); ?></h3>
                        </div>
                    </div>

                    <h5 class="mb-4">Productos</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end">Precio Unitario</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($detalles_pedido['items'] as $item): ?>
                                <tr>
                                    <td><?php echo $item['nombre']; ?></td>
                                    <td class="text-center"><?php echo $item['cantidad']; ?></td>
                                    <td class="text-end">€<?php echo number_format($item['precio'], 2); ?></td>
                                    <td class="text-end">€<?php echo number_format($item['cantidad'] * $item['precio'], 2); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                    <td class="text-end">€<?php echo number_format($detalles_pedido['total'] - ($detalles_pedido['total'] * 0.21), 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>IVA (21%):</strong></td>
                                    <td class="text-end">€<?php echo number_format($detalles_pedido['total'] * 0.21, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td class="text-end"><strong>€<?php echo number_format($detalles_pedido['total'], 2); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <?php if ($detalles_pedido['estado'] == 'Pendiente'): ?>
            <div class="text-end">
                <form action="cancelar_pedido.php" method="post" class="d-inline">
                    <input type="hidden" name="pedido_id" value="<?php echo $pedido_id; ?>">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas cancelar este pedido?')">
                        Cancelar Pedido
                    </button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 
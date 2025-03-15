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

// Verificar si se recibió un ID de pedido
if (!isset($_POST['pedido_id'])) {
    header('Location: perfil.php');
    exit;
}

$pedido_id = $_POST['pedido_id'];
$usuario_id = $_SESSION['usuario_id'];

// Instanciar la clase Pedido
$pedido = new Pedido($conn);
$detalles_pedido = $pedido->obtenerPorId($pedido_id);

// Verificar si el pedido existe, pertenece al usuario actual y está pendiente
if (!$detalles_pedido || 
    $detalles_pedido['usuario_id'] != $usuario_id || 
    $detalles_pedido['estado'] != 'Pendiente') {
    header('Location: perfil.php');
    exit;
}

// Intentar cancelar el pedido
if ($pedido->cancelar($pedido_id)) {
    $_SESSION['mensaje'] = "El pedido #$pedido_id ha sido cancelado correctamente.";
    $_SESSION['tipo_mensaje'] = 'success';
} else {
    $_SESSION['mensaje'] = "Ha ocurrido un error al intentar cancelar el pedido #$pedido_id.";
    $_SESSION['tipo_mensaje'] = 'danger';
}

// Redirigir de vuelta a la página del pedido
header("Location: pedido.php?id=$pedido_id");
exit; 
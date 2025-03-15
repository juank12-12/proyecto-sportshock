<?php
class Carrito {
    private $items = [];
    private $total = 0;
    private $cantidad_items = 0;

    public function __construct() {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        $this->items = &$_SESSION['carrito'];
        $this->actualizarTotales();
    }

    public function agregar($producto_id, $cantidad) {
        global $conn;
        
        // Verificar si el producto existe y obtener sus datos
        $query = "SELECT * FROM productos WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $producto_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        if ($producto = mysqli_fetch_assoc($resultado)) {
            // Si el producto ya está en el carrito, actualizar cantidad
            if (isset($this->items[$producto_id])) {
                $this->items[$producto_id]['cantidad'] += $cantidad;
            } else {
                // Si no, agregar el producto al carrito
                $this->items[$producto_id] = [
                    'id' => $producto_id,
                    'nombre' => $producto['nombre'],
                    'precio' => $producto['precio'],
                    'imagen' => $producto['imagen'],
                    'cantidad' => $cantidad,
                    'subtotal' => $producto['precio'] * $cantidad
                ];
            }
            
            $this->actualizarTotales();
            return true;
        }
        return false;
    }

    public function actualizarCantidad($producto_id, $cantidad) {
        if (isset($this->items[$producto_id])) {
            if ($cantidad <= 0) {
                $this->eliminar($producto_id);
            } else {
                $this->items[$producto_id]['cantidad'] = $cantidad;
                $this->items[$producto_id]['subtotal'] = 
                    $this->items[$producto_id]['precio'] * $cantidad;
                $this->actualizarTotales();
            }
            return true;
        }
        return false;
    }

    public function eliminar($producto_id) {
        if (isset($this->items[$producto_id])) {
            unset($this->items[$producto_id]);
            $this->actualizarTotales();
            return true;
        }
        return false;
    }

    public function vaciar() {
        $this->items = [];
        $_SESSION['carrito'] = [];
        $this->actualizarTotales();
    }

    public function obtenerItems() {
        return $this->items;
    }

    public function obtenerCantidadItems() {
        return $this->cantidad_items;
    }

    public function obtenerSubtotal() {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += $item['subtotal'];
        }
        return $subtotal;
    }

    public function obtenerIVA() {
        return $this->obtenerSubtotal() * 0.21; // 21% IVA
    }

    public function obtenerGastosEnvio() {
        // Envío gratis para pedidos superiores a 50€
        return $this->obtenerSubtotal() > 50 ? 0 : 4.99;
    }

    public function obtenerTotal() {
        return $this->obtenerSubtotal() + $this->obtenerIVA() + $this->obtenerGastosEnvio();
    }

    public function estaVacio() {
        return empty($this->items);
    }

    private function actualizarTotales() {
        $this->cantidad_items = 0;
        foreach ($this->items as $item) {
            $this->cantidad_items += $item['cantidad'];
        }
    }
} 
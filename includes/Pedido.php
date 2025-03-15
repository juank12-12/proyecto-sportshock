<?php
class Pedido {
    private $db;
    private $id;
    private $usuario_id;
    private $fecha_pedido;
    private $estado;
    private $total;
    private $direccion_envio;
    private $metodo_pago;
    private $items = [];

    public function __construct() {
        $this->db = conectarDB();
    }

    // Getters
    public function getId() { return $this->id; }
    public function getUsuarioId() { return $this->usuario_id; }
    public function getFechaPedido() { return $this->fecha_pedido; }
    public function getEstado() { return $this->estado; }
    public function getTotal() { return $this->total; }
    public function getDireccionEnvio() { return $this->direccion_envio; }
    public function getMetodoPago() { return $this->metodo_pago; }
    public function getItems() { return $this->items; }

    // Setters
    public function setUsuarioId($usuario_id) { $this->usuario_id = intval($usuario_id); }
    public function setEstado($estado) { $this->estado = $estado; }
    public function setTotal($total) { $this->total = floatval($total); }
    public function setDireccionEnvio($direccion) { $this->direccion_envio = limpiarDatos($direccion); }
    public function setMetodoPago($metodo) { $this->metodo_pago = limpiarDatos($metodo); }

    // Crear nuevo pedido
    public function crear($datos) {
        try {
            $this->db->beginTransaction();

            // Insertar pedido
            $sql = "INSERT INTO pedidos (usuario_id, estado, total, direccion_envio, metodo_pago) 
                    VALUES (?, ?, ?, ?, ?)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $datos['usuario_id'],
                'pendiente',
                $datos['total'],
                $datos['direccion_envio'],
                $datos['metodo_pago']
            ]);

            $this->id = $this->db->lastInsertId();

            // Insertar items del pedido
            foreach ($datos['items'] as $item) {
                $this->agregarItem($item);
            }

            // Actualizar stock de productos
            foreach ($datos['items'] as $item) {
                $producto = new Producto();
                if (!$producto->actualizarStock($item['producto_id'], $item['cantidad'])) {
                    throw new Exception("No hay suficiente stock para el producto ID: " . $item['producto_id']);
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // Agregar item al pedido
    private function agregarItem($item) {
        $sql = "INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad, precio_unitario, subtotal) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $this->id,
            $item['producto_id'],
            $item['cantidad'],
            $item['precio'],
            $item['cantidad'] * $item['precio']
        ]);
    }

    // Obtener pedido por ID
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM pedidos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($pedido) {
            $this->cargarDatos($pedido);
            $this->cargarItems();
        }

        return $pedido;
    }

    // Cargar datos del pedido
    private function cargarDatos($datos) {
        $this->id = $datos['id'];
        $this->usuario_id = $datos['usuario_id'];
        $this->fecha_pedido = $datos['fecha_pedido'];
        $this->estado = $datos['estado'];
        $this->total = $datos['total'];
        $this->direccion_envio = $datos['direccion_envio'];
        $this->metodo_pago = $datos['metodo_pago'];
    }

    // Cargar items del pedido
    private function cargarItems() {
        $sql = "SELECT dp.*, p.nombre, p.imagen 
                FROM detalles_pedido dp 
                JOIN productos p ON dp.producto_id = p.id 
                WHERE dp.pedido_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$this->id]);
        $this->items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar estado del pedido
    public function actualizarEstado($estado) {
        $estados_validos = ['pendiente', 'procesando', 'enviado', 'entregado', 'cancelado'];
        
        if (!in_array($estado, $estados_validos)) {
            throw new Exception("Estado no válido");
        }

        $sql = "UPDATE pedidos SET estado = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$estado, $this->id]);
    }

    // Cancelar pedido
    public function cancelar() {
        try {
            $this->db->beginTransaction();

            // Actualizar estado a cancelado
            $this->actualizarEstado('cancelado');

            // Devolver stock
            foreach ($this->items as $item) {
                $sql = "UPDATE productos 
                        SET stock = stock + ? 
                        WHERE id = ?";
                
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$item['cantidad'], $item['producto_id']]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // Obtener todos los pedidos (para admin)
    public function obtenerTodos($limite = null) {
        $sql = "SELECT p.*, u.nombre as nombre_usuario, u.email 
                FROM pedidos p 
                JOIN usuarios u ON p.usuario_id = u.id 
                ORDER BY p.fecha_pedido DESC";
        
        if ($limite) {
            $sql .= " LIMIT " . intval($limite);
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener pedidos por usuario
    public function obtenerPorUsuario($usuario_id) {
        $sql = "SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY fecha_pedido DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener estadísticas de pedidos (para admin)
    public function obtenerEstadisticas() {
        $stats = [];

        // Total de ventas
        $sql = "SELECT COUNT(*) as total_pedidos, 
                       SUM(total) as total_ventas 
                FROM pedidos 
                WHERE estado != 'cancelado'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stats['general'] = $stmt->fetch(PDO::FETCH_ASSOC);

        // Ventas por estado
        $sql = "SELECT estado, COUNT(*) as cantidad 
                FROM pedidos 
                GROUP BY estado";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stats['por_estado'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Productos más vendidos
        $sql = "SELECT p.nombre, SUM(dp.cantidad) as total_vendido 
                FROM detalles_pedido dp 
                JOIN productos p ON dp.producto_id = p.id 
                JOIN pedidos pe ON dp.pedido_id = pe.id 
                WHERE pe.estado != 'cancelado' 
                GROUP BY dp.producto_id 
                ORDER BY total_vendido DESC 
                LIMIT 5";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stats['productos_populares'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $stats;
    }
} 
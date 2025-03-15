<?php
class Producto {
    private $db;
    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $imagen;
    private $categoria_id;
    private $destacado;
    private $fecha_creacion;

    public function __construct() {
        $this->db = conectarDB();
    }

    // Getters y Setters
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getDescripcion() { return $this->descripcion; }
    public function getPrecio() { return $this->precio; }
    public function getStock() { return $this->stock; }
    public function getImagen() { return $this->imagen; }
    public function getCategoriaId() { return $this->categoria_id; }
    public function getDestacado() { return $this->destacado; }
    public function getFechaCreacion() { return $this->fecha_creacion; }

    public function setNombre($nombre) { $this->nombre = limpiarDatos($nombre); }
    public function setDescripcion($descripcion) { $this->descripcion = limpiarDatos($descripcion); }
    public function setPrecio($precio) { $this->precio = floatval($precio); }
    public function setStock($stock) { $this->stock = intval($stock); }
    public function setImagen($imagen) { $this->imagen = $imagen; }
    public function setCategoriaId($categoria_id) { $this->categoria_id = intval($categoria_id); }
    public function setDestacado($destacado) { $this->destacado = (bool)$destacado; }

    // Obtener todos los productos
    public function obtenerTodos($limite = null) {
        $sql = "SELECT * FROM productos ORDER BY fecha_creacion DESC";
        if ($limite) {
            $sql .= " LIMIT " . intval($limite);
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener productos destacados
    public function obtenerDestacados($limite = 4) {
        $sql = "SELECT * FROM productos WHERE destacado = 1 ORDER BY fecha_creacion DESC LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limite]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener producto por ID
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM productos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener productos por categoría
    public function obtenerPorCategoria($categoria_id, $limite = null) {
        $sql = "SELECT * FROM productos WHERE categoria_id = ? ORDER BY fecha_creacion DESC";
        if ($limite) {
            $sql .= " LIMIT " . intval($limite);
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoria_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar productos
    public function buscar($termino) {
        $termino = "%$termino%";
        $sql = "SELECT * FROM productos WHERE nombre LIKE ? OR descripcion LIKE ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$termino, $termino]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Guardar producto
    public function guardar() {
        if ($this->id) {
            return $this->actualizar();
        } else {
            return $this->crear();
        }
    }

    // Crear nuevo producto
    private function crear() {
        $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen, categoria_id, destacado) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $resultado = $stmt->execute([
            $this->nombre,
            $this->descripcion,
            $this->precio,
            $this->stock,
            $this->imagen,
            $this->categoria_id,
            $this->destacado
        ]);

        if ($resultado) {
            $this->id = $this->db->lastInsertId();
            return true;
        }
        return false;
    }

    // Actualizar producto existente
    private function actualizar() {
        $sql = "UPDATE productos SET 
                nombre = ?, 
                descripcion = ?, 
                precio = ?, 
                stock = ?, 
                imagen = ?, 
                categoria_id = ?, 
                destacado = ? 
                WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $this->nombre,
            $this->descripcion,
            $this->precio,
            $this->stock,
            $this->imagen,
            $this->categoria_id,
            $this->destacado,
            $this->id
        ]);
    }

    // Eliminar producto
    public function eliminar($id) {
        $sql = "DELETE FROM productos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Actualizar stock
    public function actualizarStock($id, $cantidad) {
        $sql = "UPDATE productos SET stock = stock - ? WHERE id = ? AND stock >= ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$cantidad, $id, $cantidad]);
    }

    // Verificar si hay stock suficiente
    public function hayStockSuficiente($id, $cantidad) {
        $sql = "SELECT stock FROM productos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $stock = $stmt->fetchColumn();
        return $stock >= $cantidad;
    }

    // Cargar datos de producto
    public function cargar($datos) {
        $this->id = isset($datos['id']) ? $datos['id'] : null;
        $this->setNombre($datos['nombre']);
        $this->setDescripcion($datos['descripcion']);
        $this->setPrecio($datos['precio']);
        $this->setStock($datos['stock']);
        $this->setImagen($datos['imagen']);
        $this->setCategoriaId($datos['categoria_id']);
        $this->setDestacado(isset($datos['destacado']) ? $datos['destacado'] : false);
    }
} 
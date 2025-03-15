<?php
// Conexión a la base de datos
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexión
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Establecer charset
mysqli_set_charset($conn, "utf8");

// Función para obtener productos
function obtenerProductos($limite = null, $destacados = false) {
    global $conn;
    $query = "SELECT p.*, 
              CASE 
                WHEN p.imagen IS NULL OR p.imagen = '' 
                THEN CONCAT('https://via.placeholder.com/300x300?text=', REPLACE(p.nombre, ' ', '+'))
                ELSE p.imagen 
              END as imagen_url
              FROM productos p";
    
    if ($destacados) {
        $query .= " WHERE p.destacado = 1";
    }
    
    if ($limite) {
        $query .= " LIMIT " . (int)$limite;
    }
    
    $result = mysqli_query($conn, $query);
    $productos = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $productos[] = $row;
    }
    return $productos;
}

// Función para obtener producto por ID
function obtenerProductoPorId($id) {
    global $conn;
    $id = (int)$id;
    $query = "SELECT * FROM productos WHERE id = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// Función para obtener categorías
function obtenerCategorias() {
    global $conn;
    $query = "SELECT * FROM categorias";
    $result = mysqli_query($conn, $query);
    $categorias = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $categorias[] = $row;
    }
    return $categorias;
}

// Función para obtener productos por categoría
function obtenerProductosPorCategoria($categoria_id) {
    global $conn;
    $categoria_id = (int)$categoria_id;
    $query = "SELECT p.*, 
              CASE 
                WHEN p.imagen IS NULL OR p.imagen = '' 
                THEN CONCAT('https://via.placeholder.com/300x300?text=', REPLACE(p.nombre, ' ', '+'))
                ELSE p.imagen 
              END as imagen_url,
              c.nombre as categoria_nombre
              FROM productos p 
              LEFT JOIN categorias c ON p.categoria_id = c.id
              WHERE p.categoria_id = $categoria_id";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        return array();
    }
    $productos = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $productos[] = $row;
    }
    return $productos;
}

// Función para buscar productos
function buscarProductos($termino) {
    global $conn;
    $termino = limpiarDatos($termino);
    $query = "SELECT * FROM productos WHERE nombre LIKE '%$termino%' OR descripcion LIKE '%$termino%'";
    $result = mysqli_query($conn, $query);
    $productos = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $productos[] = $row;
    }
    return $productos;
}

// Función para crear un nuevo usuario
function crearUsuario($nombre, $email, $password) {
    global $conn;
    $nombre = limpiarDatos($nombre);
    $email = limpiarDatos($email);
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $query = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password')";
    return mysqli_query($conn, $query);
}

// Función para verificar login
function verificarLogin($email, $password) {
    global $conn;
    $email = limpiarDatos($email);
    $query = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $usuario = mysqli_fetch_assoc($result);
    
    if ($usuario && password_verify($password, $usuario['password'])) {
        return $usuario;
    }
    return false;
}

// Función para crear una orden
function crearOrden($usuario_id, $productos, $total) {
    global $conn;
    $usuario_id = (int)$usuario_id;
    $total = (float)$total;
    
    $query = "INSERT INTO ordenes (usuario_id, total, fecha) VALUES ($usuario_id, $total, NOW())";
    if (mysqli_query($conn, $query)) {
        $orden_id = mysqli_insert_id($conn);
        foreach ($productos as $producto) {
            $producto_id = (int)$producto['id'];
            $cantidad = (int)$producto['cantidad'];
            $precio = (float)$producto['precio'];
            
            $query = "INSERT INTO orden_detalles (orden_id, producto_id, cantidad, precio) 
                     VALUES ($orden_id, $producto_id, $cantidad, $precio)";
            mysqli_query($conn, $query);
        }
        return $orden_id;
    }
    return false;
} 
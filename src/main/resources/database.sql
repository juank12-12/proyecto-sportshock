-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS sportshock;
USE sportshock;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    direccion TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de categorías
CREATE TABLE categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    descripcion TEXT
);

-- Tabla de productos
CREATE TABLE productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    imagen VARCHAR(255),
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Insertar algunas categorías de ejemplo
INSERT INTO categorias (nombre, descripcion) VALUES
('Camisetas', 'Camisetas deportivas para hombre y mujer'),
('Pantalones', 'Pantalones deportivos y shorts'),
('Zapatillas', 'Zapatillas deportivas para diferentes deportes');

-- Insertar algunos productos de ejemplo
INSERT INTO productos (nombre, descripcion, precio, stock, imagen, categoria_id) VALUES
('Camiseta Deportiva Pro', 'Camiseta deportiva de alta calidad', 29.99, 50, 'images/producto1.jpg', 1),
('Pantalón Deportivo Elite', 'Pantalón deportivo con tecnología de secado rápido', 39.99, 30, 'images/producto2.jpg', 2),
('Zapatillas Running Max', 'Zapatillas para running con amortiguación', 59.99, 25, 'images/producto3.jpg', 3); 
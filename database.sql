-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS sportshock;
USE sportshock;

-- Crear tabla de categorías
CREATE TABLE IF NOT EXISTS categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

-- Crear tabla de productos
CREATE TABLE IF NOT EXISTS productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(200) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    imagen VARCHAR(255),
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Insertar categorías de ejemplo
INSERT INTO categorias (nombre, descripcion) VALUES
('Camisetas', 'Camisetas deportivas de alta calidad'),
('Pantalones', 'Pantalones deportivos y de entrenamiento'),
('Zapatillas', 'Zapatillas deportivas para diferentes disciplinas');

-- Insertar productos de ejemplo
INSERT INTO productos (nombre, descripcion, precio, stock, imagen, categoria_id) VALUES
('Camiseta Deportiva Nike', 'Camiseta deportiva de alta calidad', 29.99, 50, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60', 1),
('Pantalón Deportivo Adidas', 'Pantalón deportivo cómodo y resistente', 39.99, 30, 'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60', 2),
('Zapatillas Running Puma', 'Zapatillas ideales para running', 59.99, 25, 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60', 3); 
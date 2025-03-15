-- Insertar categorías
INSERT INTO categorias (id, nombre, descripcion) VALUES
(1, 'Ropa Deportiva', 'Encuentra la mejor ropa deportiva para tus entrenamientos'),
(2, 'Calzado Deportivo', 'Calzado especializado para cada tipo de deporte'),
(3, 'Accesorios', 'Complementa tu equipo deportivo con nuestros accesorios');

-- Insertar productos de ejemplo
INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, destacado) VALUES
-- Ropa Deportiva
('Camiseta Deportiva', 'Camiseta transpirable para entrenamiento', 29.99, 50, 1, 1),
('Pantalón Running', 'Pantalón ligero para correr', 39.99, 30, 1, 1),
('Short Deportivo', 'Short cómodo para ejercicio', 24.99, 40, 1, 0),

-- Calzado Deportivo
('Tenis Running Pro', 'Zapatillas profesionales para correr', 89.99, 25, 2, 1),
('Tenis Training Max', 'Zapatillas para entrenamiento', 79.99, 20, 2, 1),
('Tenis Basketball Air', 'Zapatillas para basketball', 99.99, 15, 2, 0),

-- Accesorios
('Mochila Deportiva', 'Mochila resistente para tus implementos', 45.99, 35, 3, 1),
('Banda Elástica', 'Banda para ejercicios de resistencia', 15.99, 60, 3, 0),
('Botella Deportiva', 'Botella de agua para hidratación', 19.99, 45, 3, 1); 
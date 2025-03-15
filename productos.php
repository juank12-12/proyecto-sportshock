<?php
session_start();
include 'includes/config.php';
include 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - SportShock</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container my-5">
        <h1 class="mb-4">Nuestros Productos</h1>
        
        <!-- Filtros -->
        <div class="row mb-4">
            <div class="col-md-4">
                <select class="form-select" id="categoria">
                    <option value="">Todas las categorías</option>
                    <?php
                    $categorias = obtenerCategorias();
                    foreach($categorias as $categoria) {
                        echo "<option value='{$categoria['id']}'>{$categoria['nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" id="buscar" placeholder="Buscar productos...">
            </div>
        </div>

        <!-- Lista de Productos -->
        <div class="row">
            <?php
            $productos = obtenerProductos();
            foreach($productos as $producto) {
            ?>
            <div class="col-md-3 mb-4">
                <div class="product-card">
                    <img src="<?php echo $producto['imagen_url']; ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="img-fluid">
                    <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                    <p class="price">$<?php echo number_format($producto['precio'], 2); ?></p>
                    <p class="description"><?php echo htmlspecialchars(substr($producto['descripcion'], 0, 100)) . '...'; ?></p>
                    <div class="d-grid gap-2">
                        <a href="producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-primary">Ver Detalles</a>
                        <button class="btn btn-success agregar-carrito" data-id="<?php echo $producto['id']; ?>">
                            Agregar al Carrito
                        </button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        // Filtrado de productos
        document.getElementById('categoria').addEventListener('change', function() {
            // Aquí irá el código para filtrar por categoría
        });

        document.getElementById('buscar').addEventListener('input', function() {
            // Aquí irá el código para buscar productos
        });
    </script>
</body>
</html> 
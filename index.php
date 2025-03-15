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
    <title>SportShock - Tienda Deportiva</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Banner Principal -->
    <div class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>Bienvenido a SportShock</h1>
                    <p>Tu tienda deportiva de confianza</p>
                    <a href="productos.php" class="btn btn-primary">Ver Productos</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Categorías Destacadas -->
    <section class="categories-section">
        <div class="container">
            <h2>Categorías Destacadas</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="category-card">
                        <img src="https://via.placeholder.com/400x300?text=Ropa+Deportiva" alt="Ropa Deportiva" class="img-fluid">
                        <h3>Ropa Deportiva</h3>
                        <a href="categorias.php?id=1" class="btn btn-outline-primary">Ver más</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="category-card">
                        <img src="https://via.placeholder.com/400x300?text=Calzado+Deportivo" alt="Calzado Deportivo" class="img-fluid">
                        <h3>Calzado Deportivo</h3>
                        <a href="categorias.php?id=2" class="btn btn-outline-primary">Ver más</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="category-card">
                        <img src="https://via.placeholder.com/400x300?text=Accesorios" alt="Accesorios" class="img-fluid">
                        <h3>Accesorios</h3>
                        <a href="categorias.php?id=3" class="btn btn-outline-primary">Ver más</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Productos Destacados -->
    <section class="featured-products">
        <div class="container">
            <h2>Productos Destacados</h2>
            <div class="row">
                <?php
                $productos = obtenerProductos(4, true);
                foreach($productos as $producto) {
                    ?>
                    <div class="col-md-3">
                        <div class="product-card">
                            <img src="<?php echo $producto['imagen_url']; ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="img-fluid">
                            <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                            <p class="price">$<?php echo number_format($producto['precio'], 2); ?></p>
                            <div class="d-grid gap-2">
                                <a href="producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-primary">Ver Detalles</a>
                                <button class="btn btn-success agregar-carrito" data-id="<?php echo $producto['id']; ?>">
                                    Agregar al Carrito
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Ventajas -->
    <section class="features-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature">
                        <i class="fas fa-truck"></i>
                        <h3>Envío Gratis</h3>
                        <p>En compras mayores a $100</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature">
                        <i class="fas fa-lock"></i>
                        <h3>Pago Seguro</h3>
                        <p>Transacciones 100% seguras</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature">
                        <i class="fas fa-undo"></i>
                        <h3>Devolución Garantizada</h3>
                        <p>30 días para cambios</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
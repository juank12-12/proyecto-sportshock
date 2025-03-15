<?php
session_start();
include 'includes/config.php';
include 'includes/db.php';

// Obtener el ID de la categoría
$categoria_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Obtener información de la categoría
$query = "SELECT * FROM categorias WHERE id = $categoria_id";
$result = mysqli_query($conn, $query);
$categoria = mysqli_fetch_assoc($result);

// Si no existe la categoría, redirigir a productos
if (!$categoria) {
    header('Location: productos.php');
    exit;
}

// Obtener los productos de la categoría
$productos = obtenerProductosPorCategoria($categoria_id);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($categoria['nombre']); ?> - SportShock</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item"><a href="productos.php">Productos</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($categoria['nombre']); ?></li>
            </ol>
        </nav>

        <h1 class="mb-4"><?php echo htmlspecialchars($categoria['nombre']); ?></h1>
        <?php if (!empty($categoria['descripcion'])): ?>
            <p class="lead mb-4"><?php echo htmlspecialchars($categoria['descripcion']); ?></p>
        <?php endif; ?>

        <div class="row">
            <?php if (empty($productos)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        No hay productos disponibles en esta categoría en este momento.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach($productos as $producto): ?>
                    <div class="col-md-3 mb-4">
                        <div class="product-card">
                            <img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
                                 class="img-fluid">
                            <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                            <p class="price">$<?php echo number_format($producto['precio'], 2); ?></p>
                            <?php if (!empty($producto['descripcion'])): ?>
                                <p class="description"><?php echo htmlspecialchars(substr($producto['descripcion'], 0, 100)) . '...'; ?></p>
                            <?php endif; ?>
                            <div class="d-grid gap-2">
                                <a href="producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-primary">Ver Detalles</a>
                                <button class="btn btn-success agregar-carrito" data-id="<?php echo $producto['id']; ?>">
                                    Agregar al Carrito
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html> 
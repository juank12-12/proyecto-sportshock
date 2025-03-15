<?php
session_start();
include 'includes/config.php';
include 'includes/db.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$mensaje = '';
$error = '';

// Obtener información del usuario
$usuario_id = $_SESSION['usuario_id'];
$query = "SELECT * FROM usuarios WHERE id = $usuario_id";
$result = mysqli_query($conn, $query);
$usuario = mysqli_fetch_assoc($result);

// Procesar actualización del perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';
    $password_actual = isset($_POST['password_actual']) ? $_POST['password_actual'] : '';
    $password_nuevo = isset($_POST['password_nuevo']) ? $_POST['password_nuevo'] : '';

    // Validar email único
    if ($email !== $usuario['email']) {
        $check_email = mysqli_query($conn, "SELECT id FROM usuarios WHERE email = '$email' AND id != $usuario_id");
        if (mysqli_num_rows($check_email) > 0) {
            $error = "El email ya está registrado por otro usuario.";
        }
    }

    if (empty($error)) {
        // Si se proporciona contraseña actual, verificar y actualizar contraseña
        if (!empty($password_actual) && !empty($password_nuevo)) {
            if (password_verify($password_actual, $usuario['password'])) {
                $password_hash = password_hash($password_nuevo, PASSWORD_DEFAULT);
                $query = "UPDATE usuarios SET 
                         nombre = '$nombre',
                         email = '$email',
                         telefono = '$telefono',
                         direccion = '$direccion',
                         password = '$password_hash'
                         WHERE id = $usuario_id";
            } else {
                $error = "La contraseña actual es incorrecta.";
            }
        } else {
            $query = "UPDATE usuarios SET 
                     nombre = '$nombre',
                     email = '$email',
                     telefono = '$telefono',
                     direccion = '$direccion'
                     WHERE id = $usuario_id";
        }

        if (empty($error) && mysqli_query($conn, $query)) {
            $mensaje = "Perfil actualizado correctamente.";
            // Actualizar información en la sesión
            $_SESSION['usuario_nombre'] = $nombre;
            $_SESSION['usuario_email'] = $email;
            
            // Recargar información del usuario
            $result = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = $usuario_id");
            $usuario = mysqli_fetch_assoc($result);
        } else {
            $error = "Error al actualizar el perfil.";
        }
    }
}

// Obtener pedidos del usuario
$query_pedidos = "SELECT p.* FROM pedidos p 
                  WHERE p.usuario_id = $usuario_id
                  ORDER BY p.fecha_pedido DESC";
$result_pedidos = mysqli_query($conn, $query_pedidos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - SportShock</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container my-5">
        <h1 class="text-center mb-5">Mi Perfil</h1>

        <?php if ($mensaje): ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="row">
            <!-- Información del Perfil -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Información Personal</h3>
                    </div>
                    <div class="card-body">
                        <form action="perfil.php" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" 
                                       value="<?php echo htmlspecialchars($usuario['telefono'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <textarea class="form-control" id="direccion" name="direccion" rows="3"
                                          ><?php echo htmlspecialchars($usuario['direccion'] ?? ''); ?></textarea>
                            </div>
                            <hr>
                            <h4>Cambiar Contraseña</h4>
                            <div class="mb-3">
                                <label for="password_actual" class="form-label">Contraseña Actual</label>
                                <input type="password" class="form-control" id="password_actual" name="password_actual">
                            </div>
                            <div class="mb-3">
                                <label for="password_nuevo" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="password_nuevo" name="password_nuevo">
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Historial de Pedidos -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Mis Pedidos</h3>
                    </div>
                    <div class="card-body">
                        <?php if (mysqli_num_rows($result_pedidos) > 0): ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Pedido #</th>
                                            <th>Fecha</th>
                                            <th>Productos</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($pedido = mysqli_fetch_assoc($result_pedidos)): ?>
                                            <tr>
                                                <td>
                                                    <a href="pedido.php?id=<?php echo $pedido['id']; ?>">
                                                        <?php echo $pedido['id']; ?>
                                                    </a>
                                                </td>
                                                <td><?php echo date('d/m/Y', strtotime($pedido['fecha_pedido'])); ?></td>
                                                <td>-</td>
                                                <td>€<?php echo number_format($pedido['total'], 2); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php 
                                                        echo $pedido['estado'] === 'completado' ? 'success' : 
                                                            ($pedido['estado'] === 'pendiente' ? 'warning' : 'secondary');
                                                    ?>">
                                                        <?php echo ucfirst($pedido['estado']); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-center">No tienes pedidos realizados.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html> 
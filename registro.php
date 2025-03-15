<?php
session_start();
include 'includes/config.php';
include 'includes/db.php';

if(isset($_POST['registro'])) {
    $nombre = limpiarDatos($_POST['nombre']);
    $email = limpiarDatos($_POST['email']);
    $password = $_POST['password'];
    $confirmar_password = $_POST['confirmar_password'];
    
    // Validaciones
    $errores = [];
    
    if(empty($nombre) || empty($email) || empty($password) || empty($confirmar_password)) {
        $errores[] = "Todos los campos son obligatorios";
    }
    
    if(!validarEmail($email)) {
        $errores[] = "El email no es válido";
    }
    
    if($password !== $confirmar_password) {
        $errores[] = "Las contraseñas no coinciden";
    }
    
    if(strlen($password) < 6) {
        $errores[] = "La contraseña debe tener al menos 6 caracteres";
    }
    
    // Verificar si el email ya existe
    $query = "SELECT id FROM usuarios WHERE email = ?";
    $stmt = conectarDB()->prepare($query);
    $stmt->execute([$email]);
    if($stmt->rowCount() > 0) {
        $errores[] = "El email ya está registrado";
    }
    
    if(empty($errores)) {
        if(crearUsuario($nombre, $email, $password)) {
            mostrarMensaje('success', '¡Registro exitoso! Ya puedes iniciar sesión');
            header('Location: login.php');
            exit;
        } else {
            mostrarMensaje('danger', 'Error al crear el usuario');
        }
    } else {
        foreach($errores as $error) {
            mostrarMensaje('danger', $error);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - SportShock</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Registro</h3>
                    </div>
                    <div class="card-body">
                        <?php if(isset($_SESSION['mensaje'])): ?>
                            <div class="alert alert-<?php echo $_SESSION['mensaje']['tipo']; ?>">
                                <?php echo $_SESSION['mensaje']['texto']; ?>
                            </div>
                            <?php unset($_SESSION['mensaje']); ?>
                        <?php endif; ?>

                        <form action="registro.php" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="form-text">La contraseña debe tener al menos 6 caracteres</div>
                            </div>
                            <div class="mb-3">
                                <label for="confirmar_password" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" name="registro" class="btn btn-primary">Registrarse</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
                        </div>
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
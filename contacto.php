<?php
session_start();
include 'includes/config.php';
include 'includes/db.php';

$mensaje_enviado = false;
$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $asunto = isset($_POST['asunto']) ? trim($_POST['asunto']) : '';
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

    if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
        $error = "Por favor, complete todos los campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Por favor, ingrese un email válido.";
    } else {
        // Aquí puedes agregar el código para enviar el email
        $mensaje_enviado = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - SportShock</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container my-5">
        <h1 class="text-center mb-5">Contacto</h1>

        <div class="row">
            <!-- Información de Contacto -->
            <div class="col-md-4">
                <div class="contact-info p-4 bg-light rounded">
                    <h3>Información de Contacto</h3>
                    <ul class="list-unstyled mt-4">
                        <li class="mb-3">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                            Calle 3-1B-24 barrio progreso<br>
                            <span class="ms-4">Santa Maria, Boyacá</span>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-phone me-2 text-primary"></i>
                            322 431 3269
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-envelope me-2 text-primary"></i>
                            info@sportshock.com
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-clock me-2 text-primary"></i>
                            Lunes a Sábado: 9:00 AM - 8:00 PM<br>
                            <span class="ms-4">Domingo: 10:00 AM - 6:00 PM</span>
                        </li>
                    </ul>
                    <div class="social-links mt-4">
                        <a href="#" class="me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>

            <!-- Formulario de Contacto -->
            <div class="col-md-8">
                <?php if ($mensaje_enviado): ?>
                    <div class="alert alert-success">
                        ¡Gracias por contactarnos! Te responderemos lo antes posible.
                    </div>
                <?php elseif ($error): ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="contacto.php" method="POST" class="contact-form bg-light p-4 rounded">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="asunto" class="form-label">Asunto</label>
                        <input type="text" class="form-control" id="asunto" name="asunto" required>
                    </div>
                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
                </form>
            </div>
        </div>

        <!-- Mapa -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15890.916241579007!2d-73.26447467012695!3d5.019444599999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e6a7dd05aa35c1d%3A0x76a5678fa0529af6!2sSanta%20Mar%C3%ADa%2C%20Boyac%C3%A1!5e0!3m2!1ses!2sco!4v1647377123456!5m2!1ses!2sco"
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html> 
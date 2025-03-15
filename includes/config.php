<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sportshock');

// Configuración del sitio
define('SITE_NAME', 'SportShock');
define('SITE_URL', 'http://localhost/15.ejer');
define('ADMIN_EMAIL', 'admin@sportshock.com');

// Configuración de sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Zona horaria
date_default_timezone_set('America/Mexico_City');

// Configuración de correo
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'tu_correo@gmail.com');
define('SMTP_PASS', 'tu_contraseña');
define('SMTP_PORT', 587);

// Configuración de PayPal
define('PAYPAL_CLIENT_ID', 'tu_client_id');
define('PAYPAL_SECRET', 'tu_secret');
define('PAYPAL_MODE', 'sandbox'); // sandbox o live

// Configuración de la tienda
define('IVA', 0.16); // 16%
define('ENVIO_GRATIS_DESDE', 1000); // Envío gratis en compras mayores a $1000
define('COSTO_ENVIO_BASE', 150); // Costo base de envío

// Rutas del sistema
define('ROOT_PATH', dirname(dirname(__FILE__)));
define('INCLUDES_PATH', ROOT_PATH . '/includes');
define('UPLOADS_PATH', ROOT_PATH . '/uploads');
define('TEMPLATES_PATH', ROOT_PATH . '/templates');

// Configuración de carga de archivos
define('MAX_FILE_SIZE', 5242880); // 5MB en bytes
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Funciones de utilidad
function conectarDB() {
    try {
        $conexion = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
            DB_USER,
            DB_PASS,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
        );
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch(PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

function limpiarDatos($datos) {
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function generarToken() {
    return bin2hex(random_bytes(32));
}

function estaLogueado() {
    return isset($_SESSION['usuario_id']);
}

function esAdmin() {
    return isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin';
}

function redirigir($url) {
    header("Location: " . SITE_URL . $url);
    exit;
}

function mostrarMensaje($tipo, $mensaje) {
    $_SESSION['mensaje'] = [
        'tipo' => $tipo,
        'texto' => $mensaje
    ];
}

// Manejo de errores
function manejadorErrores($errno, $errstr, $errfile, $errline) {
    $error = "[$errno] $errstr - $errfile:$errline";
    error_log($error);
    
    if (ini_get('display_errors')) {
        printf("<pre>%s</pre>\n", $error);
    }
}

set_error_handler('manejadorErrores');

// Verificar si hay mensaje en la sesión
function obtenerMensaje() {
    if(isset($_SESSION['mensaje'])) {
        $mensaje = $_SESSION['mensaje'];
        unset($_SESSION['mensaje']);
        return $mensaje;
    }
    return null;
}

// Formatear precio
function formatearPrecio($precio) {
    return '$' . number_format($precio, 2);
}

// Generar URL amigable
function generarSlug($texto) {
    $texto = strtolower($texto);
    $texto = preg_replace('/[^a-z0-9-]/', '-', $texto);
    $texto = preg_replace('/-+/', "-", $texto);
    return trim($texto, '-');
} 
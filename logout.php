<?php
session_start();
include 'includes/config.php';

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al inicio
mostrarMensaje('success', 'Has cerrado sesión correctamente');
header('Location: index.php');
exit; 
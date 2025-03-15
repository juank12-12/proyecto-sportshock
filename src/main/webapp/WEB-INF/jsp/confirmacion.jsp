<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .confirmacion-container {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .datos {
            margin: 20px 0;
            padding: 15px;
            background-color: #e8f5e9;
            border-radius: 4px;
        }
        .volver {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .volver:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="confirmacion-container">
        <h1>¡Registro Exitoso!</h1>
        <div class="datos">
            <h2>Datos Registrados:</h2>
            <p><strong>Nombre:</strong> ${nombre}</p>
            <p><strong>Email:</strong> ${email}</p>
        </div>
        <a href="index.jsp" class="volver">Volver al Formulario</a>
    </div>
</body>
</html> 
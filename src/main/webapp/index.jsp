<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportShock - Inicio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 40px 20px;
        }

        header h1 {
            margin: 0;
            font-size: 2.5em;
        }

        header p {
            margin: 10px 0 0;
            font-size: 1.2em;
        }

        nav {
            background-color: #34495e;
            padding: 15px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            color: #3498db;
        }

        .hero {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                        url('https://images.unsplash.com/photo-1517649763962-0c623066013b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }

        .hero-content p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        .btn {
            background-color: #3498db;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .features {
            padding: 60px 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature {
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .feature h3 {
            color: #2c3e50;
            margin-bottom: 15px;
        }

        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <header>
        <h1>SportShock</h1>
        <p>Tu tienda de ropa deportiva de confianza</p>
    </header>

    <nav>
        <ul>
            <li><a href="index.jsp">Inicio</a></li>
            <li><a href="productos">Productos</a></li>
            <li><a href="carrito">Carrito</a></li>
        </ul>
    </nav>

    <div class="hero">
        <div class="hero-content">
            <h1>Bienvenido a SportShock</h1>
            <p>Descubre nuestra colección de ropa deportiva de alta calidad</p>
            <a href="productos" class="btn">Ver Catálogo</a>
        </div>
    </div>

    <div class="features">
        <div class="feature">
            <h3>Calidad Premium</h3>
            <p>Productos de las mejores marcas deportivas</p>
        </div>
        <div class="feature">
            <h3>Envío Rápido</h3>
            <p>Entrega en tiempo récord a todo el país</p>
        </div>
        <div class="feature">
            <h3>Garantía</h3>
            <p>30 días de garantía en todos los productos</p>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 SportShock - Todos los derechos reservados</p>
    </footer>
</body>
</html> 
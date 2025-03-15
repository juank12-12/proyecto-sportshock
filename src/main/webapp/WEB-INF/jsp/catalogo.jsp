<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - SportShock</title>
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
            padding: 1rem;
            text-align: center;
        }
        nav {
            background-color: #34495e;
            padding: 1rem;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
            gap: 2rem;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            color: #3498db;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        .categorias {
            margin-bottom: 2rem;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .categorias h2 {
            margin-top: 0;
            color: #2c3e50;
        }
        .categorias ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .categorias li a {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .categorias li a:hover {
            background: #2980b9;
        }
        .productos {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
        }
        .producto-card {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .producto-card img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        .producto-card h3 {
            margin: 0.5rem 0;
            color: #2c3e50;
        }
        .producto-card .precio {
            font-size: 1.2rem;
            color: #e74c3c;
            font-weight: bold;
            margin: 0.5rem 0;
        }
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 0.5rem;
        }
        .btn:hover {
            background: #2980b9;
        }
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: 2rem;
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
            <li><a href="catalogo">Catálogo</a></li>
            <li><a href="categorias">Categorías</a></li>
            <li><a href="carrito">Carrito</a></li>
            <li><a href="login.jsp">Iniciar Sesión</a></li>
            <li><a href="registro.jsp">Registrarse</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="categorias">
            <h2>Categorías</h2>
            <ul>
                <li><a href="catalogo">Todos</a></li>
                <c:forEach items="${categorias}" var="categoria">
                    <li>
                        <a href="catalogo?categoria=${categoria.id}">
                            ${categoria.nombre}
                        </a>
                    </li>
                </c:forEach>
            </ul>
        </div>

        <div class="productos">
            <c:forEach items="${productos}" var="producto">
                <div class="producto-card">
                    <img src="${producto.imagen}" alt="${producto.nombre}">
                    <h3>${producto.nombre}</h3>
                    <p class="precio">$${producto.precio}</p>
                    <p>${producto.descripcion}</p>
                    <a href="carrito?accion=agregar&id=${producto.id}" class="btn">
                        Agregar al Carrito
                    </a>
                </div>
            </c:forEach>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 SportShock - Todos los derechos reservados</p>
    </footer>
</body>
</html> 
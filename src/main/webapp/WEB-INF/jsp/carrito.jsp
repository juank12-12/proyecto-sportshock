<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - SportShock</title>
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
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .carrito {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .carrito h2 {
            margin-top: 0;
            color: #2c3e50;
        }
        .carrito-items {
            margin: 2rem 0;
        }
        .carrito-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }
        .carrito-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 1rem;
        }
        .carrito-item-info {
            flex-grow: 1;
        }
        .carrito-item h3 {
            margin: 0;
            color: #2c3e50;
        }
        .carrito-item .precio {
            color: #e74c3c;
            font-weight: bold;
            margin: 0.5rem 0;
        }
        .carrito-item .eliminar {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
        }
        .carrito-total {
            text-align: right;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 2px solid #eee;
        }
        .carrito-total h3 {
            margin: 0;
            color: #2c3e50;
        }
        .carrito-total .total {
            font-size: 1.5rem;
            color: #e74c3c;
            font-weight: bold;
        }
        .btn-comprar {
            display: inline-block;
            padding: 1rem 2rem;
            background: #2ecc71;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 1rem;
        }
        .btn-comprar:hover {
            background: #27ae60;
        }
        .carrito-vacio {
            text-align: center;
            padding: 2rem;
            color: #7f8c8d;
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
        <div class="carrito">
            <h2>Carrito de Compras</h2>
            
            <c:choose>
                <c:when test="${empty carrito}">
                    <div class="carrito-vacio">
                        <p>Tu carrito está vacío</p>
                        <a href="catalogo" class="btn-comprar">Ir al Catálogo</a>
                    </div>
                </c:when>
                <c:otherwise>
                    <div class="carrito-items">
                        <c:forEach items="${carrito}" var="producto">
                            <div class="carrito-item">
                                <img src="${producto.imagen}" alt="${producto.nombre}">
                                <div class="carrito-item-info">
                                    <h3>${producto.nombre}</h3>
                                    <p class="precio">$${producto.precio}</p>
                                    <p>${producto.descripcion}</p>
                                </div>
                                <a href="carrito?accion=eliminar&id=${producto.id}" class="eliminar">
                                    Eliminar
                                </a>
                            </div>
                        </c:forEach>
                    </div>
                    
                    <div class="carrito-total">
                        <h3>Total:</h3>
                        <p class="total">$${total}</p>
                        <a href="#" class="btn-comprar">Proceder al Pago</a>
                    </div>
                </c:otherwise>
            </c:choose>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 SportShock - Todos los derechos reservados</p>
    </footer>
</body>
</html> 
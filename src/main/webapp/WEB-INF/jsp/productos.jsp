<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportShock - Productos</title>
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
            padding: 20px;
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

        .productos {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .producto {
            background: white;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .producto img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 4px;
        }

        .precio {
            color: #e74c3c;
            font-weight: bold;
            font-size: 1.2em;
            margin: 10px 0;
        }

        .btn {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .carrito {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .carrito-items {
            list-style: none;
            padding: 0;
            margin: 10px 0;
        }

        .total {
            font-weight: bold;
            color: #e74c3c;
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

    <div class="carrito">
        <h3>Carrito de Compras</h3>
        <ul class="carrito-items">
            <c:forEach items="${sessionScope.carrito}" var="item">
                <li>${item.nombre} - $${item.precio}</li>
            </c:forEach>
        </ul>
        <p class="total">Total: $${sessionScope.total}</p>
    </div>

    <div class="productos">
        <c:forEach items="${productos}" var="producto">
            <div class="producto">
                <img src="${producto.imagen}" alt="${producto.nombre}">
                <h3>${producto.nombre}</h3>
                <p class="precio">$${producto.precio}</p>
                <form action="productos" method="post">
                    <input type="hidden" name="accion" value="agregar">
                    <input type="hidden" name="id" value="${producto.id}">
                    <input type="hidden" name="nombre" value="${producto.nombre}">
                    <input type="hidden" name="precio" value="${producto.precio}">
                    <input type="hidden" name="imagen" value="${producto.imagen}">
                    <button type="submit" class="btn">Agregar al Carrito</button>
                </form>
            </div>
        </c:forEach>
    </div>
</body>
</html> 
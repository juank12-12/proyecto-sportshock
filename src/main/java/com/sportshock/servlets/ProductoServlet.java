package com.sportshock.servlets;

import java.io.IOException;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import java.util.ArrayList;
import java.util.List;

@WebServlet("/productos")
public class ProductoServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;

    protected void doGet(HttpServletRequest request, HttpServletResponse response) 
            throws ServletException, IOException {
        
        // Lista de productos de ejemplo
        List<Producto> productos = new ArrayList<>();
        productos.add(new Producto(1, "Camiseta Deportiva Nike", 29.99, 
            "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"));
        productos.add(new Producto(2, "Pantalón Deportivo Adidas", 39.99,
            "https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"));
        productos.add(new Producto(3, "Zapatillas Running Puma", 59.99,
            "https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"));

        request.setAttribute("productos", productos);
        request.getRequestDispatcher("/WEB-INF/jsp/productos.jsp").forward(request, response);
    }

    protected void doPost(HttpServletRequest request, HttpServletResponse response) 
            throws ServletException, IOException {
        
        String accion = request.getParameter("accion");
        HttpSession session = request.getSession();
        List<Producto> carrito = (List<Producto>) session.getAttribute("carrito");

        if (carrito == null) {
            carrito = new ArrayList<>();
            session.setAttribute("carrito", carrito);
        }

        if ("agregar".equals(accion)) {
            int id = Integer.parseInt(request.getParameter("id"));
            String nombre = request.getParameter("nombre");
            double precio = Double.parseDouble(request.getParameter("precio"));
            String imagen = request.getParameter("imagen");
            
            Producto producto = new Producto(id, nombre, precio, imagen);
            carrito.add(producto);
            session.setAttribute("carrito", carrito);
        }

        response.sendRedirect("productos");
    }
} 
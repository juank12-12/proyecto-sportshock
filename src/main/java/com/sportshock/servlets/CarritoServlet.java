package com.sportshock.servlets;

import com.sportshock.dao.ProductoDAO;
import com.sportshock.models.Producto;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

@WebServlet("/carrito")
public class CarritoServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;
    private ProductoDAO productoDAO;

    @Override
    public void init() throws ServletException {
        productoDAO = new ProductoDAO();
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response) 
            throws ServletException, IOException {
        
        HttpSession session = request.getSession();
        List<Producto> carrito = (List<Producto>) session.getAttribute("carrito");
        
        if (carrito == null) {
            carrito = new ArrayList<>();
            session.setAttribute("carrito", carrito);
        }
        
        // Calcular el total
        double total = 0;
        for (Producto producto : carrito) {
            total += producto.getPrecio();
        }
        
        request.setAttribute("carrito", carrito);
        request.setAttribute("total", total);
        
        request.getRequestDispatcher("/WEB-INF/jsp/carrito.jsp").forward(request, response);
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
            int productoId = Integer.parseInt(request.getParameter("id"));
            Producto producto = productoDAO.buscarPorId(productoId);
            
            if (producto != null) {
                carrito.add(producto);
                session.setAttribute("carrito", carrito);
            }
        } else if ("eliminar".equals(accion)) {
            int productoId = Integer.parseInt(request.getParameter("id"));
            carrito.removeIf(p -> p.getId() == productoId);
            session.setAttribute("carrito", carrito);
        }
        
        response.sendRedirect("carrito");
    }
} 
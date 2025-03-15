package com.sportshock.servlets;

import com.sportshock.dao.CategoriaDAO;
import com.sportshock.dao.ProductoDAO;
import com.sportshock.models.Categoria;
import com.sportshock.models.Producto;
import java.io.IOException;
import java.util.List;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

@WebServlet("/catalogo")
public class CatalogoServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;
    private ProductoDAO productoDAO;
    private CategoriaDAO categoriaDAO;

    @Override
    public void init() throws ServletException {
        productoDAO = new ProductoDAO();
        categoriaDAO = new CategoriaDAO();
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response) 
            throws ServletException, IOException {
        
        // Obtener el ID de la categoría si se especifica
        String categoriaIdStr = request.getParameter("categoria");
        List<Producto> productos;
        
        if (categoriaIdStr != null && !categoriaIdStr.isEmpty()) {
            // Filtrar por categoría
            int categoriaId = Integer.parseInt(categoriaIdStr);
            productos = productoDAO.listarPorCategoria(categoriaId);
        } else {
            // Listar todos los productos
            productos = productoDAO.listarTodos();
        }
        
        // Obtener todas las categorías para el menú
        List<Categoria> categorias = categoriaDAO.listarTodas();
        
        // Establecer atributos para la vista
        request.setAttribute("productos", productos);
        request.setAttribute("categorias", categorias);
        
        // Redirigir a la vista del catálogo
        request.getRequestDispatcher("/WEB-INF/jsp/catalogo.jsp").forward(request, response);
    }

    protected void doPost(HttpServletRequest request, HttpServletResponse response) 
            throws ServletException, IOException {
        doGet(request, response);
    }
} 
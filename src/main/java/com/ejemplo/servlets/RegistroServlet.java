package com.ejemplo.servlets;

import java.io.IOException;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

@WebServlet("/registro")
public class RegistroServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;

    protected void doPost(HttpServletRequest request, HttpServletResponse response) 
            throws ServletException, IOException {
        
        // Obtener los parámetros del formulario
        String nombre = request.getParameter("nombre");
        String email = request.getParameter("email");
        String password = request.getParameter("password");

        // Aquí podrías agregar la lógica para guardar los datos en una base de datos
        
        // Establecer atributos para mostrar en la página de respuesta
        request.setAttribute("nombre", nombre);
        request.setAttribute("email", email);
        
        // Redirigir a una página de confirmación
        request.getRequestDispatcher("/WEB-INF/jsp/confirmacion.jsp").forward(request, response);
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response) 
            throws ServletException, IOException {
        // Si alguien intenta acceder directamente al servlet por GET, redirigir al formulario
        response.sendRedirect("index.jsp");
    }
} 
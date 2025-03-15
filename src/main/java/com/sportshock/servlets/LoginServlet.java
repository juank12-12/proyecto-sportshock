package com.sportshock.servlets;

import com.sportshock.dao.UsuarioDAO;
import com.sportshock.models.Usuario;
import java.io.IOException;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

@WebServlet("/login")
public class LoginServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;
    private UsuarioDAO usuarioDAO;

    @Override
    public void init() throws ServletException {
        usuarioDAO = new UsuarioDAO();
    }

    protected void doPost(HttpServletRequest request, HttpServletResponse response) 
            throws ServletException, IOException {
        
        // Obtener los parámetros del formulario
        String email = request.getParameter("email");
        String password = request.getParameter("password");

        // Buscar el usuario en la base de datos
        Usuario usuario = usuarioDAO.buscarPorEmail(email);
        
        if (usuario != null && usuario.getPassword().equals(password)) {
            // Login exitoso
            HttpSession session = request.getSession();
            session.setAttribute("usuario", usuario.getNombre());
            session.setAttribute("email", usuario.getEmail());
            session.setAttribute("userId", usuario.getId());
            
            // Redirigir a la página de inicio
            response.sendRedirect("index.jsp");
        } else {
            // Credenciales inválidas
            request.setAttribute("error", "Email o contraseña incorrectos. Por favor, intente nuevamente.");
            request.getRequestDispatcher("/login.jsp").forward(request, response);
        }
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response) 
            throws ServletException, IOException {
        response.sendRedirect("login.jsp");
    }
} 
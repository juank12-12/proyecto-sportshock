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

@WebServlet("/registro")
public class RegistroServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;
    private UsuarioDAO usuarioDAO;

    @Override
    public void init() throws ServletException {
        usuarioDAO = new UsuarioDAO();
    }

    protected void doPost(HttpServletRequest request, HttpServletResponse response) 
            throws ServletException, IOException {
        
        // Obtener los parámetros del formulario
        String nombre = request.getParameter("nombre");
        String email = request.getParameter("email");
        String telefono = request.getParameter("telefono");
        String direccion = request.getParameter("direccion");
        String password = request.getParameter("password");
        String confirmarPassword = request.getParameter("confirmarPassword");

        // Validar que las contraseñas coincidan
        if (!password.equals(confirmarPassword)) {
            request.setAttribute("error", "Las contraseñas no coinciden");
            request.getRequestDispatcher("/registro.jsp").forward(request, response);
            return;
        }

        // Verificar si el email ya existe
        if (usuarioDAO.buscarPorEmail(email) != null) {
            request.setAttribute("error", "El email ya está registrado");
            request.getRequestDispatcher("/registro.jsp").forward(request, response);
            return;
        }

        // Crear el objeto Usuario
        Usuario usuario = new Usuario();
        usuario.setNombre(nombre);
        usuario.setEmail(email);
        usuario.setPassword(password); // En un caso real, deberías encriptar la contraseña
        usuario.setTelefono(telefono);
        usuario.setDireccion(direccion);

        // Intentar registrar el usuario
        if (usuarioDAO.registrar(usuario)) {
            // Registro exitoso
            HttpSession session = request.getSession();
            session.setAttribute("usuario", nombre);
            session.setAttribute("email", email);
            response.sendRedirect("index.jsp");
        } else {
            // Error en el registro
            request.setAttribute("error", "Error al registrar el usuario. Por favor, intente nuevamente.");
            request.getRequestDispatcher("/registro.jsp").forward(request, response);
        }
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response) 
            throws ServletException, IOException {
        // Si alguien intenta acceder directamente al servlet por GET, redirigir al formulario
        response.sendRedirect("registro.jsp");
    }
} 
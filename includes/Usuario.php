<?php
class Usuario {
    private $db;
    private $id;
    private $nombre;
    private $email;
    private $password;
    private $direccion;
    private $telefono;
    private $fecha_registro;
    private $rol;

    public function __construct() {
        $this->db = conectarDB();
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getEmail() { return $this->email; }
    public function getDireccion() { return $this->direccion; }
    public function getTelefono() { return $this->telefono; }
    public function getFechaRegistro() { return $this->fecha_registro; }
    public function getRol() { return $this->rol; }

    // Setters
    public function setNombre($nombre) { $this->nombre = limpiarDatos($nombre); }
    public function setEmail($email) { $this->email = limpiarDatos($email); }
    public function setPassword($password) { $this->password = password_hash($password, PASSWORD_DEFAULT); }
    public function setDireccion($direccion) { $this->direccion = limpiarDatos($direccion); }
    public function setTelefono($telefono) { $this->telefono = limpiarDatos($telefono); }
    public function setRol($rol) { $this->rol = $rol; }

    // Registrar nuevo usuario
    public function registrar($datos) {
        if ($this->existeEmail($datos['email'])) {
            return false;
        }

        $this->setNombre($datos['nombre']);
        $this->setEmail($datos['email']);
        $this->setPassword($datos['password']);
        $this->setDireccion($datos['direccion'] ?? '');
        $this->setTelefono($datos['telefono'] ?? '');
        $this->setRol($datos['rol'] ?? 'cliente');

        $sql = "INSERT INTO usuarios (nombre, email, password, direccion, telefono, rol) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $resultado = $stmt->execute([
            $this->nombre,
            $this->email,
            $this->password,
            $this->direccion,
            $this->telefono,
            $this->rol
        ]);

        if ($resultado) {
            $this->id = $this->db->lastInsertId();
            return true;
        }
        return false;
    }

    // Iniciar sesión
    public function login($email, $password) {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['password'])) {
            $this->iniciarSesion($usuario);
            return true;
        }
        return false;
    }

    // Iniciar sesión del usuario
    private function iniciarSesion($usuario) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_rol'] = $usuario['rol'];
    }

    // Cerrar sesión
    public function logout() {
        session_unset();
        session_destroy();
    }

    // Verificar si existe el email
    private function existeEmail($email) {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    // Obtener usuario por ID
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar perfil
    public function actualizarPerfil($datos) {
        $sql = "UPDATE usuarios SET 
                nombre = ?, 
                direccion = ?, 
                telefono = ? 
                WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $datos['nombre'],
            $datos['direccion'],
            $datos['telefono'],
            $this->id
        ]);
    }

    // Cambiar contraseña
    public function cambiarPassword($password_actual, $password_nuevo) {
        $usuario = $this->obtenerPorId($this->id);
        
        if (password_verify($password_actual, $usuario['password'])) {
            $sql = "UPDATE usuarios SET password = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                password_hash($password_nuevo, PASSWORD_DEFAULT),
                $this->id
            ]);
        }
        return false;
    }

    // Recuperar contraseña
    public function recuperarPassword($email) {
        if (!$this->existeEmail($email)) {
            return false;
        }

        $token = generarToken();
        $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $sql = "UPDATE usuarios SET 
                token_recuperacion = ?, 
                token_expira = ? 
                WHERE email = ?";
        
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([$token, $expira, $email])) {
            // Aquí se enviaría el email con el token
            return $token;
        }
        return false;
    }

    // Validar token de recuperación
    public function validarToken($token) {
        $sql = "SELECT * FROM usuarios 
                WHERE token_recuperacion = ? 
                AND token_expira > NOW()";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Restablecer contraseña
    public function restablecerPassword($token, $password) {
        $usuario = $this->validarToken($token);
        if (!$usuario) {
            return false;
        }

        $sql = "UPDATE usuarios SET 
                password = ?, 
                token_recuperacion = NULL, 
                token_expira = NULL 
                WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            password_hash($password, PASSWORD_DEFAULT),
            $usuario['id']
        ]);
    }

    // Obtener historial de pedidos
    public function obtenerPedidos() {
        $sql = "SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY fecha_pedido DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Verificar si es administrador
    public function esAdmin() {
        return $this->rol === 'admin';
    }
} 
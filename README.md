# SportShock - Tienda de Ropa Deportiva

Este proyecto es una aplicación web desarrollada con Java Servlets y JSP como parte de la evidencia de producto GA7-220501096-AA2-EV02.

## Descripción

SportShock es una tienda en línea especializada en ropa deportiva, que permite a los usuarios:
- Ver catálogo de productos
- Registrar usuarios
- Realizar compras
- Gestionar carrito de compras
- Administrar productos

## Requisitos del Sistema

- Java JDK 8 o superior
- Apache Tomcat 8.5 o superior
- Maven (opcional, para gestión de dependencias)
- MySQL (para la base de datos)

## Estructura del Proyecto

```
sportshock/
├── src/
│   └── main/
│       ├── java/
│       │   └── com/
│       │       └── sportshock/
│       │           ├── servlets/
│       │           ├── models/
│       │           ├── dao/
│       │           └── util/
│       └── webapp/
│           ├── WEB-INF/
│           │   └── web.xml
│           ├── css/
│           ├── js/
│           ├── images/
│           └── jsp/
└── pom.xml
```

## Características

- Catálogo de productos deportivos
- Sistema de registro y login de usuarios
- Carrito de compras
- Panel de administración
- Gestión de productos
- Formularios HTML con Servlets
- Implementación de métodos GET y POST
- Uso de elementos JSP
- Control de versiones con Git

## Instalación

1. Clonar el repositorio
2. Importar el proyecto en Eclipse
3. Configurar un servidor Tomcat
4. Configurar la base de datos MySQL
5. Ejecutar la aplicación

## Uso

1. Iniciar el servidor Tomcat
2. Acceder a la aplicación a través del navegador
3. Navegar por el catálogo de productos
4. Registrar una cuenta para realizar compras 
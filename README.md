# My Tasks App

Aplicación web en PHP para la **gestión de tareas**, con autenticación **JWT**, un backend siguiendo arquitectura **MVC**, y un frontend construído con **Bootstrap** y **JavaScript**. 
Este proyecto permite **crear**, **leer**, **actualizar** y **eliminar** (CRUD) tareas, así como **autenticar usuarios** mediante **JSON Web Tokens**.

## Características Principales

- **MVC**: Separación clara de capas (Controladores, Modelos, Vistas).
- **Autenticación JWT**: Tokens seguros para rutas protegidas.
- **Operaciones CRUD**: Registro de usuarios, inicio de sesión, gestión de tareas.
- **Validación y Sanitización**: Uso de prepared statements, `password_hash()`, y sanitización de datos.
- **Frontend con Bootstrap**: Interfaz responsiva, formularios de registro y login, pantalla de tareas con modales.
- **Filtros**: Filtrado de tareas por estado (pendiente, en progreso, completada).
- **PHP 8+**: Se aprovechan características como typed properties, match expressions, etc.

## Requisitos

- **PHP 8.0 o superior**
- **MySQL** (o MariaDB)
- **Composer** para la instalación de dependencias

## Estructura del Proyecto

my-tasks-app/ 
├── app/ 
│ ├── Controllers/ 
│ ├── Core/ 
│ ├── Helpers/ 
│ ├── Middlewares/ 
│ └── Models/ 
├── public/ 
│ ├── css/ 
│ ├── js/ 
│ ├── index.php 
│ ├── login.php 
│ ├── register.php 
│ └── tasks.php 
├── routes.php 
├── composer.json 
├── .env 
└── README.md


### Descripción de carpetas

- **app/**  
  Contiene la lógica de negocio, controladores, modelos, middlewares, etc.
- **public/**  
  Carpeta de recursos públicos y punto de entrada (`index.php`), además de vistas como `login.php`, `register.php`, `tasks.php`.
- **routes.php**  
  Define las rutas expuestas por el router (endpoints de la API y/o vistas).
- **.env**  
  Variables de entorno (credenciales de base de datos, configuración de JWT).
- **composer.json**  
  Archivo de configuración para Composer.

## Instalación

1. **Clonar o descargar** este repositorio:
   ```bash
   git clone https://github.com/emichiappero/my-tasks-app.git
   cd my-tasks-app

2. **Instalar dependencias** con Composer:
   ```bash
   composer install

3. **Crear la base de datos** (MySQL) y las tablas
   ```sql
   CREATE DATABASE mytasksdb;
   USE mytasksdb;

   CREATE TABLE users (
     id INT AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR(50) NOT NULL,
     email VARCHAR(100) NOT NULL UNIQUE,
     password VARCHAR(255) NOT NULL,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );

   CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    due_date DATE,
    status ENUM('pendiente','en progreso','completada') DEFAULT 'pendiente',
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
      ON DELETE CASCADE ON UPDATE CASCADE
   );

4. **Configurar el `.env`**
   ```bash
   DB_HOST=localhost
   DB_NAME=mytasksdb
   DB_USER=root
   DB_PASS=secret

   JWT_SECRET=miClaveSecretaMuySegura
   JWT_EXPIRE=3600
   JWT_REFRESH_EXPIRE=7200

5. **Iniciar el servidor** local:
   ```bash
   composer start
 
Esto levanta el servidor embebido de PHP en ***http://localhost:8000***


## Uso

### Registro e Inicio de Sesión
- Visitar http://localhost:8000/register.php para **registrar** un nuevo usuario.
- Luego, http://localhost:8000/login.php para **iniciar sesión** y obtener un token JWT.

### Gestión de Tareas
- Una vez logueado, serás redirigido a `tasks.php`, donde podrá:
  - **Crear** nuevas tareas.
  - **Editar** tareas existentes.
  - **Eliminar** tareas.
  - **Filtrar** tareas por estado.

## Seguridad
- **Prepared Statements**.
- **JWT**.
- **Hash** de contraseñas con ***password_hash()***.
- **Validaciones y sanitización**.

## Licencia
Este proyecto se distribuye bajo la licencia MIT.
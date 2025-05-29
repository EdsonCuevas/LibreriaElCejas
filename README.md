
# 📚 Librería MVC en PHP Puro

Este proyecto es una pequeña aplicación web de gestión de libros, autores y categorías, desarrollada en **PHP puro** usando el patrón de arquitectura **MVC (Modelo-Vista-Controlador)**. No se usan frameworks externos, lo que hace a este proyecto ideal para fines educativos, entender cómo funciona el core de una app web, o como base ligera para proyectos pequeños.

---

## 🚀 Características

- Sistema de rutas personalizado (sin frameworks).
- Conexión a base de datos con `mysqli`.
- Consultas SQL encadenables a través de una clase `DB`.
- CRUD para autores, libros y categorías.
- Manejo de sesiones para autenticación.
- Carga y gestión de imágenes (subidas a `/uploads`).
- Vistas con estructura modular (`layouts`, `partials`).
- Alerta visual con SweetAlert2.
- Diseño base con Bootstrap.

---

## 🧩 Estructura del Proyecto

```
app/
│
├── classes/           # Clases base para la app (Router, DB, Views, etc.)
├── controllers/       # Controladores de cada entidad
│   └── auth/          # Controladores relacionados con sesiones
├── models/            # Modelos que extienden de DB y representan entidades
├── public/            # Punto de entrada público (index.php)
│   ├── assets/        # CSS, JS, imágenes
│   └── uploads/       # Imágenes subidas por el usuario
├── resources/         # Vistas y layouts
│   ├── views/         # Vistas por entidad
│   └── layouts/       # Encabezado y pie de página
└── app.php            # Inicializador principal
```

---

## ⚙️ Requisitos

- PHP >= 7.4
- Servidor web (Apache)
- Base de datos MySQL
- Extensión `mysqli` habilitada

---

## 🛠️ Instalación

1. Clona este repositorio:

```bash
git clone https://github.com/EdsonCuevas/LibreriaElCejas.git
```

2. Configura tu base de datos y ajusta las credenciales en `app/config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'nombre_base_datos');
define('DB_USER', 'usuario');
define('DB_PASS', 'contraseña');
```

3. Levanta un servidor local (opcional si usas Apache/Nginx):

```bash
php -S localhost:8000 -t app/public
```

4. Accede a tu navegador:

```
http://localhost:8000
```

---

## 🧠 Cómo funciona

- `Router.php` se encarga de mapear las rutas definidas en `app.php` y redirigirlas al controlador correspondiente.
- `DB.php` proporciona una interfaz tipo ORM para construir consultas SQL de forma fluida (ej. `select()->where()->get()`).
- Los modelos como `autores`, `libros`, etc., heredan de `DB` y aprovechan esta funcionalidad sin necesidad de instanciar objetos.
- Las vistas están ubicadas en `resources/views`, y se renderizan con ayuda de la clase `Views`.

---

## 🧪 Ejemplo de uso (Consulta de autores)

```php
use app\models\autores;

$autor = new autores();

$datos = $autor->select(['id', 'nombre'])
              ->where([['nombre', '%Edson%']])
              ->orderBy([['id', 'DESC']])
              ->limit(5)
              ->get();
```

## 📦 Recursos incluidos

- [Bootstrap 5](https://getbootstrap.com)
- [jQuery](https://jquery.com)
- [SweetAlert2](https://sweetalert2.github.io/)

---

## 🤓 Autores

Desarrollado por **Edson Felix y Ceja Ayala**, estudiantes de Ingeniería en Software.  
Este proyecto fue creado con fines educativos y como práctica de fundamentos del desarrollo web sin frameworks.

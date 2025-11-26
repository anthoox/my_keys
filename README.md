# 🔑 Gestor de Claves

![PHP](https://img.shields.io/badge/PHP-7.4+-blue)
![MySQL](https://img.shields.io/badge/MySQL-Database-blue)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple)

**Gestor de Claves** es una aplicación web minimalista para almacenar y gestionar contraseñas de forma segura. Permite manejar servicios, usuarios y contraseñas con facilidad.

Todo está desarrollado con PHP bajo un patrón MVC propio, Bootstrap y PDO para garantizar seguridad, claridad y facilidad de uso.

---

## 🚀 Características principales

- Registro e inicio de sesión de usuarios (contraseñas hasheadas).
- Almacenamiento seguro de contraseñas (encriptación con OpenSSL).
- Listado de servicios con sus credenciales.
- Botones para:
  - **Ver / ocultar contraseña**
  - **Copiar usuario**
  - **Copiar contraseña**
- CRUD completo de servicios:
  - Crear
  - Editar
  - Eliminar
- Edición de perfil de usuario (email, nombre, contraseña).
- Eliminación de cuenta con confirmación mediante modal.
- Interfaz moderna con Bootstrap.
- Pantalla de inicio minimalista.

---

## 🛠️ Tecnologías utilizadas

- **PHP 8+**
- **Patrón MVC propio**
- **MySQL + PDO**
- **HTML5, CSS3, JavaScript**
- **Bootstrap 5**
- **XAMPP / WAMP** para entorno local
- **Git y GitHub**

---


## 🛠 Requisitos

- XAMPP, WAMP o servidor local similar  
- PHP >= 7.4  
- MySQL o MariaDB  
- Navegador moderno  

---

## 📦 Instalación

1. Clonar el repositorio:

```bash
git clone https://github.com/anthoox/my_keys.git
```
2. Copiar a la carpeta de tu servidor local (htdocs o equivalente).

3. Crear .env en la raíz con tus credenciales de DB:
    DB_HOST=localhost
    DB_NAME=gestor_claves
    DB_USER=root
    DB_PASS=tu_password
    DB_CHARSET=utf8mb4

3. Importar database/database.sql en MySQL.

4. Abrir en el navegador:
    http://localhost/gestor-de-claves/public

---

🗂 Estructura
/app
    /controllers
    /models
    /views
/resources
    /css
    /js
    /imgs
/public
    index.php
/database
    DataBase.php
    database.sql
.env

---

⚠️ Notas

No compartir .env. Cada usuario configura su conexión.

Para uso local y educativo.

Contraseñas almacenadas de forma segura.

---

👤 Autor

Anthony Alegría Alcántara

---

📄 Licencia

Uso libre con atribución al autor.
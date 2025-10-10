# 🔐 My Keys — Gestor Personal de Contraseñas

**My Keys** es una aplicación web desarrollada en **PHP (MVC puro)** que permite gestionar de forma segura tus contraseñas, llaves de acceso y cuentas personales.  
Funciona de forma **local** (sin necesidad de conexión a internet), ofreciendo una manera simple y segura de guardar tus datos sensibles.

---

## 🚀 Características principales

- ✅ Registro e inicio de sesión de usuarios.
- 🔑 Añadir, editar y eliminar contraseñas o llaves.
- 🧭 Clasificación por categorías (banco, correo, trabajo, redes, etc.).
- 🔍 Buscador por nombre o servicio.
- 💾 Backup: exportar e importar tus datos en formato JSON.
- 🧱 Arquitectura **MVC** limpia y extensible.
- 🛡️ Cifrado seguro con `password_hash()` y `openssl_encrypt()`.
- 🖼️ Interfaz moderna basada en **Bootstrap 5**.

---

## ⚙️ Instalación y configuración

### 1️⃣ Clonar el proyecto

git clone https://github.com/tuusuario/mykeys.git
cd mykeys

## 2️⃣ Configurar entorno
DB_HOST=localhost
DB_NAME=mykeys
DB_USER=root
DB_PASS=
APP_URL=http://localhost/mykeys/public
APP_NAME="My Keys"
ENCRYPTION_KEY="clave_super_secreta_para_cifrar_contraseñas"

## 3️⃣ Crear la base de datos

Ejecuta este script SQL (para MySQL):
CREATE DATABASE mykeys CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mykeys;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(150) UNIQUE,
  password VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  user_id INT,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE keys (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  category_id INT NULL,
  service_name VARCHAR(150),
  username VARCHAR(150),
  password_encrypted TEXT,
  notes TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

## 4️⃣ Iniciar el servidor local
php -S localhost:8000 -t public
Luego abre http://localhost:8000

## 🧠 Uso básico

Regístrate con tu email y contraseña.

Inicia sesión en el panel principal.

Crea una nueva clave (servicio, usuario, contraseña, categoría y notas opcionales).

Edita o elimina las claves según necesites.

Usa el buscador para encontrar servicios específicos.

Exporta o importa tus claves en formato JSON.

## 🧱 Arquitectura y seguridad

Patrón MVC: separación clara entre lógica, presentación y datos.

Controladores gestionan las rutas y peticiones HTTP.

Modelos usan PDO con consultas preparadas (seguridad contra SQL Injection).

Contraseñas de usuario: password_hash() + password_verify().

Contraseñas almacenadas: cifradas con openssl_encrypt() usando la clave del .env.

## 🧪 Testing y QA

Para verificar el correcto funcionamiento:

Registrar un nuevo usuario.

Iniciar sesión y crear una nueva clave.

Editar la clave y verificar cambios.

Eliminar una clave y confirmar.

Exportar todas las claves e importarlas de nuevo.

Cerrar sesión e intentar acceder a rutas protegidas.

## 📚 Documentación interna del código

El proyecto incluye documentación inline para facilitar su mantenimiento:

Clases y métodos PHP con /** docblocks */ explicando parámetros y retorno.

Comentarios HTML en las vistas, indicando la función de cada bloque.

Comentarios JS aclarando la lógica de interacción con el DOM.

README.md y TESTING.md como documentación general y guía de pruebas.

Ejemplo de documentación interna:

/**
 * Crea una nueva clave cifrada.
 *
 * @param array $data [service_name, username, password, category_id, notes]
 * @return bool True si se creó correctamente.
 */
public function create(array $data) { ... }

## 👨‍💻 Autor

Anthony Alegría
Desarrollador web autodidacta.
Apasionado por PHP, JavaScript y el aprendizaje continuo.

🌐 [GitHub](https://github.com/anthoox/my_keys)


## 📄 Licencia

Este proyecto se distribuye bajo la licencia MIT.
Eres libre de usarlo, modificarlo y compartirlo bajo las mismas condiciones.

## 🏁 Estado del proyecto

🧱 En desarrollo — Versión inicial con autenticación, CRUD, categorías y sistema de backup funcional.
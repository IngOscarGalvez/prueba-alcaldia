# Sistema de Gestión de Empleados

Este proyecto es un sistema de gestión de empleados construido con Laravel 10 en el backend y Vue 3 + Inertia.js en el frontend. La base de datos utilizada es PostgreSQL.

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalados los siguientes componentes:

- PHP >= 8.1
- Composer
- Node.js >= 14
- PostgreSQL
- Git

## Instalación

Sigue estos pasos para configurar el proyecto en tu máquina local:

### 1. Clonar el repositorio

```bash
git clone https://github.com/IngOscarGalvez/prueba-alcaldia.git
cd tu-repositorio
```
### 2. Configurar las variables de entorno
Copia el archivo .env.example a .env:
```bash
cp .env.example .env
```
Edita el archivo .env para configurar la conexión a la base de datos PostgreSQL:

```makefile
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```
### 3. Instalar dependencias
Instala las dependencias de PHP con Composer:
```bash
composer install
```
Instala las dependencias de Node.js con npm:

```bash
npm install
npm run dev
```
### 4. Generar la clave de la aplicación
```bash
php artisan key:generate
```
### 5. Ejecutar las migraciones y los seeders
```bash
php artisan migrate --seed
```
### 6. Iniciar el servidor de desarrollo
```bash
php artisan serve
```
Por defecto, la aplicación estará disponible en http://localhost:8000.

### Uso
La aplicación proporciona una interfaz para gestionar empleados, departamentos y tipos de identificación. Utiliza Vue 3 para el frontend y Laravel 10 para el backend, con Inertia.js facilitando la comunicación entre ambos.

### Iniciar sesión
Accede a la aplicación y sigue las instrucciones para iniciar sesión o registrar una nueva cuenta.

### Estructura del Proyecto
- app/Models: Contiene los modelos Eloquent.
- database/migrations: Contiene las migraciones de la base de datos.
- database/seeders: Contiene los seeders de la base de datos.
- resources/js: Contiene los archivos de Vue 3.
- routes/web.php: Contiene las rutas de la aplicación.
### Tecnologías Utilizadas
- Laravel 10: Framework PHP para el backend.
- Vue 3: Framework JavaScript para el frontend.
- Inertia.js: Facilita la construcción de aplicaciones monolíticas con Vue y Laravel.
- PostgreSQL: Base de datos relacional.

### Desarrollo
Para iniciar el servidor de desarrollo y recompilar los activos en tiempo real:

```bash
npm run dev
php artisan serve
```
### Despliegue
Asegúrate de configurar las variables de entorno adecuadamente en tu servidor de producción. Luego, ejecuta los siguientes comandos para preparar la aplicación para producción:

``` bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

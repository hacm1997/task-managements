# Proyecto Laravel - Task Management

Este es un servicio (backend) de gestión de tareas desarrollado en Laravel

## Requisitos

Antes de ejecutar el proyecto, asegurarse de tener instalados los siguientes requisitos:

-   **PHP**: Versión 8.1 o superior
-   **Composer**: Para la gestión de dependencias de PHP
-   **Node.js** y **npm**: Para la gestión de dependencias de JavaScript
-   **MySQL**: Para la base de datos

## Instalación

### 1. Clonar el repositorio

Ejecutar el siguiente comando para clonar el repositorio:

```bash
git clone https://github.com/hacm1997/task-managements.git
cd task-managements
```

### 2. Instalar dependencias de Composer

-   composer install

### 3. Configurar el archivo .env

Dejé el archivo .env ya configurado más que todo para la conexión con MySQL:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task-management
DB_USERNAME=root
DB_PASSWORD=root

Puede dejarlo como ya está diseñado o cambiarlo, se debe tener en cuenta los datos mostrados para establecer la conexión con MySQL

### 4. Crear la base de datos

Asegurarse de tener MySQL instalado y ejecutándose

-   Si se está en un distribución de Linux ejecutar:

```bash
CREATE DATABASE task-management;
```

-   Si se hace desde windows, usar MySQL Workbench o alguna herramienta que usted prefiera para ejecutar MySQL y crear la base de datos

### 5. Ejecutar migraciones

Una vez creada la base de datos, ejecuta las migraciones para crear las tablas necesarias:

```bash
php artisan migrate
```

### 6. nstalar dependencias de npm

Se debe tener Node.js y npm instalados. Luego, ejecutar el siguiente comando en la raíz del proyecto:

```bash
npm install
```

o bien también funciona con:

```bash
npm i
```

### 7. Compilar los assets

Compilar los archivos CSS y JavaScript:

```bash
npm run dev
```

### 8. Ejecución del servicio

Para ejecutar el servicio, utilizar el siguiente comando:

```bash
php artisan serve
```

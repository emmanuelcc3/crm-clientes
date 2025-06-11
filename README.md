# CRM Clientes

Este es un sistema CRM para gestionar clientes, desarrollado en Laravel.

## 🚀 Funcionalidades principales

- CRUD de clientes
- Exportación a PDF y Excel
- Búsqueda y paginación con DataTables
- Autenticación con Laravel Breeze
- Diseño con AdminLTE

## ⚙️ Requisitos

- PHP 8.1+
- Composer
- MySQL o MariaDB
- Node.js y npm (opcional para frontend)

## 🛠️ Instalación

1. Clona el repositorio:

```bash
git clone https://github.com/emmanuelcc3/crm-clientes.git
cd crm-clientes
```

2. Instala dependencias:

```bash
composer install
```

3. Crea tu archivo de entorno:

```bash
cp .env.example .env
```

4. Genera la clave de aplicación:

```bash
php artisan key:generate
```

5. Configura tu base de datos en `.env`

6. Ejecuta las migraciones:

```bash
php artisan migrate
```

7. Inicia el servidor:

```bash
php artisan serve
```

---

_Repositorio respaldado el 2025-05-31_

# Poster APP!

## Instrucciones para ejecutar el backend

- instalar dependencias del backend **`composer install`**

- instalar dependencias del frontend **`npm install`**

- Crear archivos .env con el siguiente comando **`composer run-script post-root-package-install`** esto creara dos archivos el primero llamado .env y el segundo llamado .env.dev este segundo se utilizara para el modo development. Configurar en cada archvivo las variables necesarias como los token de acceso de los servicios de facebook y cloudinary y la url base(MIX_API_ENDPOINT) de la api. Ej: **MIX_API_ENDPOINT=http://localhost/api/v1**, reemplazar localhost por el dominio donde este corriendo la api.

- Generar key **`composer run-script post-create-project-cmd`**

- Corregir errores de sintaxys **`npm run lint`**

- Compilar javascripts y sass **`npm run dev`**

#### Los siguientes pasos son opcionales. Se puede configurar un servidor aparte si no se quiere utilizar el que incorpora laravel por defecto.

- Correr servidor con **`php artisan serve --pot=80`**

- Acceder a la appliacion con la siguiente url: **http://localhost/poster**. Reemplazar localhost por el dominio donde este corriendo el servidor.
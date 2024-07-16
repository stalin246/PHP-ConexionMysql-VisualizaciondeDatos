
# Conexión PHP a MySQL y Consulta de Datos

## Introducción
Este documento proporciona una guía paso a paso sobre cómo conectar PHP a una base de datos MySQL y cómo realizar consultas y mostrar datos en una aplicación web. Utilizaremos XAMPP como servidor local para ejecutar nuestro código PHP.

## Requisitos Previos
- XAMPP instalado en tu máquina
- Conocimiento básico de PHP y MySQL
- MySQL Workbench o cualquier otra herramienta para gestionar bases de datos MySQL

## Pasos para Conectar PHP a MySQL

### 1. Configuración de la Base de Datos
- Crear una base de datos llamada `appsalon`.
- Crear una tabla `servicios` con las siguientes columnas:
  - `id` (INT, PRIMARY KEY, AUTO_INCREMENT)
  - `nombre` (VARCHAR(255))
  - `precio` (DECIMAL(10, 2))

### 2. Creación de la Base de Datos (Ejemplo en MySQL Workbench)
```sql
CREATE DATABASE appsalon;
USE appsalon;

CREATE TABLE servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL
);

INSERT INTO servicios (nombre, precio) VALUES
('Corte de Cabello Niño', 60.00),
('Corte de Cabello Hombre', 80.00),
('Corte de Barba', 60.00),
('Peinado Mujer', 80.00),
('Peinado Hombre', 60.00),
('Tinte', 300.00),
('Uñas', 400.00),
('Lavado de Cabello', 50.00),
('Tratamiento Capilar', 150.00);
```

### 3. Configuración del Proyecto PHP

#### Estructura de Archivos
```
AppSalon_PHP/
|-- includes/
|   |-- database.php
|   |-- funciones.php
|-- index.php
|-- build/
    |-- css/
        |-- app.css
```

#### Archivo `database.php`
Este archivo contiene la configuración de la conexión a la base de datos.
```php
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "appsalon";

// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
echo "Conexión exitosa";
?>
```

#### Archivo `funciones.php`
Este archivo contiene la función para obtener los servicios desde la base de datos.
```php
<?php

function obtenerServicios() {
    try {
        // Importar las credenciales y la conexión a la base de datos
        require "database.php";

        // Consulta SQL para seleccionar todos los registros de la tabla 'servicios'
        $sql = "SELECT * FROM servicios;";

        // Realizar la consulta con PHP utilizando la conexión establecida y la consulta SQL
        $consulta = mysqli_query($conn, $sql);

        // Verificar si la consulta se realizó correctamente
        if ($consulta === false) {
            throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
        }

        // Retornar la consulta para ser utilizada posteriormente
        return $consulta;

    } catch (Throwable $th) {
        // Manejo de excepciones
        echo "Error: ";
        var_dump($th);
    }
}
?>
```

#### Archivo `index.php`
Este archivo muestra los servicios obtenidos de la base de datos en una página web.
```php
<?php
require "includes/funciones.php";
$query = obtenerServicios();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Salón de Belleza</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="build/css/app.css">
</head>
<body>
    <div class="contenedor-estetica">
        <div class="imagen"></div>
        <div class="app">
            <header class="header">
                <h1>App Peluqueria</h1>
            </header>
            <div class="seccion">
                <h2>Servicios</h2>
                <p class="text-center">Elige tus Servicios a Continuación</p>
                <div id="servicios" class="listado-servicios">
                    <?php
                    while($servicio = mysqli_fetch_assoc($query)) {
                    ?>
                    <div class="servicio">
                        <p class="nombre-servicio">
                            <?php echo $servicio["nombre"]; ?>
                        </p>
                        <p class="precio-servicio">
                            <?php echo $servicio["precio"]; ?>
                        </p>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
```

### 4. Ejecutar el Proyecto
- Coloca todos los archivos en la carpeta `htdocs` de XAMPP.
- Abre XAMPP y asegúrate de que los servicios Apache y MySQL estén en ejecución.
- Accede a la aplicación en tu navegador mediante `http://localhost/AppSalon_PHP/index.php`.

### Notas Adicionales
- Asegúrate de que los permisos de los archivos sean correctos para permitir la ejecución de los scripts PHP.
- Si encuentras algún error, revisa los logs de Apache para más detalles.

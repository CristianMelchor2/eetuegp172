# Instrucciones para desplegar este proyecto en InfinityFree

## 1. Requisitos
- Hosting gratuito InfinityFree (https://infinityfree.net/) o similar
- PHP 7.2–7.4 recomendado (CodeIgniter 3.x)
- MySQL

## 2. Subida de archivos
1. Descarga o clona este repositorio en tu PC.
2. Sube todo el contenido de la carpeta `open/` al directorio raíz de tu dominio en InfinityFree usando el Administrador de Archivos o FTP.

## 3. Configuración de la base de datos
1. En el panel de InfinityFree, crea una nueva base de datos MySQL y toma nota de:
   - Nombre de la base de datos
   - Usuario
   - Contraseña
   - Host (normalmente `sqlXXX.infinityfree.com`)
2. Importa el archivo SQL desde `open/installation/sql/` usando phpMyAdmin para crear las tablas y datos iniciales.
3. Copia el archivo `open/application/config/database.php` a `open/application/config/database.php` (si no existe) y edítalo con tus datos de conexión:

```php
$db['default'] = array(
    'hostname' => 'sqlXXX.infinityfree.com',
    'username' => 'epiz_XXXXXXX',
    'password' => 'TU_PASSWORD',
    'database' => 'epiz_XXXXXXX_nombre',
    'dbdriver' => 'mysqli',
    // ...otros parámetros...
);
```

## 4. Permisos y carpetas
- Asegúrate de que las carpetas `open/uploads/` y `open/application/logs/` existan y tengan permisos de escritura.

## 5. Configuración de PHP
- Si puedes, selecciona PHP 7.2–7.4 en el panel de InfinityFree.

## 6. Solución de problemas
- Si ves un error 500:
  - Verifica el archivo `.htaccess` en la raíz de `open/`.
  - Revisa los datos de conexión en `database.php`.
  - Consulta los logs de errores en el panel de InfinityFree.
- Si el login no funciona, revisa la tabla de usuarios y la configuración de la base de datos.

## 7. Seguridad
- El archivo `test_db.php` ha sido eliminado por seguridad.
- No subas archivos de prueba ni credenciales personales.

## 8. Contacto
Si tienes problemas, consulta con el responsable del proyecto o revisa la documentación de CodeIgniter.

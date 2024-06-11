# Inar Technologies

Bienvenido a la guía de instalación de tu proyecto Laravel 11 con Livewire 3 y Filament v3. Sigue estos pasos para configurar el proyecto en tu entorno local o en la nube.

## Tabla de Contenidos

-   [Requisitos](#requisitos)
-   [Clonar el Repositorio](#clonar-el-repositorio)
-   [Instalación](#instalación)
    -   [Instalar Dependencias](#instalar-dependencias)
    -   [Configuración del Archivo `.env`](#configuración-del-archivo-env)
    -   [Ejecutar el Comando de Instalación](#ejecutar-el-comando-de-instalación)
    -   [Optimizar del proyecto](#optimizar-el-proyecto)
-   [Ejecución del Proyecto](#ejecución-del-proyecto)
-   [Solución de Problemas](#solución-de-problemas)
-   [Licencia](#licencia)

## Requisitos

Asegúrate de tener instalados los siguientes requisitos antes de proceder con la instalación:

-   [Composer](https://getcomposer.org/)
-   [Node.js](https://nodejs.org/)
-   [NPM](https://www.npmjs.com/)
-   [Git](https://git-scm.com/)
-   Servidor web compatible con PHP (Apache, Nginx, etc.)

## Clonar el Repositorio

Clona el repositorio del proyecto en tu máquina local o en tu servidor en la nube utilizando el siguiente comando:

```bash
git clone https://github.com/jesus9314/inar-technologies.git
cd inar-technologies
```

## Instalación

### Instalar Dependencias

Instala las dependencias de PHP y JavaScript utilizando Composer y NPM respectivamente:

```bash
composer install
npm install
```

### Configuración del Archivo .env

Copia el archivo de configuración de ejemplo y ajusta los parámetros según tu entorno:

```bash
cp .env.example .env
```

Abre el archivo .env en tu editor de texto favorito y configura los valores necesarios, como la conexión a la base de datos, el correo electrónico, etc.

### Ejecutar el Comando de Instalación

Para instalar y configurar todo lo necesario para el proyecto, ejecuta el comando personalizado:

1. Este comando realiza las migraciones, corre los seeders correspondientes, y hace las configuraciones correspondientes a FilamentShield

```bash
php artisan project:install
```

<font color="red">**¡Advertencia!** El siguiente comando no se debe usar en producción 2. Este comando realiza todo lo del anterior, pero refresca la base de datos, eliminando toda la información almacenada, se recomienda usarla con el cautelo necesario

```bash
php artisan project:install --fresh
```

</font>

Este comando se encargará de ejecutar las migraciones, sembrar la base de datos y cualquier otra configuración necesaria.

### Optimizat el proyecto

Para optimizar todo proyecto de filament son necesarios los siguientes comandos:

-   Almacenar los íconos blade en el caché:

Es posible que desee considerar la ejecución php artisan icons:cachelocal y también en su secuencia de comandos de implementación. Esto se debe a que Filament utiliza el paquete <a href="https://blade-ui-kit.com/blade-icons" target="_blank"> Blade Icons</a> , que puede tener mucho más rendimiento cuando se almacena en caché.

```bash
php artisan icons:cache
```

-   Almacenar los componentes de filament en el caché:

También es posible que desee considerar la ejecución php artisan filament:cache-componentsen su secuencia de comandos de implementación, especialmente si tiene una gran cantidad de componentes (recursos, páginas, widgets, administradores de relaciones, componentes Livewire personalizados, etc.). Esto creará archivos de caché en el bootstrap/cache/filamentdirectorio de su aplicación, que contienen índices para cada tipo de componente. Esto puede mejorar significativamente el rendimiento de Filament en algunas aplicaciones, ya que reduce la cantidad de archivos que deben escanearse y descubrirse automáticamente en busca de componentes.

```bash
php artisan filament:cache-components
```

Sin embargo, si está desarrollando activamente su aplicación localmente, debe evitar usar este comando, ya que evitará que se descubran componentes nuevos hasta que se borre o reconstruya el caché.

Puede borrar el caché en cualquier momento sin reconstruirlo ejecutando:

```bash
php artisan filament:clear-cached-components
```

-   Optimizar la aplicación de Laravel

También debería considerar optimizar su aplicación Laravel para producción ejecutándola php artisan optimizeen su script de implementación. Esto almacenará en caché los archivos de configuración y las rutas.

```bash
php artisan optimize
```

Sin Embargo, todos estos comandos, con excepción del 'php artisan filament:clear-cached-components' han sido combinados en uno solo para la facilidad de instalación.

```bash
php artisan project:optimize
```

## Ejecución del Proyecto

Una vez completada la instalación, puedes iniciar el servidor de desarrollo de Laravel con el siguiente comando:

```bash
php artisan serve
```

Abre tu navegador y visita http://localhost:8000 para ver el proyecto en funcionamiento.

## Solución de Problemas

Si encuentras algún problema durante la instalación o ejecución del proyecto, consulta la sección de solución de problemas a continuación:

### Errores Comunes

**Error de Permisos:** Asegúrate de que el servidor web tenga los permisos adecuados para leer y escribir en los directorios necesarios.

**Problemas de Conexión a la Base de Datos:** Verifica que los parámetros de la base de datos en el archivo .env sean correctos.

## Recursos Adicionales

-   <a href="https://laravel.com/docs/11.x/releases" target="_blank">Documentación de Laravel</a>
-   <a href="https://livewire.laravel.com/docs/quickstart" target="_blank">Documentación de Livewire</a>
-   <a href="https://filamentphp.com/docs" target="_blank">Documentación de Filament</a>

Si necesitas más ayuda, no dudes en abrir un issue en el repositorio del proyecto o contactarme directamente.

¡Gracias por utilizar este proyecto!

## Licencia

Este proyecto está licenciado bajo la Licencia MIT. Para más detalles, consulta el archivo [LICENSE](LICENSE) incluido en este repositorio.


# Inar Technologies

Bienvenido a la guía de instalación de tu proyecto Laravel 11 con Livewire 3 y Filament v3. Sigue estos pasos para configurar el proyecto en tu entorno local o en la nube.

## Tabla de Contenidos
- [Requisitos](#requisitos)
- [Clonar el Repositorio](#clonar-el-repositorio)
- [Instalación](#instalación)
  - [Instalar Dependencias](#instalar-dependencias)
  - [Configuración del Archivo `.env`](#configuración-del-archivo-env)
  - [Ejecutar el Comando de Instalación](#ejecutar-el-comando-de-instalación)
- [Ejecución del Proyecto](#ejecución-del-proyecto)
- [Solución de Problemas](#solución-de-problemas)
- [Licencia](#licencia)

## Requisitos

Asegúrate de tener instalados los siguientes requisitos antes de proceder con la instalación:

- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/)
- [NPM](https://www.npmjs.com/)
- [Git](https://git-scm.com/)
- Servidor web compatible con PHP (Apache, Nginx, etc.)

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

```bash
php artisan project:install
```

Este comando se encargará de ejecutar las migraciones, sembrar la base de datos y cualquier otra configuración necesaria.

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

* <a href="https://laravel.com/docs/11.x/releases" target="_blank">Documentación de Laravel</a>
* <a href="https://livewire.laravel.com/docs/quickstart" target="_blank">Documentación de Livewire</a>
* <a href="https://filamentphp.com/docs" target="_blank">Documentación de Filament</a>

Si necesitas más ayuda, no dudes en abrir un issue en el repositorio del proyecto o contactarme directamente.

¡Gracias por utilizar este proyecto!

## Licencia

Este proyecto está licenciado bajo la Licencia MIT. Para más detalles, consulta el archivo [LICENSE](LICENSE) incluido en este repositorio.

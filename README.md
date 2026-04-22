# ACNH Project - API REST con Angular

API MVC en PHP con autenticación, diseñada para ser consumida desde Angular. Aplicación para gestionar y explorar la colección de aldeanos, bichos, peces y criaturas marinas de Animal Crossing: New Horizons.

## Estructura del Proyecto

```
ACNH_TFG/
├── acnh_project/          # Backend - API REST en PHP
│   ├── index.php          # Punto de entrada
│   ├── controllers/       # Controladores (retornan JSON)
│   │   ├── AppController.php              # Login, logout, verificar sesión
│   │   ├── UsuarioController.php          # Gestión de usuarios
│   │   ├── TipoColeccionableController.php # Tipos de coleccionables
│   │   ├── AldeanosUsuarioController.php   # Aldeanos del usuario
│   │   ├── ColeccionablesUsuarioController.php  # Coleccionables del usuario
│   │   └── NookipediaController.php       # Proxy a API Nookipedia
│   ├── models/            # Modelos (acceso a BD)
│   │   ├── UsuarioModel.php
│   │   ├── TipoColeccionableModel.php
│   │   ├── AldeanosUsuarioModel.php
│   │   └── ColeccionablesUsuarioModel.php
│   ├── libs/              # Librerías
│   │   ├── Config.php
│   │   ├── SPDO.php      # PDO wrapper
│   │   ├── FrontController.php  # Enrutador
│   │   ├── NookipediaClient.php # Cliente HTTP para Nookipedia
│   │   └── setup.php      # Configuración y token Nookipedia
│   └── acnh_project.sql   # Base de datos
│
└── acnh_web/              # Frontend - Angular
    ├── src/
    │   ├── index.html
    │   ├── main.ts
    │   ├── styles.css
    │   ├── app/
    │   │   ├── app.component.*
    │   │   ├── app.routes.ts      # Rutas de la aplicación
    │   │   ├── app.config.ts      # Configuración de Angular
    │   │   ├── header/            # Componente header
    │   │   ├── footer/            # Componente footer
    │   │   ├── home/              # Página de inicio
    │   │   ├── login/             # Página de login
    │   │   ├── villagers/         # Listado de aldeanos
    │   │   ├── bugs/              # Listado de bichos
    │   │   ├── fish/              # Listado de peces
    │   │   ├── sea-creatures/     # Listado de criaturas marinas
    │   │   └── services/
    │   │       ├── nookipedia.service.ts      # Consumo de API
    │   │       ├── translation.service.ts     # Traducción de contenidos
    │   │       └── theme.service.ts           # Temas de la aplicación
    │   └── assets/
    ├── angular.json
    ├── package.json
    └── tsconfig.json
```

## Backend - API REST

### Configuración

El backend se ejecuta en: `http://localhost/ACNH_TFG/acnh_project/`

Base de datos MySQL via XAMPP puerto 3306, con credenciales en `libs/setup.php`.

### Uso de la API

### Login

**POST:** `index.php?controlador=App&accion=login`

```json
{
  "login": "usuario",
  "password": "contraseña"
}
```

**Respuesta:**
```json
{
  "status": "success",
  "message": "Login exitoso",
  "usuario": "usuario"
}
```



## Endpoints añadidos en esta iteración

### Tipo Coleccionable
- `GET  index.php?controlador=TipoColeccionable&accion=listar`
- `GET  index.php?controlador=TipoColeccionable&accion=ver&id={id}`
- `POST index.php?controlador=TipoColeccionable&accion=crear`
- `POST index.php?controlador=TipoColeccionable&accion=actualizar&id={id}`
- `GET  index.php?controlador=TipoColeccionable&accion=eliminar&id={id}`

### Aldeanos Usuario
- `GET  index.php?controlador=AldeanosUsuario&accion=listar`
- `GET  index.php?controlador=AldeanosUsuario&accion=ver&id={id}`
- `GET  index.php?controlador=AldeanosUsuario&accion=listarPorUsuario&id_usuario={id_usuario}`
- `POST index.php?controlador=AldeanosUsuario&accion=crear`
- `POST index.php?controlador=AldeanosUsuario&accion=actualizar&id={id}`
- `GET  index.php?controlador=AldeanosUsuario&accion=eliminar&id={id}`

### Coleccionables Usuario
- `GET  index.php?controlador=ColeccionablesUsuario&accion=listar`
- `GET  index.php?controlador=ColeccionablesUsuario&accion=ver&id={id}`
- `GET  index.php?controlador=ColeccionablesUsuario&accion=listarPorUsuario&id_usuario={id_usuario}`
- `POST index.php?controlador=ColeccionablesUsuario&accion=crear`
- `POST index.php?controlador=ColeccionablesUsuario&accion=actualizar&id={id}`
- `GET  index.php?controlador=ColeccionablesUsuario&accion=eliminar&id={id}`

## Notas de CORS / Angular
- CORS ya está configurado globalmente en `libs/FrontController.php` y como método en cada controlador.
- Angular en `http://localhost:4200` puede consumir la API sin error de origen cruzado.
- Base de datos MySQL via XAMPP puerto 3306, datos en `libs/setup.php`.

## Token de Nookipedia en backend
- El token de Nookipedia se guarda de forma privada en `libs/setup.php`.
- Evita exponer el token en Angular o en el cliente.


## Endpoints de Nookipedia proxy
- `GET index.php?controlador=Nookipedia&accion=listarAldeanos&search={nombre}`
- `GET index.php?controlador=Nookipedia&accion=listarColeccionables&type={bugs|fish|sea-creatures}&name={nombre}`
- `GET index.php?controlador=Nookipedia&accion=buscarDetalle&resource={villagers|bugs|fish|sea-creatures}&name={nombre}`

Micro MVC API en PHP con autenticación que devuelve JSON para consumo desde Angular

## Frontend - Angular

La aplicación Angular se ejecuta en: `http://localhost:4200`

### Rutas disponibles

```
/                    → Redirecciona a /home
/home                → Página de inicio
/villagers           → Listado de aldeanos
/bugs                → Listado de bichos
/fishes              → Listado de peces
/seacreatures        → Listado de criaturas marinas
/login               → Página de login (disponible pero no implementada en rutas)
```

### Componentes implementados

1. **Header** - Navegación principal con enlaces a todas las secciones
2. **Footer** - Pie de página con información del proyecto
3. **Home** - Página de inicio con información general
4. **Villagers** - Lista interactiva de aldeanos desde Nookipedia
5. **Bugs** - Lista de bichos/insectos desde Nookipedia
6. **Fish** - Lista de peces desde Nookipedia
7. **Sea-Creatures** - Lista de criaturas marinas desde Nookipedia
8. **Login** - Componente para autenticación (estructura preparada)

### Servicios implementados

1. **NookipediaService**
   - `getVillagers(search?, personality?, species?)` - Obtiene aldeanos con filtros opcionales
   - `getCollectibles(type, name?)` - Obtiene bichos, peces o criaturas marinas
   - `getEvents(date?, year?, month?, day?)` - Obtiene eventos de Animal Crossing
   - Contacta con el proxy backend para acceder a la API de Nookipedia

2. **TranslationService**
   - `translateVillager(villager)` - Traduce propiedades de aldeanos
   - `translateCollectible(collectible)` - Traduce propiedades de coleccionables
   - Soporta múltiples idiomas (es, en, fr, etc.)

3. **ThemeService**
   - Gestión de temas visuales de la aplicación
   - Alternancia entre temas oscuro/claro

### Configuración de Angular

- Base URL de la API configurada en `NookipediaService`: `http://localhost/ACNH_TFG/acnh_project/index.php`
- HttpClient configurado en `app.config.ts` con soporte para CORS
- RxJS Observables para manejo asincrónico de datos

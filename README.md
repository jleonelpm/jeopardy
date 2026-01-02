<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# 🎮 Jeopardy - Plataforma de Juegos Educativos

Una plataforma interactiva para crear y jugar Jeopardy con Tailwind CSS, Vue 3 y Filament Admin Panel.

## 📋 Stack Tecnológico

### Backend
- **Laravel 12** - Framework PHP moderno
- **Filament 4.4** - Admin panel profesional
- **MySQL** - Base de datos relacional
- **PHP 8.4** - Lenguaje backend

### Frontend
- **Vue 3** - Framework JavaScript reactivo
- **Tailwind CSS** - Utilidades CSS modernas
- **Vite 7.3** - Bundler rápido
- **Livewire 3** - Componentes interactivos

### Admin Panel
- **Filament** - Admin panel basado en Livewire
- **Componentes Rich** - Tablas, formularios, acciones
- **Validación integrada** - Server-side y client-side

## 🚀 Características Principales

### Juego Interactivo
- 🎯 Tablero dinámico con categorías y preguntas
- ⏱️ Temporizador circular con estados visuales
- 🎨 Interfaz responsiva y animada
- 🔊 Efectos de sonido (MP3) para respuestas

### Panel Administrativo (Filament)
- 📚 Gestión de categorías y preguntas
- 🎮 Gestión de partidas y equipos
- 🔍 Búsqueda y filtrado avanzado
- 📊 Tablas con paginación y ordenamiento
- ✅ Validaciones automáticas en formularios

### Gestión de Datos
- 👥 Múltiples equipos por partida
- 📈 Sistema de puntuación en tiempo real
- 🔄 Rotación automática de turnos
- 📱 Datos responsivos para todas las pantallas

## 📁 Estructura del Proyecto

```
jeopardy/
├── app/
│   ├── Models/              # Modelos Eloquent
│   ├── Http/
│   │   ├── Controllers/     # Controladores
│   │   └── Api/            # Rutas API
│   └── Filament/
│       └── Resources/       # Recursos admin
├── resources/
│   ├── js/
│   │   └── components/      # Componentes Vue
│   └── css/
├── routes/
│   ├── api.php             # Rutas API
│   └── web.php             # Rutas web
├── database/
│   ├── migrations/         # Migraciones
│   └── seeders/           # Seeders
└── public/
    └── sounds/            # Archivos MP3
```

## 🎨 Panel Administrativo - Filament

### Acceso
```
URL: http://localhost:8000/admin
Usuario: Credenciales de autenticación
```

### Recursos Disponibles

#### 1. Categorías
- Crear, editar y eliminar categorías
- Validación de nombre único
- Descripción opcional
- Contador de preguntas por categoría

#### 2. Preguntas  
- Gestión completa de preguntas
- Asociación a categorías
- Validación de puntos (100-1000)
- Control de tiempo límite (10-300s)
- Búsqueda y filtrado avanzado

#### 3. Partidas
- Estados: Preparación, En curso, Finalizada
- Control de publicación
- Gestión de número de filas
- Relación con equipos y turnos
- Filtros por estado y publicación

#### 4. Equipos
- Nombre y color distintivo
- Relación con partida
- Puntuación actualizada
- Ordenamiento por puntuación

## 📊 Modelos de Datos

### Relaciones
```
User (1) ─── (M) Game
Game (1) ─── (M) Team
Game (1) ─── (M) Turn
Game (M) ─── (M) Question (via GameQuestion)
Category (1) ─── (M) Question
Team (1) ─── (M) Turn
```

### GameQuestion Pivot
- Almacena si una pregunta ha sido usada
- Gestiona el estado de preguntas en partida

## 💾 Base de Datos

### Tablas Principales
- `users` - Moderadores
- `categories` - Categorías de preguntas
- `questions` - Base de preguntas
- `games` - Partidas
- `teams` - Equipos
- `turns` - Registro de turnos
- `game_questions` - Relación pregunta-partida

## 🔧 Instalación y Configuración

### Requisitos
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8.0+
- Extensiones: intl, zip

### Instalación Rápida
```bash
composer install
npm install
php artisan migrate
npm run build
php artisan serve
```

### Variables de Entorno
```env
DB_DATABASE=jeopardy
DB_USERNAME=root
DB_PASSWORD=
FILAMENT_PANEL_ID=admin
```

## 🎮 Uso del Juego

### Para Moderadores
1. Accede a `/admin`
2. Crea categorías y preguntas
3. Crea una partida y añade equipos
4. Publica la partida
5. Accede a `/play` para moderar

### Para Jugadores
1. Navega a `/play`
2. Selecciona la partida
3. Espera tu turno
4. Responde las preguntas
5. Gana puntos según respuestas

## 📱 Responsividad

Todas las interfaces son completamente responsivas:
- **Mobile**: Pantalla completa con scroll
- **Tablet**: Adapta contenido
- **Desktop**: Vista optimizada

Breakpoints: `sm:` (640px), `md:` (768px), `lg:` (1024px), `xl:` (1280px)

## 🔐 Seguridad

- Autenticación con Laravel Breeze
- Protección CSRF automática
- Rate limiting en API
- Validación server-side obligatoria
- Middleware `auth` en rutas protegidas

## 📖 Documentación Adicional

- [FILAMENT_SETUP.md](./FILAMENT_SETUP.md) - Configuración de Filament
- [FILAMENT_USAGE_GUIDE.md](./FILAMENT_USAGE_GUIDE.md) - Guía de uso del panel

## 🐛 Debugging

```bash
# Logs del servidor
php artisan pail --timeout=0

# Modo debug en .env
APP_DEBUG=true

# Caché limpio
php artisan cache:clear
php artisan config:clear
```

## 📝 Notas

- Los sonidos MP3 se cargan desde `/public/sounds/`
- Los activos Filament están en `/public/js/filament/` y `/public/css/filament/`
- El frontend usa Vite para desarrollo rápido
- La API REST proporciona endpoints para el juego

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Por favor:
1. Fork el proyecto
2. Crea una rama para tu feature
3. Commit tus cambios
4. Push a la rama
5. Abre un Pull Request

## 📄 Licencia

MIT - Libre para usar en proyectos personales y comerciales

## 👨‍💻 Desarrollo

Rama actual: `feature/mejora-ui-backend`

Cambios recientes:
- ✅ Implementación de Filament 4.4
- ✅ Recursos CRUD completos
- ✅ Validaciones mejoradas
- ✅ Tablas con búsqueda y filtrado
- ✅ Modal responsiva fullscreen (Preguntas)
- ✅ Sonidos en MP3

---

**Última actualización**: Enero 2026

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

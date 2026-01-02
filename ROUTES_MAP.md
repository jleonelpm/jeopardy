# 📍 Estructura de Rutas - Jeopardy

## 🗺️ Mapa Completo de Rutas

### 📌 Rutas Públicas
```
GET  /                    → Homepage (welcome)
GET  /play                → Listado de partidas públicas
GET  /play/{game}         → Panel de juego interactivo
```

⚠️ **Autenticación**: Solo `/admin/login` (Filament)

### 👤 Rutas de Usuario Autenticado
```
GET  /dashboard           → Dashboard del usuario
GET  /profile             → Editar perfil
PATCH /profile            → Actualizar perfil
DELETE /profile           → Eliminar cuenta
```

### 🔐 Autenticación (Filament)
```
GET  /admin/login         → Login administrativo (Filament)
POST /admin/logout        → Logout administrativo (Filament)
GET  /admin               → Dashboard administrativo
```

**Nota**: Autenticación centralizada en Filament. No hay rutas públicas de login/register.
Solo para gestión en tiempo real del juego frontend:
```
POST /games/{game}/teams                  → Crear equipo en partida
DELETE /games/{game}/teams/{team}         → Eliminar equipo de partida
POST /games/{game}/start                  → Iniciar partida
GET /games/{game}/preview                 → Preview de partida
POST /games/{game}/publish                → Publicar partida
POST /games/{game}/unpublish              → Despublicar partida
```

### 📊 Panel Administrativo (Filament)
**URL Base**: `/admin`

#### Gestión de Categorías
```
GET    /admin/categories              → Listar categorías
POST   /admin/categories              → Crear categoría
GET    /admin/categories/{record}/edit → Editar categoría
DELETE /admin/categories/{record}     → Eliminar categoría
```

#### Gestión de Preguntas
```
GET    /admin/questions               → Listar preguntas
POST   /admin/questions               → Crear pregunta
GET    /admin/questions/{record}/edit → Editar pregunta
DELETE /admin/questions/{record}      → Eliminar pregunta
```

#### Gestión de Partidas
```
GET    /admin/games                   → Listar partidas
POST   /admin/games                   → Crear partida
GET    /admin/games/{record}/edit     → Editar partida
DELETE /admin/games/{record}          → Eliminar partida
```

#### Gestión de Equipos
```
GET    /admin/teams                   → Listar equipos
POST   /admin/teams                   → Crear equipo
GET    /admin/teams/{record}/edit     → Editar equipo
DELETE /admin/teams/{record}          → Eliminar equipo
```

### 🔌 API REST (Endpoints)
**URL Base**: `/api`

#### Partidas
```
GET    /api/games/published           → Obtener partidas publicadas
GET    /api/games/{game}/board        → Obtener tablero de juego
PATCH  /api/games/{game}/finish       → Finalizar partida
PATCH  /api/games/{game}/questions/{question}/mark-used → Marcar pregunta como usada
```

#### Equipos
```
PATCH  /api/teams/{team}/score        → Actualizar puntaje de equipo
```

#### Turnos
```
POST   /api/games/{game}/turns        → Registrar turno
GET    /api/games/{game}/current-turn → Obtener turno actual
PATCH  /api/games/{game}/next-turn    → Pasar al siguiente turno
```

#### Usuario
```
GET    /api/user                      → Obtener usuario autenticado (Sanctum)
```

---

## 📊 Mapa Visual de Rutas (Árbol)

```
/
├── 📍 Públicas
│   ├── GET  /                    (Homepage)
│   ├── GET  /play                (Listar partidas)
│   └── GET  /play/{game}         (Panel de juego)
│
├── 👤 Usuario Autenticado
│   ├── GET  /dashboard           (Dashboard)
│   ├── GET  /profile             (Editar perfil)
│   ├── PATCH /profile            (Actualizar)
│   └── DELETE /profile           (Eliminar)
│
├── 🎮 Control de Partida
│   └── /games/{game}/
│       ├── POST /teams           (Crear equipo)
│       ├── DELETE /teams/{team}  (Eliminar equipo)
│       ├── POST /start           (Iniciar)
│       ├── GET /preview          (Preview)
│       ├── POST /publish         (Publicar)
│       └── POST /unpublish       (Despublicar)
│
├── 🔐 Autenticación (Filament)
│   ├── GET  /admin/login         (Login)
│   └── POST /admin/logout        (Logout)
│
├── 📊 Admin Panel (Filament)
│   └── /admin/
│       ├── GET  /                (Dashboard)
│       ├── 📁 /categories        (CRUD categorías)
│       ├── 📁 /questions         (CRUD preguntas)
│       ├── 📁 /games             (CRUD partidas)
│       └── 📁 /teams             (CRUD equipos)
│
└── 🔌 API REST
    └── /api/
        ├── 📁 /games/
        │   ├── GET /published      (Publicadas)
        │   ├── GET /{game}/board   (Tablero)
        │   ├── PATCH /{game}/finish (Finalizar)
        │   ├── PATCH /{game}/questions/{q}/mark-used
        │   ├── POST /{game}/turns    (Registrar turno)
        │   ├── GET /{game}/current-turn (Turno actual)
        │   └── PATCH /{game}/next-turn  (Siguiente turno)
        ├── 📁 /teams/
        │   └── PATCH /{team}/score (Actualizar puntos)
        └── GET /user               (Usuario actual)
```

---

## ✅ Estado de Rutas (Enero 2026)


### Rutas Verificadas (sin conflictos)
- ✅ `/admin/*` - Filament CRUD
- ✅ `/api/*` - REST API
- ✅ `/play/*` - Frontend Vue 3
- ✅ `/games/{game}/*` - Control de partidas en tiempo real

---

## 🔄 Flujo de Interacción

### Crear una Partida (Admin)
```
1. POST /admin/games              (Filament form)
2. Acceder a /admin/games         (Listar)
3. Click Edit                     (GET /admin/games/{id}/edit)
4. POST /games/{game}/publish     (Publicar vía ruta web)
```

### Jugar una Partida (User)
```
1. GET /play                      (Listar partidas)
2. GET /play/{game}               (Panel de juego)
3. GET /api/games/{game}/board    (Cargar estado)
4. POST /api/games/{game}/turns   (Registrar respuesta)
5. PATCH /api/teams/{team}/score  (Actualizar puntos)
6. PATCH /api/games/{game}/next-turn (Siguiente turno)
```

---


---

## 📋 Resumen por Componente

### Frontend (Vue 3 + Vite)
- **Ubicación**: `resources/js/`
- **Rutas usadas**: 
  - `/play` - Interfaz del juego
  - `/api/*` - Llamadas AJAX
  - `/sounds/*` - Archivos de audio

### Backend Admin (Filament)
- **Ubicación**: `app/Filament/`
- **Base URL**: `/admin`
- **Modelos**: Category, Question, Game, Team
- **Autenticación**: Laravel Breeze

### API REST
- **Ubicación**: `routes/api.php`
- **Base URL**: `/api`
- **Autenticación**: Sanctum
- **Consumidor**: Frontend Vue 3

---

## 🔐 Protección de Rutas

### Públicas
```
GET /
GET /play
GET /play/{game}
```

### Autenticadas (auth middleware)
```
GET /dashboard
GET /profile
PATCH /profile
DELETE /profile
POST /games/{game}/teams
DELETE /games/{game}/teams/{team}
... (todas las rutas POST/DELETE de juego)
```

### Panel Admin (auth + Filament)
```
GET /admin/login      → Sin autenticación requerida
POST /admin/logout    → Con autenticación
GET /admin/*          → CRUD con autenticación
POST /admin/*         → CRUD con autenticación
PATCH /admin/*        → CRUD con autenticación
DELETE /admin/*       → CRUD con autenticación
```

### API (auth:sanctum middleware)
```
GET /api/user
POST /api/*
PATCH /api/*
```

---

## 🚀 URLs de Acceso Rápido

| Funcionalidad | URL |
|---|---|
| Homepage | http://localhost:8000 |
| Jugar | http://localhost:8000/play |
| Dashboard | http://localhost:8000/dashboard |
| Admin Panel | http://localhost:8000/admin |
| Categorías | http://localhost:8000/admin/categories |
| Preguntas | http://localhost:8000/admin/questions |
| Partidas | http://localhost:8000/admin/games |
| Equipos | http://localhost:8000/admin/teams |


# Plan de Proyecto  
## Software Educativo Tipo Jeopardy (Juego Presencial por Equipos)

---

## 1. Introducción

Este documento describe el plan de desarrollo de un **software educativo tipo Jeopardy**, orientado a su uso en entornos presenciales (aula), donde un **moderador** controla el flujo del juego y los **estudiantes participan por equipos**.

El sistema está diseñado para ser **flexible en nivel educativo**, permitiendo su uso tanto en secundaria como en universidad, dependiendo del contenido cargado.

---

## 2. Objetivo General

Desarrollar un sistema web que permita implementar dinámicas de aprendizaje activo mediante un juego tipo Jeopardy, fomentando:

- Participación colaborativa
- Pensamiento crítico
- Discusión académica
- Motivación en el aula

---

## 3. Alcance del Proyecto (Versión 1 – MVP)

### Incluye
- Juego por equipos
- Uso presencial (una pantalla principal)
- Moderador como único controlador del sistema
- Contenido organizado por categorías
- Control de turnos y puntajes
- Temporizador por pregunta

### No incluye (futuras versiones)
- Participación remota
- Acceso individual de estudiantes
- Rankings históricos
- Integración con LMS
- Generación automática de preguntas con IA

---

## 4. Modalidad del Juego

- **Tipo de juego:** Por equipos
- **Número de equipos:** Configurable por partida
- **Interacción de estudiantes:** Oral y presencial
- **Validación de respuestas:** Exclusivamente por el moderador

---

## 5. Roles del Sistema

### 5.1 Moderador
Responsable de:
- Crear categorías y preguntas
- Iniciar y finalizar partidas
- Controlar turnos
- Validar respuestas
- Asignar o restar puntos
- Controlar el temporizador

### 5.2 Equipos
- Participan de forma colaborativa
- Responden verbalmente
- No interactúan directamente con el sistema en esta versión

---

## 6. Reglas del Juego

1. El moderador crea una partida.
2. Se muestran las categorías y puntajes.
3. El equipo en turno elige una pregunta.
4. Se muestra la pregunta en pantalla.
5. El equipo discute y responde oralmente.
6. El moderador valida la respuesta:
   - Correcta → se suman puntos.
   - Incorrecta → se restan puntos o se pierde el turno.
7. La pregunta queda bloqueada.
8. El juego continúa hasta agotar preguntas o finalizar la sesión.
9. Gana el equipo con mayor puntaje.

---

## 7. Tiempo Máximo por Pregunta

El tiempo depende de la dificultad:

| Dificultad | Puntaje | Tiempo Máximo |
|----------|--------|---------------|
| Básica   | 100    | 30 segundos   |
| Media    | 200    | 45 segundos   |
| Alta     | 300    | 60 segundos   |
| Reto     | 400–500| 90 segundos   |

> El moderador puede pausar, extender o finalizar el tiempo manualmente.

---

## 8. Funcionalidades Principales

### Gestión de Contenido
- CRUD de categorías
- CRUD de preguntas
- Asignación de puntajes y tiempos
- Respuesta correcta asociada a cada pregunta

### Gestión del Juego
- Creación de partidas
- Gestión de equipos
- Control de turnos
- Visualización del tablero
- Temporizador
- Control de puntajes en tiempo real

---

## 9. Modelo de Datos (Alto Nivel)

### Entidades principales
- Usuario (Moderador)
- Categoría
- Pregunta
- Partida
- Equipo
- Puntaje
- Turno

---

## 10. Stack Tecnológico

### Backend
- Laravel 11
- API REST
- Laravel Breeze / Jetstream (autenticación del moderador)
- MySQL o PostgreSQL
- Policies para control de acciones

### Frontend
- Vue 3 + Vite
- Pinia (estado global del juego)
- Vue Router
- Tailwind CSS
- Axios

### Tiempo Real (recomendado)
- Laravel Echo
- Pusher o Soketi

---

## 11. Arquitectura General

[Moderador - Navegador]
|
Vue 3
|
API REST
|
Laravel
|
Base de Datos


---

## 12. Metodología de Desarrollo

- Metodología ágil: **Scrum**
- Duración de sprint: **2 semanas**
- Enfoque: Incremental y funcional

---

## 13. Plan de Sprints

### Sprint 0 – Preparación
**Objetivo:** Base del proyecto  
- Definición de reglas del juego
- Wireframes iniciales
- Configuración del entorno
- Modelo de datos preliminar

**Entregable:** Proyecto base funcional

---

### Sprint 1 – Gestión de Contenido
**Objetivo:** Banco de preguntas  
- CRUD de categorías
- CRUD de preguntas
- Panel básico del moderador

**Entregable:** Gestión completa de contenido

---

### Sprint 2 – Tablero de Juego
**Objetivo:** Visualización tipo Jeopardy  
- Tablero dinámico
- Selección de preguntas
- Bloqueo de preguntas usadas

**Entregable:** Tablero operativo

---

### Sprint 3 – Lógica del Juego
**Objetivo:** Flujo completo del juego  
- Creación de partidas
- Gestión de equipos
- Turnos y puntajes
- Temporizador

**Entregable:** Juego completamente funcional

---

### Sprint 4 – UX y Pruebas
**Objetivo:** Uso real en aula  
- Mejoras visuales
- Mensajes claros
- Pruebas en entorno educativo
- Corrección de errores

**Entregable:** MVP listo para uso académico

---

## 14. Riesgos Identificados

- Dependencia del moderador
- Falta de claridad visual en proyectores
- Gestión del tiempo en clase
- Preparación previa del contenido

---

## 15. Posibles Extensiones Futuras

- Acceso desde dispositivos móviles
- Juego remoto
- Estadísticas por grupo
- Integración con IA para generar preguntas
- Exportación de resultados

---

## 16. Conclusión

Este proyecto busca ser una **herramienta didáctica flexible**, reusable y alineada con metodologías de aprendizaje activo, con una arquitectura escalable que permita futuras ampliaciones sin comprometer la simplicidad del uso en aula.

---

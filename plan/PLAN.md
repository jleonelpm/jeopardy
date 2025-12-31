# Plan de Proyecto  
## Software Educativo Tipo Jeopardy (Arquitectura Backend + Frontend)

---

## 1. Introducción

Este proyecto consiste en el desarrollo de un **software educativo tipo Jeopardy** para uso presencial, con una arquitectura claramente separada entre:

- Backend administrativo (Laravel + Blade)
- Frontend de juego (Laravel + Vue)
- API como capa de comunicación

El objetivo es garantizar **control pedagógico**, **orden previo al juego** y una **experiencia clara durante la partida**.

---

## 2. Objetivo General

Desarrollar una plataforma que permita al docente:

- Preparar completamente el juego antes de clase
- Publicar la partida solo cuando esté lista
- Ejecutar la dinámica del juego en un entorno visual e interactivo

---

## 3. Arquitectura General

[Backend - Blade] ---> [API Laravel] ---> [Frontend - Vue]
(Moderador) (REST) (Juego en Aula)


---

## 4. Backend (Laravel + Blade)

### Funciones del Backend
- CRUD de categorías
- CRUD de preguntas
- Creación y configuración de partidas
- Registro de equipos
- Vista previa del tablero
- Publicar / despublicar partidas
- Control de estado del juego

### Restricciones
- No se puede jugar desde el backend
- Una partida no publicada no es accesible desde el frontend

---

## 5. API

### Funciones de la API
- Obtener partidas publicadas
- Obtener tablero de juego
- Obtener equipos y puntajes
- Registrar selección de pregunta
- Validar respuesta
- Actualizar puntajes
- Controlar estado de la partida

---

## 6. Frontend (Laravel + Vue)

### Funciones del Frontend
- Visualización del tablero Jeopardy
- Desarrollo de la partida en aula
- Control de turnos
- Temporizador
- Asignación de puntajes
- Visualización en tiempo real

### Restricciones
- Solo muestra partidas publicadas
- No permite editar contenido

---

## 7. Flujo General del Sistema

1. El moderador configura todo en el backend
2. Previsualiza el tablero
3. Publica la partida
4. El frontend detecta la partida publicada
5. Se desarrolla el juego en aula
6. El moderador controla el juego desde el frontend
7. Se finaliza la partida

---

## 8. Metodología

- Scrum
- Sprints de 2 semanas
- Entregables funcionales por sprint

---

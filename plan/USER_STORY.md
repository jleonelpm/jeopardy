# Historias de Usuario  
## Software Educativo Tipo Jeopardy (Juego Presencial por Equipos)

---

## 1. Introducción

Este documento describe las **historias de usuario** del proyecto *Software Educativo Tipo Jeopardy*, diseñado para su uso presencial en entornos educativos.  
El sistema se basa en un **moderador** que controla el flujo del juego y **equipos de estudiantes** que participan de manera colaborativa.

---

## 2. Convenciones

- HU: Historia de Usuario  
- Cada historia incluye:
  - Descripción
  - Propósito
  - Criterios de aceptación

---

## 3. Épica 1: Configuración del Sistema

### HU-01 – Inicializar el proyecto
**Como** desarrollador  
**Quiero** configurar Laravel y Vue  
**Para** contar con una base estable del sistema

**Criterios de aceptación**
- Backend en Laravel funcional
- Frontend en Vue operativo
- Comunicación API correcta
- Repositorio versionado

---

### HU-02 – Autenticación del moderador
**Como** moderador  
**Quiero** iniciar sesión en el sistema  
**Para** acceder al panel de control

**Criterios de aceptación**
- Inicio de sesión seguro
- Acceso restringido al moderador
- Sesión persistente

---

## 4. Épica 2: Gestión de Contenido

### HU-03 – Crear categorías
**Como** moderador  
**Quiero** crear categorías  
**Para** organizar las preguntas del juego

**Criterios de aceptación**
- Crear, editar y eliminar categorías
- Categorías visibles en el tablero

---

### HU-04 – Crear preguntas
**Como** moderador  
**Quiero** registrar preguntas por categoría  
**Para** utilizarlas durante el juego

**Criterios de aceptación**
- Pregunta con texto
- Respuesta correcta asociada
- Puntaje asignado
- Tiempo máximo configurable
- Asociación a una categoría

---

### HU-05 – Editar y eliminar preguntas
**Como** moderador  
**Quiero** modificar preguntas existentes  
**Para** corregir o actualizar contenido

**Criterios de aceptación**
- Edición de cualquier campo
- Eliminación de preguntas no usadas

---

## 5. Épica 3: Gestión de Partidas

### HU-06 – Crear partida
**Como** moderador  
**Quiero** crear una nueva partida  
**Para** iniciar un juego

**Criterios de aceptación**
- Partida creada en estado “preparación”
- Configuración previa sin iniciar el juego

---

### HU-07 – Registrar equipos
**Como** moderador  
**Quiero** registrar equipos  
**Para** organizar la participación de los estudiantes

**Criterios de aceptación**
- Nombre del equipo
- Color identificador
- Puntaje inicial en cero

---

### HU-08 – Iniciar partida
**Como** moderador  
**Quiero** iniciar la partida  
**Para** comenzar el juego

**Criterios de aceptación**
- Visualización del tablero
- Asignación del primer turno

---

## 6. Épica 4: Tablero Tipo Jeopardy

### HU-09 – Visualizar tablero
**Como** moderador  
**Quiero** ver el tablero con categorías y puntajes  
**Para** seleccionar preguntas

**Criterios de aceptación**
- Tablero dinámico
- Diferenciación entre preguntas disponibles y usadas

---

### HU-10 – Seleccionar pregunta
**Como** moderador  
**Quiero** seleccionar una pregunta  
**Para** mostrarla al equipo en turno

**Criterios de aceptación**
- Pregunta visible en pantalla
- Activación automática del temporizador

---

### HU-11 – Bloquear pregunta usada
**Como** sistema  
**Quiero** bloquear preguntas respondidas  
**Para** evitar su reutilización

**Criterios de aceptación**
- Estado “usada”
- No seleccionable nuevamente

---

## 7. Épica 5: Lógica del Juego

### HU-12 – Controlar turnos
**Como** moderador  
**Quiero** controlar el turno de los equipos  
**Para** mantener el orden del juego

**Criterios de aceptación**
- Visualización del equipo en turno
- Cambio manual de turno

---

### HU-13 – Temporizador de pregunta
**Como** moderador  
**Quiero** un temporizador visible  
**Para** limitar el tiempo de respuesta

**Criterios de aceptación**
- Cuenta regresiva visible
- Pausa y extensión manual

---

### HU-14 – Validar respuesta
**Como** moderador  
**Quiero** validar respuestas  
**Para** asignar puntos correctamente

**Criterios de aceptación**
- Opción de respuesta correcta o incorrecta
- Registro de la acción

---

### HU-15 – Asignar puntaje
**Como** sistema  
**Quiero** actualizar el puntaje del equipo  
**Para** reflejar el resultado de la respuesta

**Criterios de aceptación**
- Puntajes actualizados en tiempo real
- Consistencia en los valores

---

## 8. Épica 6: Visualización y Resultados

### HU-16 – Mostrar puntajes
**Como** moderador  
**Quiero** visualizar los puntajes  
**Para** motivar a los equipos

**Criterios de aceptación**
- Puntajes visibles
- Identificación visual por equipo

---

### HU-17 – Finalizar partida
**Como** moderador  
**Quiero** finalizar la partida  
**Para** cerrar el juego correctamente

**Criterios de aceptación**
- Estado de partida “finalizada”
- Visualización del equipo ganador

---

## 9. Épica 7: Calidad y Estabilidad

### HU-18 – Manejo de errores
**Como** moderador  
**Quiero** mensajes claros ante errores  
**Para** no interrumpir la dinámica de clase

**Criterios de aceptación**
- Mensajes comprensibles
- Recuperación del estado del juego

---

### HU-19 – Pruebas en aula
**Como** docente  
**Quiero** probar el sistema en el aula  
**Para** validar su funcionamiento real

**Criterios de aceptación**
- Funciona correctamente en proyector
- Sin fallos críticos durante la sesión

---

## 10. Cierre

Estas historias de usuario constituyen el **backlog inicial del proyecto**, listo para ser estimado, priorizado y asignado a sprints bajo una metodología ágil.

El documento puede usarse tanto para **desarrollo real** como para **proyectos académicos** en asignaturas de ingeniería de software.

---

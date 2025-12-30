# Diseño de Base de Datos  
## Software Educativo Tipo Jeopardy (Juego Presencial por Equipos)

---

## 1. Introducción

Este documento describe el **modelo de base de datos** para el sistema *Software Educativo Tipo Jeopardy*.  
El diseño está orientado a:

- Uso presencial en aula
- Control total por parte del moderador
- Juego por equipos
- Escalabilidad futura

El modelo es compatible con **MySQL o PostgreSQL** y sigue buenas prácticas para su implementación en **Laravel**.

---

## 2. Convenciones

- PK: Clave primaria
- FK: Clave foránea
- Todos los campos `id` son autoincrementales
- Se utilizan marcas de tiempo (`created_at`, `updated_at`)

---

## 3. Tablas Principales

---

## 3.1 users
Almacena los usuarios del sistema (solo moderadores en la versión 1).

| Campo | Tipo | Descripción |
|-----|----|-------------|
| id | bigint (PK) | Identificador del usuario |
| name | varchar(255) | Nombre del moderador |
| email | varchar(255) | Correo electrónico |
| password | varchar(255) | Contraseña encriptada |
| role | varchar(50) | Rol del usuario (moderador) |
| created_at | timestamp | Fecha de creación |
| updated_at | timestamp | Fecha de actualización |

---

## 3.2 categories
Define las categorías del tablero Jeopardy.

| Campo | Tipo | Descripción |
|-----|----|-------------|
| id | bigint (PK) | Identificador de la categoría |
| name | varchar(255) | Nombre de la categoría |
| description | text | Descripción opcional |
| created_at | timestamp | Fecha de creación |
| updated_at | timestamp | Fecha de actualización |

---

## 3.3 questions
Almacena las preguntas del juego.

| Campo | Tipo | Descripción |
|-----|----|-------------|
| id | bigint (PK) | Identificador de la pregunta |
| category_id | bigint (FK) | Categoría asociada |
| question_text | text | Texto de la pregunta |
| correct_answer | text | Respuesta correcta |
| points | int | Puntaje de la pregunta |
| time_limit | int | Tiempo máximo (segundos) |
| is_used | boolean | Indica si ya fue utilizada |
| created_at | timestamp | Fecha de creación |
| updated_at | timestamp | Fecha de actualización |

---

## 3.4 games
Representa una partida de Jeopardy.

| Campo | Tipo | Descripción |
|-----|----|-------------|
| id | bigint (PK) | Identificador de la partida |
| user_id | bigint (FK) | Moderador creador |
| status | varchar(50) | Estado (preparación, en_curso, finalizada) |
| current_turn_team_id | bigint (FK) | Equipo en turno |
| started_at | timestamp | Inicio de la partida |
| ended_at | timestamp | Fin de la partida |
| created_at | timestamp | Fecha de creación |
| updated_at | timestamp | Fecha de actualización |

---

## 3.5 teams
Define los equipos participantes en una partida.

| Campo | Tipo | Descripción |
|-----|----|-------------|
| id | bigint (PK) | Identificador del equipo |
| game_id | bigint (FK) | Partida asociada |
| name | varchar(255) | Nombre del equipo |
| color | varchar(50) | Color identificador |
| score | int | Puntaje acumulado |
| created_at | timestamp | Fecha de creación |
| updated_at | timestamp | Fecha de actualización |

---

## 3.6 turns
Registra el control de turnos del juego.

| Campo | Tipo | Descripción |
|-----|----|-------------|
| id | bigint (PK) | Identificador del turno |
| game_id | bigint (FK) | Partida asociada |
| team_id | bigint (FK) | Equipo en turno |
| question_id | bigint (FK) | Pregunta seleccionada |
| is_correct | boolean | Resultado de la respuesta |
| points_awarded | int | Puntos asignados |
| created_at | timestamp | Fecha del turno |

---

## 3.7 game_questions
Relaciona preguntas con partidas (control de uso por partida).

| Campo | Tipo | Descripción |
|-----|----|-------------|
| id | bigint (PK) | Identificador |
| game_id | bigint (FK) | Partida |
| question_id | bigint (FK) | Pregunta |
| used | boolean | Indicador de uso |
| created_at | timestamp | Fecha de creación |

---

## 4. Relaciones Entre Tablas

- users **1 ─── N** games
- games **1 ─── N** teams
- categories **1 ─── N** questions
- games **1 ─── N** turns
- teams **1 ─── N** turns
- questions **1 ─── N** turns
- games **N ─── N** questions (game_questions)

---

## 5. Reglas de Integridad

- Un equipo pertenece a una sola partida
- Una pregunta solo puede usarse una vez por partida
- El puntaje del equipo se actualiza desde los turnos
- Solo el moderador puede modificar partidas y resultados

---



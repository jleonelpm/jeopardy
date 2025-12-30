# Migraciones y Factories Procesados

## Estado: ✅ Completado

---

## Migraciones Ejecutadas (10 archivos)

### Tablas Principales

1. **`0001_01_01_000000_create_users_table`** ✅
   - Campo `role` agregado posteriormente
   - Almacena moderadores del sistema

2. **`0001_01_01_000003_create_categories_table`** ✅
   - name (varchar)
   - description (text)

3. **`0001_01_01_000004_create_questions_table`** ✅
   - question_text (text)
   - correct_answer (text)
   - points (int)
   - time_limit (int - segundos)
   - is_used (boolean)
   - FK: category_id

4. **`0001_01_01_000005_create_games_table`** ✅
   - status enum: preparacion, en_curso, finalizada
   - current_turn_team_id (actualizada en migración 9)
   - started_at, ended_at (timestamps)
   - FK: user_id

5. **`0001_01_01_000006_create_teams_table`** ✅
   - name (varchar)
   - color (varchar)
   - score (int - 0 por defecto)
   - FK: game_id

6. **`0001_01_01_000007_create_turns_table`** ✅
   - is_correct (boolean)
   - points_awarded (int)
   - created_at (timestamp)
   - FK: game_id, team_id, question_id

7. **`0001_01_01_000008_create_game_questions_table`** ✅
   - used (boolean)
   - Índice único: (game_id, question_id)
   - FK: game_id, question_id

### Migraciones de Restricciones

8. **`0001_01_01_000009_add_current_turn_team_constraint_to_games_table`** ✅
   - Agrega FK después de que teams existe
   - Previene error de integridad referencial

9. **`0001_01_01_000010_add_role_to_users_table`** ✅
   - Añade columna 'role' a tabla users
   - Valor por defecto: 'moderador'

---

## Factories Creados (7 archivos)

### User Factory
```php
UserFactory::factory()->moderator()->create()
// Genera un usuario con rol 'moderador'
```

### Category Factory
```php
CategoryFactory::factory()->create()
CategoryFactory::factory()->withName('Ciencias')->create()
// Genera categorías con nombre y descripción
```

### Question Factory
```php
QuestionFactory::factory()->easy()->create()      // 100 puntos, 30 segundos
QuestionFactory::factory()->medium()->create()    // 200 puntos, 45 segundos
QuestionFactory::factory()->hard()->create()      // 300 puntos, 60 segundos
QuestionFactory::factory()->challenge()->create() // 400-500 puntos, 90 segundos
QuestionFactory::factory()->used()->create()      // Marca como usada
// Genera preguntas con dificultades variadas
```

### Game Factory
```php
GameFactory::factory()->inPreparation()->create() // Estado: preparacion
GameFactory::factory()->inProgress()->create()    // Estado: en_curso
GameFactory::factory()->finished()->create()      // Estado: finalizada
// Genera partidas en diferentes estados
```

### Team Factory
```php
TeamFactory::factory()->create()
TeamFactory::factory()->withName('Equipo A')->create()
TeamFactory::factory()->withColor('#FF6B6B')->create()
TeamFactory::factory()->withScore(500)->create()
// Genera equipos con nombres, colores y puntajes
```

### Turn Factory
```php
TurnFactory::factory()->correct()->create()           // Respuesta correcta
TurnFactory::factory()->incorrect()->create()         // Respuesta incorrecta
TurnFactory::factory()->withPoints(200)->create()     // Con puntos específicos
// Genera turnos (respuestas) en el juego
```

### GameQuestion Factory
```php
GameQuestionFactory::factory()->create()  // No usada
GameQuestionFactory::factory()->used()->create()  // Marcada como usada
// Controla qué preguntas se usan en cada partida
```

---

## Relaciones Implementadas

```
User (1) ──── (N) Game
Category (1) ──── (N) Question
Game (1) ──── (N) Team
Game (1) ──── (N) Turn
Game (N) ──── (N) Question (via GameQuestion)
Team (1) ──── (N) Turn
Question (1) ──── (N) Turn
```

---

## Prueba de Funcionamiento ✅

Se verificó exitosamente:
- ✅ Todas las migraciones ejecutadas sin errores
- ✅ Todos los factories generan datos correctamente
- ✅ Las relaciones entre modelos funcionan
- ✅ Los métodos específicos de factories (easy, medium, hard, etc.) operan correctamente
- ✅ Los datos se guardan en la BD con integridad referencial

Ejemplo de datos generados:
- Usuario: Paris Mante II (moderador)
- 3 Categorías
- Preguntas: 100pts (fácil), 200pts (media), 300pts (difícil)
- Partida: estado "preparacion"
- 2 Equipos
- Turno registrado con puntos awarded

---

## Próximas Acciones

1. Crear controladores para gestión de categorías, preguntas y partidas
2. Implementar API REST endpoints
3. Crear seeders con datos de ejemplo
4. Desarrollar vistas Vue.js
5. Implementar lógica en tiempo real (WebSockets con Laravel Echo)

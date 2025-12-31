## Title: 
Gestión de Partidas

## User Stories:
HU-06 – Crear partida
HU-07 – Registrar equipos
HU-08 – Iniciar partida

## Descripción:
Implementar la funcionalidad de las user stories relacionadas con la gestión de partidas en el sistema. Esto incluye la creación de partidas, el registro de equipos y la capacidad de iniciar una partida.

## Reglas de Negocio:
- Leer las user stories HU-06, HU-07 y HU-08 para entender los requisitos funcionales en el archivo USER_STORY.md dentro de la carpeta "plan.
- Leer el archivo BASE_DATOS.md dentro de la carpeta "plan" para comprender la estructura de la base de datos.

## Especificaciones Técnicas:
- Se está empleando MySQL como sistema de gestión de bases de datos.
- Utilizar Eloquent ORM para la interacción con la base de datos.
- Seguir las convenciones de codificación de Laravel y las mejores prácticas.

## Notas
- Poblar las tablas relacionadas con partidas y equipos utilizando factories.
- Asegurar que las relaciones entre partidas, equipos y turnos estén correctamente implementadas.
- Validar que las partidas se creen en el estado adecuado y que los equipos tengan los atributos necesarios 
- No generar ninguna documentación adicional más allá de esta implementación.
- No realizar nada relacionado con git.

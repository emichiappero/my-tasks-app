-- ==================================================
--  Script SQL: Cargar datos de prueba
--  Asegurarse de haber creado previamente las tablas:
--    users (id, name, email, password, created_at)
--    tasks (id, title, description, due_date, status, user_id)
-- ==================================================

-- USUARIOS DE PRUEBA
-- Las contraseñas corresponden al hash de "123456" con BCRYPT.

INSERT INTO users (id, name, email, password, created_at)
VALUES
  (1, 'Juan Perez', 'juan@ejemplo.com', '$2y$10$RRlmgpfE3NrlGCcWPEiR8eQDUbkjt1BFQHgFiWh93QfAdwH/2n6gW', NOW()),
  (2, 'Rosa Romero', 'rosa@email.com', '$2y$10$RRlmgpfE3NrlGCcWPEiR8eQDUbkjt1BFQHgFiWh93QfAdwH/2n6gW', NOW());

-- TAREAS DE PRUEBA

INSERT INTO tasks (title, description, due_date, status, user_id)
VALUES
  ('Comprar leche', 'Ir al super a comprar leche', '2025-01-20', 'pendiente', 1),
  ('Estudiar programación en Crack The Code', 'Repasar conceptos de PHP en Crack the Code', '2025-02-10', 'en progreso', 1),
  ('Leer un libro', 'Terminar la lectura pendiente', '2025-03-01', 'completada', 2),
  ('Ir al gimnasio', 'Hacer rutina de ejercicios', '2025-02-15', 'pendiente', 2);

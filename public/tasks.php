<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Gestión de Tareas</title>
  <!-- Bootstrap -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
  />
  <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
/>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#">My Tasks App</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarToggler"
        aria-controls="navbarToggler"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarToggler">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <button
              id="logoutBtn"
              class="btn btn-outline-light"
              type="button"
            >
              Cerrar Sesión
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Content -->
  <main class="container my-4 col-lg-8">
    <h1 class="mb-3 mb-md-0">Mis Tareas</h1>

    <div class="mt-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
      
      <!-- Filtro por estado -->
      <div class="mb-3 mb-md-0">
        <label for="statusFilter" class="form-label fw-bold me-2">Filtrar por Estado:</label>
        <select id="statusFilter" class="form-select d-inline-block w-auto">
          <option value="">Todos</option>
          <option value="pendiente">Pendiente</option>
          <option value="en progreso">En Progreso</option>
          <option value="completada">Completada</option>
        </select>
      </div>
       <!-- Botón para nueva tarea -->
    <div class="">
      <button
        class="btn btn-success"
        type="button"
        data-bs-toggle="modal"
        data-bs-target="#addTaskModal"
      >
        + Nueva Tarea
      </button>
    </div>
    </div>

    <!-- Listado de tareas -->
    <div id="taskList" class="mb-3"></div>
  </main>

  <!-- Modal Crear Tarea -->
  <div
    class="modal fade"
    id="addTaskModal"
    tabindex="-1"
    aria-labelledby="addTaskModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="addTaskForm">
          <div class="modal-header">
            <h5 class="modal-title" id="addTaskModalLabel">Crear Nueva Tarea</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="titleAdd" class="form-label">Título</label>
              <input
                type="text"
                id="titleAdd"
                class="form-control"
                required
              />
            </div>
            <div class="mb-3">
              <label for="descriptionAdd" class="form-label">Descripción</label>
              <textarea id="descriptionAdd" class="form-control" rows="2"></textarea>
            </div>
            <div class="row">
              <div class="mb-3 col-md-5">
                <label for="due_dateAdd" class="form-label">Fecha de Vencimiento</label>
                <input type="date" id="due_dateAdd" class="form-control" required />
              </div>
              <div class="mb-3 col-md-7">
                <label for="statusAdd" class="form-label">Estado</label>
                <select id="statusAdd" class="form-select">
                  <option value="pendiente">Pendiente</option>
                  <option value="en progreso">En Progreso</option>
                  <option value="completada">Completada</option>
                </select>
              </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Cancelar
            </button>
            <button type="submit" class="btn btn-primary">Crear</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Editar Tarea -->
  <div
    class="modal fade"
    id="editTaskModal"
    tabindex="-1"
    aria-labelledby="editTaskModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="editTaskForm">
          <div class="modal-header">
            <h5 class="modal-title" id="editTaskModalLabel">Editar Tarea</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="taskIdEdit" />
            <div class="mb-3">
              <label for="titleEdit" class="form-label">Título</label>
              <input type="text" id="titleEdit" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="descriptionEdit" class="form-label">Descripción</label>
              <textarea id="descriptionEdit" class="form-control" rows="2"></textarea>
            </div>
            <div class="row">
            <div class="mb-3 col-md-5">
              <label for="due_dateEdit" class="form-label">Fecha de Vencimiento</label>
              <input type="date" id="due_dateEdit" class="form-control" required />
            </div>
            <div class="mb-3 col-md-7">
              <label for="statusEdit" class="form-label">Estado</label>
              <select id="statusEdit" class="form-select">
                <option value="pendiente">Pendiente</option>
                <option value="en progreso">En Progreso</option>
                <option value="completada">Completada</option>
              </select>
            </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Cancelar
            </button>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- app.js -->
  <script src="js/app.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      checkAuth();     // Verifica si existe un token
      loadTasks();     // Carga inicial de tareas

      // Formulario de nueva tarea
      document.getElementById('addTaskForm').addEventListener('submit', function(e) {
        e.preventDefault();
        createTask();
      });

      // Formulario de edición de tarea
      document.getElementById('editTaskForm').addEventListener('submit', function(e) {
        e.preventDefault();
        updateTaskModal();
      });

      // Logout
      document.getElementById('logoutBtn').addEventListener('click', logoutUser);

      // Filtro por estado
      document.getElementById('statusFilter').addEventListener('change', filterTasksByStatus);
    });
  </script>
</body>
</html>

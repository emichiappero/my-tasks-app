const API_URL = "http://localhost:8000";

let allTasks = [];

/**************************************
	Funciones Genéricas
***************************************/
function getToken() {
	return localStorage.getItem("token");
}

function setToken(token) {
	localStorage.setItem("token", token);
}

function removeToken() {
	localStorage.removeItem("token");
}

function checkAuth() {
	if (!getToken()) {
		window.location.href = "login.php";
	}
}

function showError(message) {
	alert("Error: " + message);
}

function showSuccess(message) {
	alert(message);
}

function getBadgeClass(status) {
	switch (status) {
		case "pendiente":
			return "bg-secondary";
		case "en progreso":
			return "bg-warning";
		case "completada":
			return "bg-success";
		default:
			return "bg-dark";
	}
}

/**************************************
	User Register
***************************************/
async function registerUser() {
	const name = document.getElementById("name").value.trim();
	const email = document.getElementById("email").value.trim();
	const password = document.getElementById("password").value.trim();

	if (!name || !email || !password) {
		showError("Todos los campos son obligatorios");
		return;
	}

	try {
		const response = await fetch(`${API_URL}/register`, {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({ name, email, password }),
		});

		if (response.ok) {
			const data = await response.json();
			showSuccess(data.message);
			window.location.href = "login.php";
		} else {
			const error = await response.json();
			showError(error.error || "No se pudo registrar");
		}
	} catch (err) {
		console.error(err);
		showError("Error de conexión con el servidor");
	}
}

/**************************************
  User Login
***************************************/
async function loginUser() {
	const email = document.getElementById("email").value.trim();
	const password = document.getElementById("password").value.trim();

	if (!email || !password) {
		showError("Completa todos los campos");
		return;
	}

	try {
		const response = await fetch(`${API_URL}/login`, {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({ email, password }),
		});

		if (response.ok) {
			const data = await response.json();
			showSuccess(data.message);
			setToken(data.token);
			// Redirigir a la vista de tareas
			window.location.href = "tasks.php";
		} else {
			const error = await response.json();
			showError(error.error || "Credenciales inválidas");
		}
	} catch (err) {
		console.error(err);
		showError("Error al conectar con el servidor");
	}
}

/*************************************
	Tareas
**************************************/
async function loadTasks() {
	try {
		const token = getToken();
		const response = await fetch(`${API_URL}/tasks`, {
			method: "GET",
			headers: {
				Authorization: `Bearer ${token}`,
			},
		});

		if (!response.ok) {
			// Si el token es inválido o expirado, forzar logout
			if (response.status === 401) {
				removeToken();
				window.location.href = "login.php";
			}
			const error = await response.json();
			showError(error.error || "No se pudieron obtener las tareas");
			return;
		}

		allTasks = await response.json();
		renderTaskList(allTasks);
	} catch (err) {
		console.error(err);
		showError("Error al cargar las tareas");
	}
}

/*************************************
  Modal Editar
**************************************/
function openEditModal(task) {
	document.getElementById("taskIdEdit").value = task.id;
	document.getElementById("titleEdit").value = task.title;
	document.getElementById("descriptionEdit").value = task.description;
	document.getElementById("due_dateEdit").value = task.due_date;
	document.getElementById("statusEdit").value = task.status;

	let editModal = new bootstrap.Modal(
		document.getElementById("editTaskModal"),
		{}
	);
	editModal.show();
}

/*************************************
  Lista de tareas
*************************************/
function renderTaskList(tasks) {
	const taskList = document.getElementById("taskList");
	if (!tasks.length) {
		taskList.innerHTML = "<p class='lead'>No hay tareas disponibles.</p>";
		return;
	}
	let html = "";
	tasks.forEach((task) => {
		const badgeClass = getBadgeClass(task.status);
		html += `
        <div class="card mb-3">
          <div class="card-body">
            
						
						<div class="d-flex justify-content-between align-items-start">
							
							<span class="badge rounded-pill ${badgeClass} mb-3">${task.status.toUpperCase()}</span>
							<small class="text-muted">
								<strong>Vencimiento</strong>: ${task.due_date}
							</small>
						</div>     
						<h5 class="card-title mb-1">${task.title}</h5>     
            <p>${task.description}</p>
            
            <button
              class="btn btn-outline-dark btn-sm me-2"
              onclick='openEditModal(${JSON.stringify(task)})'
            >
							<i class="fa fa-pencil-alt"></i>
              Editar
            </button>
            <button
              class="btn btn-outline-danger btn-sm"
              onclick="deleteTask(${task.id})"
            >
							<i class="fa fa-trash"></i> 
              Eliminar
            </button>
          </div>
        </div>
      `;
	});
	taskList.innerHTML = html;
}

/*************************************
  Crear Tarea
*************************************/
async function createTask() {
	const token = getToken();
	const title = document.getElementById("titleAdd").value.trim();
	const description = document.getElementById("descriptionAdd").value.trim();
	const due_date = document.getElementById("due_dateAdd").value;
	const status = document.getElementById("statusAdd").value;

	if (!title || !due_date) {
		showError("Completa los campos obligatorios");
		return;
	}

	try {
		const response = await fetch(`${API_URL}/tasks`, {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
				Authorization: `Bearer ${token}`,
			},
			body: JSON.stringify({ title, description, due_date, status }),
		});

		const data = await response.json();
		if (response.ok) {
			showSuccess(data.message);

			let addModal = bootstrap.Modal.getInstance(
				document.getElementById("addTaskModal")
			);
			addModal.hide();

			document.getElementById("addTaskForm").reset();

			loadTasks();
		} else {
			showError(data.error || "No se pudo crear la tarea");
		}
	} catch (err) {
		console.error(err);
		showError("Error de conexión");
	}
}

/*************************************
  Actualizar Tarea 
*************************************/
async function updateTaskModal() {
	const token = getToken();
	const id = parseInt(document.getElementById("taskIdEdit").value, 10);
	const title = document.getElementById("titleEdit").value.trim();
	const description = document.getElementById("descriptionEdit").value.trim();
	const due_date = document.getElementById("due_dateEdit").value;
	const status = document.getElementById("statusEdit").value;

	if (!id || !title || !due_date) {
		showError("Completa los campos obligatorios");
		return;
	}

	try {
		const response = await fetch(`${API_URL}/tasks`, {
			method: "PUT",
			headers: {
				"Content-Type": "application/json",
				Authorization: `Bearer ${token}`,
			},
			body: JSON.stringify({ id, title, description, due_date, status }),
		});

		const data = await response.json();
		if (response.ok) {
			showSuccess(data.message);

			let editModal = bootstrap.Modal.getInstance(
				document.getElementById("editTaskModal")
			);
			editModal.hide();

			loadTasks();
		} else {
			showError(data.error || "No se pudo actualizar la tarea");
		}
	} catch (err) {
		console.error(err);
		showError("Error de conexión");
	}
}

/*************************************
  Filtrar Tareas 
*************************************/
function filterTasksByStatus() {
	const statusFilter = document.getElementById("statusFilter").value;
	console.log(statusFilter);

	if (!statusFilter) {
		renderTaskList(allTasks);
		return;
	}

	const filteredTasks = allTasks.filter((task) => task.status === statusFilter);
	renderTaskList(filteredTasks);
}

/*************************************
  Eliminar Tareas
*************************************/
async function deleteTask(taskId) {
	if (!confirm("¿Estás seguro de eliminar esta tarea?")) {
		return;
	}
	const token = getToken();
	try {
		const response = await fetch(`${API_URL}/tasks`, {
			method: "DELETE",
			headers: {
				"Content-Type": "application/json",
				Authorization: `Bearer ${token}`,
			},
			body: JSON.stringify({ id: taskId }),
		});

		const data = await response.json();
		if (response.ok) {
			showSuccess(data.message);
			loadTasks();
		} else {
			showError(data.error || "No se pudo eliminar la tarea");
		}
	} catch (err) {
		console.error(err);
		showError("Error de conexión");
	}
}

/*************************************
	Cerrar Sesión
*************************************/
function logoutUser() {
	removeToken();
	window.location.href = "login.php";
}

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <title>Registro de Usuario</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/styles.css" />
</head>

<body class="bg-light">

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card p-4">
          <h2 class="mb-3 text-center">Crear Cuenta</h2>
          <form id="registerForm">
            <div class="mb-3">
              <label for="name" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="name" placeholder="Tu nombre" required />
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" id="email" placeholder="ejemplo@correo.com" required />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="password" placeholder="********" required />
            </div>
            <button type="submit" class="btn btn-success w-100">Registrarme</button>
          </form>
          <p class="text-center mt-3">
            ¿Ya tienes cuenta?
            <a href="login.php">Iniciar Sesión</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- app.js -->
  <script src="js/app.js"></script>
  <script>
    // Lógica de registro (ejemplo sencillo)
    document.getElementById('registerForm').addEventListener('submit', function (e) {
      e.preventDefault();
      registerUser();
    });
  </script>
</body>

</html>
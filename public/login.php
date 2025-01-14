<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <title>Iniciar Sesión</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/styles.css" />
</head>

<body class="bg-light">

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card p-4">
          <h2 class="mb-3 text-center">Iniciar Sesión</h2>
          <form id="loginForm">
            <div class="mb-3">
              <label for="email" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" id="email" placeholder="ejemplo@correo.com" required />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="password" placeholder="********" required />
            </div>
            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
          </form>
          <p class="text-center mt-3">
            ¿No tienes cuenta?
            <a href="register.php">Regístrate aquí</a>
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
    // Login
    document.getElementById('loginForm').addEventListener('submit', function (e) {
      e.preventDefault();
      loginUser();
    });
  </script>
</body>

</html>
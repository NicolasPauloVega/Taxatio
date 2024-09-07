<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos de FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Tu CSS personalizado -->
    <link href="./assets/css/styles.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-success" style="padding: 1.2rem;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="./assets/img/logo.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
                <span class="text-white ms-2 fs-4">Taxatio</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./view/home.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./view/evaluate.php">Encuestar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Formulario de Inicio de Sesión -->
    <div class="d-flex justify-content-center align-items-center" style="height: calc(100vh - 100px);">
        <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%; background-color: #ffffff;">
            <div class="card-body">
                <h3 class="card-title text-center mb-4 text-success">Iniciar sesion</h3>
                <form action="" method="POST">
                    <?php include('./controller/validate_user.php'); ?>
                    <div class="mb-3">
                        <label for="user" class="form-label text-dark">Nombre</label>
                        <input type="text" class="form-control border-success text-dark" id="user" name="user" placeholder="Nombre de usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label text-dark">Correo electronico</label>
                        <input type="password" class="form-control border-success text-dark" id="pass" name="pass" placeholder="Contraseña" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input border-success" id="show-pass">
                        <label class="form-check-label text-dark" for="show-pass">Mostrar contraseña</label>
                    </div>
                    <input type="submit" class="btn w-100" name="login" value="Iniciar sesión" style="background-color: #2E7D32; color: #ffffff;">
                </form>
            </div>
            <a href="./view/email.php" class="text-success" style="text-align: center;">¿Olvidate tu contraseña? <br>Cambia tu contraseña aquí</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script para mostrar/ocultar la contraseña -->
    <script src="./assets/js/show-pass.js"></script>
</body>
</html>
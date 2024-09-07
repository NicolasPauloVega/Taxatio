<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contraseña - Taxatio</title>
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
                <img src="../assets/img/logo.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
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

    <!-- Formulario para cambiar contraseña -->
    <div class="d-flex justify-content-center align-items-center" style="height: calc(100vh - 100px);">
        <div class="card p-4 shadow-sm text-center" style="max-width: 600px; width: 100%; background-color: #ffffff;">
            <div class="card-body">
                <form action="" method="POST">
                    <?php include '../controller/email.php' ?>
                    <h3 class="card-title text-success mb-3">Verificacion de identidad</h3>
                    <p class="text-dark">Selecciona el tipo de documento y escribe tu número de identidad</p>
                    
                    <!-- Tipo de documento -->
                    <div class="mb-3">
                        <label for="document" class="form-label text-dark">Tipo de documento</label>
                        <select class="form-select border-success text-dark" id="document" name="document" required>
                            <option value="" disabled selected>Seleccione su tipo de documento</option>
                            <option value="CC">Cédula de ciudadanía</option>
                            <option value="TI">Tarjeta de identidad</option>
                            <option value="CE">Cédula de extranjería</option>
                        </select>
                    </div>
                    
                    <!-- Número de documento -->
                    <div class="mb-3">
                        <label for="num_document" class="form-label text-dark">Número de documento</label>
                        <input type="text" class="form-control border-success text-dark" id="num_document" name="num_document" placeholder="Ingresa tu número de documento" required>
                    </div>
                    
                    <!-- Botón para enviar correo -->
                    <input type="submit" class="btn w-100" name="send" value="Enviar" style="background-color: #2E7D32; color: #ffffff;">
                </form>
            </div>
            <a href="../index.php" class="text-success mt-3">Volver</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    ///////////////////////////////// Manejo de sesiones /////////////////////////////////////////////
    // Manejo de sesiones
    session_start();

    include '../../model/database.php';

    // Verificamos si el usuario está logueado o no
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '' || $_SESSION['usuario'] != 1) {
        header('location: ../../view/home.php');
        exit();
    }

    // Almacenamos la sesion
    $user = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Taxatio</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos de FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-success">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../../assets/img/logo.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
                <span class="text-white ms-2 fs-4">Taxatio</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./home.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./users.php">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./results.php">Resultados</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link text-white" href="./evaluations.php">Encuestas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./user.php"><i class="fas fa-user"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../../controller/logout.php"><i class="fas fa-sign-out-alt"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido del Dashboard -->
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4 text-success" style="text-align: center;">Panel de Administración</h1>
                <p class="text-dark mb-4">
                    Bienvenido al panel de administración de <strong>Taxatio</strong>. Aquí podrás gestionar todos los aspectos importantes de la plataforma. Utiliza el menú de navegación para acceder a las diferentes secciones y realizar las siguientes tareas:
                </p>
                <div class="row">
                    <!-- Sección Usuarios -->
                    <div class="col-md-4 mb-4">
                        <div class="card text-center shadow-sm border-success">
                            <div class="card-body">
                                <h5 class="card-title text-success">Gestión de Usuarios</h5>
                                <p class="card-text">Administra los usuarios registrados en la plataforma. Puedes añadir, editar o eliminar usuarios según sea necesario ya sean aprendices, instructores y aprendices.</p>
                                <a href="./users.php" class="btn btn-success">Administrar Usuarios</a>
                            </div>
                        </div>
                    </div>
                    <!-- Sección Resultados -->
                    <div class="col-md-4 mb-4">
                        <div class="card text-center shadow-sm border-success">
                            <div class="card-body">
                                <h5 class="card-title text-success">Ver Resultados</h5>
                                <p class="card-text">Consulta los resultados de las evaluaciones realizadas por los aprendices. Obtén información detallada sobre el desempeño y feedback.</p>
                                <a href="./results.php" class="btn btn-success">Ver Resultados</a>
                            </div>
                        </div>
                    </div>
                    <!-- Sección Evaluaciones -->
                    <div class="col-md-4 mb-4">
                        <div class="card text-center shadow-sm border-success">
                            <div class="card-body">
                                <h5 class="card-title text-success">Administrar Encuestas</h5>
                                <p class="card-text">Configura las encuestas disponibles en la plataforma. Añade o modifica preguntas y respuestas para asegurar la relevancia y precisión de las evaluaciones.</p>
                                <a href="./evaluations.php" class="btn btn-success">Administrar Encuestas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

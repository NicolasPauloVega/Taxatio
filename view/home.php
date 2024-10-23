<?php
    ///////////////////////////////// Manejo de sesiones /////////////////////////////////////////////
    // Manejo de sesiones
    session_start();

    // Verificamos si el usuario está logueado o no
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '') {
        header('location: ../index.php');
        exit();
    }

    // Almacenamos la sesion
    $user = $_SESSION['usuario'];
    
    // Incluimos la base de datos
    include('../model/database.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Taxatio</title>
    <link rel="icon" href="../assets/img/logo.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos de FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-success" style="padding: 1.2rem;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="./home.php">
                <img src="../assets/img/logo.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
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
                        <a class="nav-link text-white" href="./evaluate.php">Evaluar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./user.php">
                            <i class="fas fa-user"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../controller/logout.php"><i class="fas fa-sign-out-alt"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido de la Página de Inicio -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-4 shadow-sm border-success" style="background-color: #f9f9f9;">
                    <div class="card-body">
                        <h1 class="card-title text-center mb-4 text-success">Bienvenido a Taxatio</h1>
                        <p class="text-dark">
                            <strong>Taxatio</strong> es una plataforma de evaluaciones en línea cuyo objetivo es mejorar la satisfacción del aprendiz en cuanto al trato y manera de enseñar del instructor. Nuestro propósito es conocer la opinión de los aprendices sobre su experiencia educativa para ayudar a los instructores a ofrecer una mejor calidad en su enseñanza.
                        </p>
                        <p class="text-dark">
                            En <strong>Taxatio</strong>, valoramos los comentarios de nuestros apendices y nos esforzamos por crear un entorno de aprendizaje más efectivo y agradable. A través de nuestras evaluaciones, buscamos facilitar una comunicación abierta y constructiva entre aprendices e instructores.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
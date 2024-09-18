<?php
    session_start();

    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '') {
        header('location: ../../index.php');
        exit();
    }

    include '../../model/database.php';

    $user = $_SESSION['usuario'];

    $sql = "SELECT * FROM tipo_pregunta t_i JOIN pregunta p ON t_i.Id_tipo_pregunta = p.Id_tipo_pregunta JOIN encuesta e ON p.Id_encuesta = e.Id_encuesta WHERE e.Estado = 'Activo'";
    $query = mysqli_query($connection, $sql);

    $sql_ficha = "SELECT * FROM ficha_aprendiz WHERE Id_usuario = '$user'";
    $query_ficha = mysqli_query($connection, $sql_ficha);
    $row_ficha = mysqli_fetch_array($query_ficha);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exito - Taxatio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-success" style="padding: 1.2rem;">
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

    <!-- Contenedor centrado -->
    <div class="container d-flex justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card my-5">
                <div class="card-body">

                    <h1 class="mb-4 text-success text-center">Preguntas</h1>

                    <script src="../../assets/js/success.js"></script>
                    
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
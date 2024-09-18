<?php
    ///////////////////////////////// Manejo de sesiones /////////////////////////////////////////////
    // Manejo de sesiones
    session_start();

    include '../../model/database.php';

    // Verificamos si el usuario está logueado o no
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '') {
        header('location: ../../view/home.php');
        exit();
    }

    // Almacenamos la sesion
    $user = $_SESSION['usuario'];

    $isAdmin = "SELECT * FROM usuario WHERE Id_usuario = '$user' AND Id_rol = 1";
    $queryIsAdmin = mysqli_query($connection, $isAdmin);

    if($queryIsAdmin){
        header('location: ../home.php');
        exit();
    }

    // Traemos el id del parametro
    $id = $_GET['id'];

    // Definimos la consulta
    $sql = "SELECT * FROM encuesta WHERE Id_encuesta = '$id' "; // Traemos la informacion segun el id
    // Ejecutamos la consulta
    $query = mysqli_query($connection, $sql);
    // Guardamos la informacion
    $row = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar encuesta - Taxatio</title>
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

    <!-- Formulario para Crear Encuesta -->
    <div class="container my-5 d-flex justify-content-center">
        <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
            <h1 class="mb-4 text-success text-center">Editar Encuesta</h1>
            <form action="" method="POST">
                <?php include '../../controller/edit_survey.php'; ?>
                <div class="mb-3" style="display: none;">
                    <label for="" class="form-label text-success">ID</label>
                    <input type="number" class="form-control" name="id" id="id" value="<?= $row['Id_encuesta'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="quarter" class="form-label text-success">Trimestre</label>
                    <input type="text" class="form-control" name="quarter" id="quarter" value="<?= $row['Trimestre'] ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="year" class="form-label text-success">Año</label>
                    <input type="number" class="form-control" name="year" id="year" value="<?= $row['Ano'] ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label text-success">Estado</label>
                    <select class="form-select" name="status" id="status" required>
                        <option value="Activo" <?= $row['Estado'] == 'Activo' ? 'selected' : '' ?>>Activo</option>
                        <option value="Inactivo" <?= $row['Estado'] == 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                    </select>
                </div>

                <input type="submit" name="update" id="update" class="btn btn-success w-100" value="Guardar">
                <div class="text-center mt-3">
                    <a href="./evaluations.php" class="text-success" style="text-decoration: none;">Volver</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
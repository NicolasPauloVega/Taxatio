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

    $id = $_GET['id'];

    $sql = "SELECT * FROM usuario WHERE Id_usuario = $id ";
    $query = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Taxatio</title>
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
                        <a class="nav-link text-white" href="./evaluations.php">Evaluaciones</a>
                    </li>
                    <li class="nav-item nav-link text-white">
                        <i class="fa-solid fa-user-tie"></i>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../../controller/logout.php"><i class="fas fa-sign-out-alt"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav><br><br>

    <!-- Contenido de Gestión de Usuarios -->
    <div class="d-flex justify-content-center align-items-center vh-95 text-center">
        <div class="card p-4 shadow-sm" style="max-width: 500px; width: 100%; background-color: #ffffff;">
            <div class="card-body">
                <h3 class="card-title text-center mb-4 text-success">Asignar ficha al Instructor</h3>
                <form action="" method="POST">
                    <?php include '../../controller/asig_ficha_i.php'; ?>
                    <div class="mb-3" style="display: none;">
                        <input type="number" class="form-control text-success border-success" name="user" id="user" value="<?php echo $row['Id_usuario'] ?>">
                    </div>

                    <div class="mb-3">
                        <label for="number" class="form-label">Numero de ficha</label>
                        <input type="text" class="form-control text-success border-success" name="number" id="number" placeholder="Ingresa el numero de ficha del programa">
                    </div>

                    <div class="mb-3">
                        <label for="competence" class="form-label">Competencia</label>
                        <select name="option" id="option" class="form-control text-dark border-success">
                            <option value="" disabled selected>Selecciona el tipo de competencia del instructor</option>
                            <option value="Transversal">Transversal</option>
                            <option value="Tecnica">Técnica</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre de competencia</label>
                        <input type="text" class="form-control text-dark border-success" name="name" id="name" placeholder="Ingresa el nombre del instructor">
                    </div>

                    <div class="mb-3">
                        <input type="submit" value="Asignar" name="assign" id="assign" class="btn btn-success form-control">
                    </div>
                    <a href="./instructor.php?id=3" class="text-success">Volver</a>
                </form>
            </div>
        </div>
    </div><br><br>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
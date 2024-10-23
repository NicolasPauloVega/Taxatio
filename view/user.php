<?php
    ///////////////////////////////// Manejo de sesiones /////////////////////////////////////////////
    session_start();

    // Verificamos si el usuario está logueado o no
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '') {
        header('location: ./home.php');
        exit();
    }

    $user = $_SESSION['usuario'];

    include('../model/database.php'); // Incluir la base de datos

    // Realizamos la consulta
    $sql = "SELECT u.Nombre, u.Apellido, r.Tipo, u.Id_usuario, u.Tipo_documento, u.Numero_documento, u.Correo_electronico 
            FROM usuario u 
            JOIN rol r ON u.Id_rol = r.Id_rol 
            WHERE Id_usuario = $user";

    $query = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/logo.png" type="image/png">
    <title>Perfil - Taxatio</title>
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

    <!-- Información del usuario -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-success">
                    <div class="card-header bg-success text-white text-center">
                        <h2>Perfil del aprendiz</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nombre completo</th>
                                    <th>Documento</th>
                                    <th>Correo electrónico</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-middle"><i class="fa-solid fa-user-tie fa-2x text-success"></i></td>
                                    <td class="align-middle"><?php echo $row['Nombre'] . " " . $row['Apellido']; ?></td>
                                    <td class="align-middle"><?php echo $row['Tipo_documento'] . " - " . $row['Numero_documento']; ?></td>
                                    <td class="align-middle"><?php echo $row['Correo_electronico']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-center">Si deseas solicitar una actualización en tu documentación, un cambio de correo u otro dato personal, por favor comunícate al siguiente correo: taxatio.sena@gmail.com.</p>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
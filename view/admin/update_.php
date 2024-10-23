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

    $id = $_GET['id'];

    $sql = "SELECT fa.Id_ficha_aprendiz, fa.Id_usuario, fa.Id_ficha, f.Numero_ficha, fa.Id_usuario FROM ficha_aprendiz fa JOIN ficha f ON fa.Id_ficha = f.Id_ficha WHERE fa.Id_usuario = '$id' ";
    $query = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/img/logo.png" type="image/png">
    <title>Actualizar ficha - Taxatio</title>
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
            <a class="navbar-brand d-flex align-items-center" href="./home.php">
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

    <?php if($row){?>
    <!-- Formulario de Registro -->
    <div class="d-flex justify-content-center align-items-center vh-100" style="padding-top: 60px; padding-bottom: 60px;">
        <div class="card p-4 shadow-sm" style="max-width: 500px; width: 100%; background-color: #ffffff;">
            <div class="card-body">
                <h3 class="card-title text-center mb-4 text-success">Registro</h3>
                <form action="" method="POST">
                    <?php include('../../controller/update_.php'); ?>
                    <div class="mb-3" style="display: none;">
                        <input type="text" value="<?= $row['Id_ficha_aprendiz'] ?>" name="ficha_aprendiz">
                        <input type="text" value="<?= $row['Id_usuario'] ?>" name="user">
                    </div>
                    <div class="mb-3 text-center">
                        <label for="" class="text-success">Numero de ficha</label>
                        <input type="text" name="num" id="num" class="form-control border-success text-dark text-center" value="<?= $row['Numero_ficha']?>">
                    </div>
                    <input type="submit" class="btn w-100" name="update" value="Actualizar" style="background-color: #2E7D32; color: #ffffff;">
                </form>
                <div class="text-center mt-3">
                    <a href="../admin/aprendiz.php?id=2" class="text-success" style="text-decoration: none;">Volver</a>
                </div>
            </div>
        </div>
    </div>

    <?php } else {
    ?>
    <script>
        swal.fire({
            icon: 'error',
            title: 'usuario sin ficha!',
            text: 'El aprendiz se encuentra sin ficha asignada...',
            allowEscapeKey: false,
            allowOutsideClick: false,
        }).then((result) => {
            if(result){
                window.location.href = './aprendiz.php?id=2';
            }
        });
    </script>    
    <?php
    } ?>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
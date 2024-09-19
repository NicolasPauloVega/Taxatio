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

    $sql = "SELECT * FROM usuario WHERE Id_usuario = '$id'";
    $query = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear usuario - Taxatio</title>
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
    </nav><br><br>

    <!-- Formulario de Registro -->
    <div class="d-flex justify-content-center align-items-center vh-100" style="padding-top: 60px; padding-bottom: 60px;">
        <div class="card p-4 shadow-sm" style="max-width: 500px; width: 100%; background-color: #ffffff;">
            <div class="card-body">
                <h3 class="card-title text-center mb-4 text-success">Registro</h3>
                <form action="" method="POST">
                    <?php include('../../controller/update_user.php'); ?>
                    <div style="display:none;">
                        <input name="id" value="<?= $row['Id_usuario']?>">
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label text-dark">Nombre</label>
                        <input type="text" class="form-control border-success text-dark" id="name" name="name" placeholder="Nombre" value="<?= $row['Nombre']?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label text-dark">Apellido</label>
                        <input type="text" class="form-control border-success text-dark" id="last_name" name="last_name" placeholder="Apellido" value="<?= $row['Apellido']?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_cedula" class="form-label text-dark">Tipo de Documento</label>
                        <select class="form-select border-success text-dark" id="type_document" name="type_document" required>
                            <?php if($row['Tipo_documento'] == 'TI'){ ?>
                                <option value="TI">Tarjeta de Identidad</option>
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="PPT">Permiso por Protección Temporal(PPT)</option>
                            <?php }elseif($row['Tipo_documento'] == 'CC'){ ?>
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="TI">Tarjeta de Identidad</option>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="PPT">Permiso por Protección Temporal(PPT)</option>
                            <?php }elseif($row['Tipo_documento'] == 'CE'){ ?>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="TI">Tarjeta de Identidad</option>
                                <option value="PPT">Permiso por Protección Temporal(PPT)</option>
                            <?php }else{ ?>
                                <option value="PPT">Permiso por Protección Temporal(PPT)</option>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="TI">Tarjeta de Identidad</option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="numero_documento" class="form-label text-dark">Número de Documento</label>
                        <input type="text" class="form-control border-success text-dark" id="number_document" name="number_document" placeholder="Número de documento" value="<?= $row['Numero_documento']?>" required>
                    </div>
                    <div class="mb-3" style="display: none;">
                        <label for="rol" class="form-label text-dark">Rol</label>
                        <input type="text" name="rol" id="rol" class="form-control border-success text-dark" value="<?= $row['Id_rol'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label text-dark">Correo electronico</label>
                        <input type="email" name="email" id="email" class="form-control border-success text-dark" placeholder="Ingresa el correo del instructor" value=<?= $row['Correo_electronico']?> required>
                    </div>
                    <input type="submit" class="btn w-100" name="update_user" value="Actualizar" style="background-color: #2E7D32; color: #ffffff;">
                </form>
                <div class="text-center mt-3">
                    <a href="../admin/users.php" class="text-success" style="text-decoration: none;">Volver</a>
                </div>
            </div>
        </div>
    </div><br><br>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    ///////////////////////////////// Manejo de sesiones /////////////////////////////////////////////
    // Iniciamos la sesión
    session_start();

    // Verificamos si el usuario está logueado o no
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '') {
        header('location: ../index.php');
        exit();
    }

    // Almacenamos la sesión
    $user = $_SESSION['usuario'];

    ///////////////////////////////// Manejo de base de datos /////////////////////////////////////////////
    include('../model/database.php');

    // Datos aprendiz
    $sql = "SELECT * FROM usuario u JOIN ficha_aprendiz fa ON u.Id_usuario = fa.Id_usuario JOIN ficha f ON fa.Id_ficha = f.Id_ficha WHERE u.Id_usuario = $user";
    $query = mysqli_query($connection,$sql);
    $row_a = mysqli_fetch_array($query);

    // Consulta para obtener los instructores asociados con el aprendiz conectado
    $sql_ = "SELECT DISTINCT u.Nombre, u.Apellido, fi.Competencia, fi.Id_ficha_instructor, fa.Id_ficha_aprendiz, fi.Nombre as Nombre_instructor FROM rol r JOIN usuario u ON r.Id_rol = u.Id_rol JOIN ficha_instructor fi ON u.Id_usuario = fi.Id_usuario JOIN ficha f ON fi.Id_ficha = f.Id_ficha JOIN ficha_aprendiz fa ON f.Id_ficha = fa.Id_ficha WHERE fa.Id_ficha_aprendiz = {$row_a['Id_ficha_aprendiz']}";
    $query_ = mysqli_query($connection, $sql_);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta - Taxatio</title>
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

    <!-- Instructores -->
    <div class="container my-5">
        <h1 class="mb-4 text-success text-center">Evalúa a tu instructor</h1>

        <!-- Tabla de Instructores -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-success">
                    <tr>
                        <th>Nombre</th>
                        <th>Competencia</th>
                        <th>Nombre de la competencia</th>
                        <th>Evaluar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($query_) > 0) { ?>
                        <?php while ($row = mysqli_fetch_array($query_)) { ?>
                            <tr>
                                <td><?= $row['Nombre'] . " " . $row['Apellido'] ?></td>
                                <td><?= $row['Competencia'] ?></td>
                                <td><?= $row['Nombre_instructor'] ?></td>
                                <?php
                                    // Consulta para verificar si el aprendiz ya evaluó al instructor
                                    $sql_r = "SELECT * FROM respuesta WHERE Id_ficha_aprendiz = '{$row_a['Id_ficha_aprendiz']}' AND Id_ficha_instructor = '{$row['Id_ficha_instructor']}'";
                                    $query_r = mysqli_query($connection, $sql_r);
                                    
                                    // Verificar si ya ha sido evaluado
                                    if(mysqli_num_rows($query_r) > 0) {
                                        ?>
                                        <td><div class="btn btn-info btn-sm"><i class="fa-solid fa-eye-slash"></i></div></td>
                                        <?php
                                    } else {
                                ?>
                                    <td>
                                        <a href="./evaluate_id.php?id=<?= $row['Id_ficha_instructor'];?>" class="btn btn-info btn-sm">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="4">No hay instructores disponibles para evaluar.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
    ?>
    <script>
        history.replaceState(null, null, location.pathname);
    </script>
<?php
?>
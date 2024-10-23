<?php
session_start();

include('../../model/database.php');

if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '' || $_SESSION['usuario'] != 1) {
    header('location: ../../view/home.php');
    exit();
}

$user = $_SESSION['usuario'];

$id = $_GET['id'];

$sql = "SELECT f_i.Competencia, f.Numero_ficha, f.Nombre_ficha, f_i.Id_Ficha_instructor 
        FROM usuario u 
        JOIN ficha_instructor f_i ON u.id_usuario = f_i.Id_usuario 
        JOIN ficha f ON f_i.Id_ficha = f.Id_ficha 
        WHERE u.Id_usuario = $id AND f_i.Vinculado = 'Si'";

$query = mysqli_query($connection, $sql);

if (!$query) {
    die('Error en la consulta: ' . mysqli_error($connection));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/img/logo.png" type="image/png">
    <title>Desvincular ficha - Taxatio</title>
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

    <div class="container mt-5">
        <h2 class="mb-4">Desvincular Fichas</h2>
        <p>En la siguiente tabla, encontrarás todas las fichas asignadas a este instructor. Si deseas desvincularlo de alguna ficha (ya sea porque se terminó el trimestre o porque dejó de ser el gerente de grupo), puedes hacerlo presionando la "x".</p>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Ficha</th>
                        <th>Formación</th>
                        <th>Competencia</th>
                        <th>Desvincular</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($query) == 0){ ?>
                        <tr>
                            <td colspan="4" class="text-center">No se encontraron fichas asignadas</td>
                        </tr>
                    <?php } else { ?>
                        <?php while($row = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td><?= $row['Numero_ficha']; ?></td>
                                <td><?= $row['Nombre_ficha']; ?></td>
                                <td><?= $row['Competencia']; ?></td>
                                <td><a href="../../controller/desvincular_ficha_i.php?id=<?= $row['Id_Ficha_instructor'] ?>&id_instructor=<?= $id ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-xmark"></i></a></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
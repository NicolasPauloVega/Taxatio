<?php
    ///////////////////////////////// Manejo de sesiones /////////////////////////////////////////////
    session_start();

    // Verificamos si el usuario está logueado o no
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '' || $_SESSION['usuario'] != 1) {
        header('location: ../../view/home.php');
        exit();
    }

    // Almacenamos la sesión
    $user = $_SESSION['usuario'];

    include('../../model/database.php'); // Incluir la base de datos

    // Consulta general para aprendices
    $sql = "SELECT f.Numero_ficha, u.Nombre, u.Apellido, u.Tipo_documento, u.Numero_documento, u.Id_usuario, f.Nombre_ficha, r.Tipo 
    FROM rol r 
    JOIN usuario u ON r.Id_rol = u.Id_rol
    JOIN ficha_aprendiz fa ON u.Id_usuario = fa.Id_usuario 
    JOIN ficha f ON fa.Id_ficha = f.Id_ficha  
    WHERE u.Id_rol = 2
    ORDER BY f.Numero_ficha ASC";

    // Consulta general para instructores
    $sql_ = "SELECT f.Numero_ficha, u.Nombre, u.Apellido, u.Tipo_documento, u.Numero_documento, u.Id_usuario, f.Nombre_ficha, r.Tipo 
            FROM rol r 
            JOIN usuario u ON r.Id_rol = u.Id_rol 
            JOIN ficha_instructor fi ON u.Id_usuario = fi.Id_usuario 
            JOIN ficha f ON fi.Id_ficha = f.Id_ficha 
            WHERE u.Id_rol = 3 
            ORDER BY f.Numero_ficha ASC";

    // Filtrado por número de ficha si está presente en la solicitud GET
    if (isset($_GET['ficha']) && !empty($_GET['ficha'])) {
        $ficha = $_GET['ficha'];
        $sql = "SELECT DISTINCT f.Numero_ficha, u.Nombre, u.Apellido, u.Tipo_documento, u.Numero_documento, u.Id_usuario, f.Nombre_ficha, r.Tipo 
        FROM rol r 
        JOIN usuario u ON r.Id_rol = u.Id_rol
        JOIN ficha_aprendiz fa ON u.Id_usuario = fa.Id_usuario 
        JOIN ficha f ON fa.Id_ficha = f.Id_ficha  
        WHERE u.Id_rol = 2 AND f.Numero_ficha LIKE '%$ficha%'
        ORDER BY f.Numero_ficha ASC";

        $sql_ = "SELECT DISTINCT f.Numero_ficha, u.Nombre, u.Apellido, u.Tipo_documento, u.Numero_documento, u.Id_usuario, f.Nombre_ficha, r.Tipo 
        FROM rol r 
        JOIN usuario u ON r.Id_rol = u.Id_rol
        JOIN ficha_instructor fi ON u.Id_usuario = fi.Id_usuario 
        JOIN ficha f ON fi.Id_ficha = f.Id_ficha  
        WHERE u.Id_rol = 3 AND f.Numero_ficha LIKE '%$ficha%'
        ORDER BY f.Numero_ficha ASC";
    }

    // Ejecutar las consultas
    $query = mysqli_query($connection, $sql);
    $query_ = mysqli_query($connection, $sql_);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fichas - Taxatio</title>
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

    <!-- Contenido de Gestión de Usuarios -->
    <div class="container my-5">
        <h1 class="mb-4 text-success text-center">Gestión de Usuarios (Fichas)</h1>

        <div class="mb-3 text-center">
            <a href="./users.php" class="btn btn-success">Todos</a>
            <a href="./aprendiz.php?id=2" class="btn btn-success">Aprendiz</a>
            <a href="./instructor.php?id=3" class="btn btn-success">Instructores</a>
        </div>

        <div class="container my-4">
            <form action="./ficha.php" method="get" class="d-flex flex-column align-items-start">
                <div class="mb-3 w-100">
                    <label for="ficha" class="form-label">Número de ficha</label>
                    <div class="input-group">
                        <input type="text" name="ficha" id="ficha" class="form-control" placeholder="Ingrese número de ficha" value="<?= isset($_GET['ficha']) ? $_GET['ficha'] : '' ?>" required>
                        <button type="submit" class="btn btn-success">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla de Usuarios -->
        <div class="table-responsive mb-4 text-center">
            <table class="table table-bordered table-hover">
                <thead class="table-success">
                    <tr>
                        <th>Numero de ficha</th>
                        <th>Nombre de formacion</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($query) > 0 || mysqli_num_rows($query_) > 0): ?>
                        <?php while($row = mysqli_fetch_array($query)): ?>
                            <tr>
                                <td><?= $row['Numero_ficha'] ?></td>
                                <td><?= $row['Nombre_ficha'] ?></td>
                                <td><?= $row['Nombre'] ?></td>
                                <td><?= $row['Apellido'] ?></td>
                                <td><?= $row['Tipo'] ?></td>
                                <td>
                                    <a href="../../controller/delete_user.php?id=<?= $row['Id_usuario'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                        <?php while($row_ = mysqli_fetch_array($query_)): ?>
                            <tr>
                                <td><?= $row_['Numero_ficha'] ?></td>
                                <td><?= $row_['Nombre_ficha'] ?></td>
                                <td><?= $row_['Nombre'] ?></td>
                                <td><?= $row_['Apellido'] ?></td>
                                <td><?= $row_['Tipo'] ?></td>
                                <td>
                                    <a href="../../controller/delete_user.php?id=<?= $row_['Id_usuario'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Ficha no asignada</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
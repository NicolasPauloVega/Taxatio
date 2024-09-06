<?php
    ///////////////////////////////// Manejo de sesiones /////////////////////////////////////////////
    // Manejo de sesiones
    session_start();

    // Verificamos si el usuario está logueado o no
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '' || $_SESSION['usuario'] != 1) {
        header('location: ../../view/home.php');
        exit();
    }

    // Almacenamos la sesión
    $user = $_SESSION['usuario'];

    include('../../model/database.php'); // Incluir la base de datos

    // Definimos la cantidad de resultados por página
    $results_per_page = 6;

    // Verificamos si existe un parámetro de página en la URL
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    // Verificamos si se está buscando un nombre
    $search_name = isset($_GET['search_name']) ? $_GET['search_name'] : '';

    // Determinar el límite de inicio para la consulta SQL
    $start_from = ($page - 1) * $results_per_page;

    // Consulta para obtener el total de usuarios con rol 3 (instructores) y el filtro por nombre
    $sql_count = "SELECT COUNT(*) AS total FROM usuario u JOIN ficha_instructor fi ON u.Id_usuario = fi.Id_usuario JOIN ficha f ON fi.Id_ficha = f.Id_ficha WHERE u.Nombre LIKE '%$search_name%'";
    $result_count = mysqli_query($connection, $sql_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $total_records = $row_count['total'];

    // Calcular el número total de páginas
    $total_pages = ceil($total_records / $results_per_page);

    // Consulta para obtener los instructores según la paginación y el filtro por nombre
    $sql = "SELECT f.Numero_ficha, f.Nombre_ficha, u.Nombre, u.Apellido, fi.Id_usuario FROM usuario u JOIN ficha_instructor fi ON u.Id_usuario = fi.Id_usuario JOIN ficha f ON fi.Id_ficha = f.Id_ficha WHERE u.Nombre LIKE '%$search_name%' LIMIT $start_from, $results_per_page";
    $query = mysqli_query($connection, $sql);

    $sql_p = "SELECT * FROM pregunta p JOIN respuesta r ON p.Id_pregunta = r.Id_pregunta JOIN ficha_instructor fi ON r.Id_ficha_instructor = fi.Id_ficha_instructor JOIN usuario u ON fi.Id_usuario = u.Id_usuario ";
    $query_p = mysqli_query($connection, $sql_p);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuestas - Taxatio</title>
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

    <!-- Contenido de Encuestas -->
    <div class="container my-5">
        <h1 class="mb-4 text-success text-center">Resultados por instructor</h1>

        <!-- Formulario de Búsqueda -->
        <form class="mb-4" method="GET" action="">
            <div class="input-group">
                <input type="text" class="form-control" name="search_name" placeholder="Buscar por nombre" value="<?= $search_name ?>">
                <button type="submit" class="btn btn-success">Buscar</button>
            </div>
        </form>

        <!-- Lista de Instructores -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-success">
                    <tr>
                        <th>Formación</th>
                        <th>Ficha</th>
                        <th>Nombre Completo</th>
                        <th>Mostrar Satisfacción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_array($query)): ?>
                        <tr>
                            <td><?= $row['Numero_ficha'] ?></td>
                            <td><?= $row['Nombre_ficha'] ?></td>
                            <td><?= $row['Nombre'] . " " . $row['Apellido'] ?></td>
                            <td>
                                <a href="./info.php?id=<?= $row['Id_usuario'] ?>" class="btn btn-info btn-sm"><i class="fa-solid fa-eye"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <!-- Botón de página anterior -->
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= ($page > 1) ? '?page=' . ($page - 1) . '&search_name=' . $search_name : '#' ?>" aria-label="Anterior">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <!-- Números de página con ... -->
                <?php
                $max_links = 6;
                $start = max(1, $page - 2);
                $end = min($total_pages, $start + $max_links - 1);

                if ($start > 1): ?>
                    <li class="page-item"><a class="page-link" href="?page=1&search_name=<?= $search_name ?>">1</a></li>
                    <?php if ($start > 2): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Mostrar las páginas del rango calculado -->
                <?php for ($i = $start; $i <= $end; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&search_name=<?= $search_name ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Añadir ... después de las páginas si es necesario -->
                <?php if ($end < $total_pages): ?>
                    <?php if ($end < $total_pages - 1): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $total_pages ?>&search_name=<?= $search_name ?>"><?= $total_pages ?></a></li>
                <?php endif; ?>

                <!-- Botón de página siguiente -->
                <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= ($page < $total_pages) ? '?page=' . ($page + 1) . '&search_name=' . $search_name : '#' ?>" aria-label="Siguiente">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
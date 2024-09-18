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

    // Definimos la cantidad de resultados por página
    $results_per_page = 50;

    // Verificamos si existe un parámetro de página en la URL
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    // Verificamos si se están buscando la ficha o el documento
    $search_number_ficha = isset($_GET['search_number_ficha']) ? $_GET['search_number_ficha'] : '';
    $search_number_documento = isset($_GET['search_number_documento']) ? $_GET['search_number_documento'] : '';

    // Determinar el límite de inicio para la consulta SQL
    $start_from = ($page - 1) * $results_per_page;

    // Construir la consulta SQL según los filtros
    $sql_count = "SELECT COUNT(*) AS total FROM usuario u JOIN ficha_instructor fi ON u.Id_usuario = fi.Id_usuario JOIN ficha f ON fi.Id_ficha = f.Id_ficha WHERE f.Numero_ficha LIKE '%$search_number_ficha%' AND u.Numero_documento LIKE '%$search_number_documento%'";

    $result_count = mysqli_query($connection, $sql_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $total_records = $row_count['total'];

    // Calcular el número total de páginas
    $total_pages = ceil($total_records / $results_per_page);
    // Consulta para obtener los instructores según la paginación y los filtros
    $sql = "SELECT fi.Nombre AS Competencia, fi.Id_ficha_instructor, f.Numero_ficha, fi.Competencia as Nombre_competencia, fi.Id_usuario, u.Nombre as Nombre, u.Apellido as Apellido, r.Respuesta AS Tipo_Respuesta, COUNT(r.Respuesta) AS Total_Respuestas, u.Tipo_documento, u.Numero_documento, f.Nombre_ficha as Formacion, p.Pregunta FROM respuesta r JOIN ficha_instructor fi ON r.Id_ficha_instructor = fi.Id_ficha_instructor JOIN ficha f ON fi.Id_ficha = f.Id_ficha JOIN pregunta p ON r.Id_pregunta = p.Id_pregunta JOIN tipo_pregunta ti ON p.Id_tipo_pregunta = ti.Id_tipo_pregunta JOIN usuario u ON fi.Id_usuario = u.Id_usuario WHERE ti.Respuestas IN ('Totalmente de acuerdo/De acuerdo/Indeciso/En desacuerdo/Totalmente en desacuerdo', 'Muy frecuentemente/Frecuentemente/Ocasionalmente/Raramente/Nunca', 'Muy importante/Importante/Moderadamente importante/De poca importancia/Sin importancia', 'Casi siempre/Usualmente/Ocasionalmente/Usualmente no/Casi nunca') AND f.Numero_ficha LIKE '%$search_number_ficha%' AND u.Numero_documento LIKE '%$search_number_documento%' GROUP BY fi.Nombre, r.Respuesta, r.Id_pregunta ORDER BY fi.Nombre, r.Id_ficha_instructor, r.Id_pregunta ASC LIMIT $start_from, $results_per_page";

    $query = mysqli_query($connection, $sql);
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
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="search_number_ficha" placeholder="Buscar por número de ficha" value="<?= $search_number_ficha ?>">
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="search_number_documento" placeholder="Buscar por número de documento" value="<?= $search_number_documento ?>">
                </div>
                <div class="col-md-12 mt-2">
                    <button type="submit" class="btn btn-success w-100">Buscar</button>
                </div>
            </div>
        </form>

        <!-- Lista de Instructores -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-success text-center">
                    <tr>
                        <th>Ficha</th>
                        <th>Formación</th>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Competencia</th>
                        <th>Pregunta</th>
                        <th>Respuesta</th>
                        <th>Vista general</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_array($query)) { ?>
                        <tr>
                            <td><?php echo $row['Numero_ficha']?></td>
                            <td><?php echo $row['Formacion']?></td>
                            <td><?php echo $row['Nombre']." ".$row['Apellido']?></td>
                            <td><?php echo $row['Tipo_documento']." - ".$row['Numero_documento']?></td>
                            <td><?php echo $row['Nombre_competencia'] . " (".$row['Competencia'].")"?></td>
                            <td><?php echo $row['Pregunta']?></td>
                            <td><?php echo $row['Tipo_Respuesta'] . ":" . $row['Total_Respuestas'] ?></td>
                            <td><a href="./info.php?id=<?= $row['Id_ficha_instructor'] ?>" class="btn btn-info btn-sm"><i class="fa-solid fa-eye"></i></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= ($page > 1) ? '?page=' . ($page - 1) . '&search_number_ficha=' . $search_number_ficha . '&search_number_documento=' . $search_number_documento : '#' ?>" aria-label="Anterior">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <?php
                $max_links = 6;
                $start = max(1, $page - 2);
                $end = min($total_pages, $start + $max_links - 1);

                if ($start > 1): ?>
                    <li class="page-item"><a class="page-link" href="?page=1&search_number_ficha=<?= $search_number_ficha ?>&search_number_documento=<?= $search_number_documento ?>">1</a></li>
                    <?php if ($start > 2): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php for ($i = $start; $i <= $end; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>&search_number_ficha=<?= $search_number_ficha ?>&search_number_documento=<?= $search_number_documento ?>"><?= $i ?></a></li>
                <?php endfor; ?>

                <?php if ($end < $total_pages): ?>
                    <?php if ($end < $total_pages - 1): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $total_pages ?>&search_number_ficha=<?= $search_number_ficha ?>&search_number_documento=<?= $search_number_documento ?>"><?= $total_pages ?></a></li>
                <?php endif; ?>

                <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= ($page < $total_pages) ? '?page=' . ($page + 1) . '&search_number_ficha=' . $search_number_ficha . '&search_number_documento=' . $search_number_documento : '#' ?>" aria-label="Siguiente">
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
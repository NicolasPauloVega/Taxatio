<?php
    ///////////////////////////////// Manejo de sesiones /////////////////////////////////////////////
    // Manejo de sesiones
    session_start();

    // Verificamos si el usuario está logueado o no
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '' || $_SESSION['usuario'] != 1) {
        header('location: ../../view/home.php');
        exit();
    }

    // Almacenamos la sesion
    $user = $_SESSION['usuario'];

    include('../../model/database.php'); // Incluir la base de datos

    $id = $_GET['id']; // Almacenamos el id

    // Definir cuántos resultados se mostrarán por página
    $resultados_por_pagina = 5;

    // Determinar en qué página está el usuario
    if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
        $pagina_actual = $_GET['pagina'];
    } else {
        $pagina_actual = 1;
    }

    // Determinar el número total de resultados en la tabla
    $sql_count = "SELECT COUNT(*) AS total FROM usuario WHERE Id_rol = $id";
    $resultado_count = mysqli_query($connection, $sql_count);
    $fila_count = mysqli_fetch_assoc($resultado_count);
    $total_resultados = $fila_count['total'];

    // Calcular el número total de páginas
    $total_paginas = ceil($total_resultados / $resultados_por_pagina);

    // Calcular el índice inicial para la consulta de SQL
    $indice_inicial = ($pagina_actual - 1) * $resultados_por_pagina;

    // Consulta SQL para obtener los resultados de la página actual
    $sql = "SELECT * FROM usuario WHERE Id_rol = $id LIMIT $indice_inicial, $resultados_por_pagina";
    $query = mysqli_query($connection, $sql);;
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
    <div class="container my-5 text-center">
        <h1 class="mb-4 text-success">Gestión de Usuarios</h1>

        <div class="mb-6">
            <a href="./users.php" class="btn btn-success">Todos</a>
            <a href="./instructor.php?id=3" class="btn btn-success">Instructor</a>
            <a href="./ficha.php" class="btn btn-success">Ficha</a><br><br>
        </div>

        <!-- Tabla de Usuarios -->
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-hover">
                <thead class="table-success">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Tipo de documento</th>
                        <th>Número de Documento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($query) > 0): ?>
                        <?php while($row = mysqli_fetch_array($query)):?>
                        <tr>
                            <td><?= $row['Nombre'] ?></td>
                            <td><?= $row['Apellido'] ?></td>
                            <td><?= $row['Tipo_documento'] ?></td>
                            <td><?= $row['Numero_documento'] ?></td>
                            <td>
                                <a href="../../controller/delete_user.php?id=<?= $row['Id_usuario'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                <a href="./asig_ficha.php?id=<?= $row['Id_usuario']?>" class="btn btn-success btn-sm">Asignar ficha</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Usuarios no encontrados o no existentes</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="text-center mb-4">
                <!-- Botón para Registrar un nuevo usaurio -->
                <a href="./register.php" class="btn btn-success">Resgistrar Aprendiz</a>
            </div>
        </div>

        <!-- Paginacion -->
        <div class="container mb-4">
            <nav aria-label="Paginación">
                <ul class="pagination justify-content-center">
                    <?php if($pagina_actual > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?id=<?= $id ?>&pagina=1">&laquo; Primera</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="?id=<?= $id ?>&pagina=<?= $pagina_actual - 1 ?>">&lsaquo; Anterior</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    $rango_inicio = max(1, $pagina_actual - 4);
                    $rango_fin = min($total_paginas, $pagina_actual + 5);
                    ?>

                    <?php for($i = $rango_inicio; $i <= $rango_fin; $i++): ?>
                        <li class="page-item <?= ($i == $pagina_actual) ? 'active' : '' ?>">
                            <a class="page-link" href="?id=<?= $id ?>&pagina=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if($pagina_actual < $total_paginas): ?>
                        <li class="page-item">
                            <a class="page-link" href="?id=<?= $id ?>&pagina=<?= $pagina_actual + 1 ?>">Siguiente &rsaquo;</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="?id=<?= $id ?>&pagina=<?= $total_paginas ?>">Última &raquo;</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
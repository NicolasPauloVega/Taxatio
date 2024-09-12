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

    // Definir el número de usuarios por página
    $usuarios_por_pagina = 50;

    // Calcular la página actual
    if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
        $pagina_actual = (int) $_GET['pagina'];
    } else {
        $pagina_actual = 1;
    }

    // Calcular el OFFSET para la consulta SQL
    $offset = ($pagina_actual - 1) * $usuarios_por_pagina;

    // Filtro por número de documento
    $filtro_documento = '';
    if (isset($_GET['documento']) && !empty($_GET['documento'])) {
        $filtro_documento = $_GET['documento'];
    }

    // Consulta SQL con filtro de documento si se ha proporcionado
    $sql = "SELECT * FROM usuario 
            JOIN rol ON usuario.Id_rol = rol.Id_rol 
            WHERE rol.Id_rol != 1";

    if ($filtro_documento != '') {
        $sql .= " AND Numero_documento LIKE '%$filtro_documento%'";
    }

    $sql .= " ORDER BY Id_usuario ASC LIMIT $usuarios_por_pagina OFFSET $offset";

    // Ejecutar la consulta
    $query = mysqli_query($connection, $sql);

    // Contar el número total de registros (sin paginación)
    $total_usuarios_sql = "SELECT COUNT(*) AS total FROM usuario WHERE 1";
    if ($filtro_documento != '') {
        $total_usuarios_sql .= " AND Numero_documento LIKE '%$filtro_documento%'";
    }
    $total_usuarios_result = mysqli_query($connection, $total_usuarios_sql);
    $total_usuarios = mysqli_fetch_assoc($total_usuarios_result)['total'];

    // Calcular el número total de páginas
    $total_paginas = ceil($total_usuarios / $usuarios_por_pagina);

    // Definir el rango de botones que se mostrarán en la paginación
    $max_boton_paginacion = 10; // Número máximo de botones a mostrar
    $rango_inicio = max(1, $pagina_actual - floor($max_boton_paginacion / 2));
    $rango_fin = min($total_paginas, $rango_inicio + $max_boton_paginacion - 1);

    if ($rango_fin - $rango_inicio < $max_boton_paginacion - 1) {
        $rango_inicio = max(1, $rango_fin - $max_boton_paginacion + 1);
    }
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
            <a href="./instructor.php?id=3" class="btn btn-success">Instructores</a>
            <a href="./aprendiz.php?id=2" class="btn btn-success">Aprendices</a>
            <a href="./ficha.php" class="btn btn-success">Ficha</a>
        </div><br>

        <!-- Filtro de Búsqueda por Número de Documento -->
        <form method="GET" action="" class="mb-4">
            <div class="input-group">
                <input type="text" name="documento" class="form-control" placeholder="Buscar por número de documento" value="<?= isset($_GET['documento']) ? $_GET['documento'] : '' ?>">
                <button class="btn btn-success" type="submit">Buscar</button>
            </div>
        </form>

        <!-- Tabla de Usuarios -->
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-hover">
                <thead class="table-success">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Documento</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Recorrer los resultados
                        while($row = mysqli_fetch_array($query)):
                    ?>
                    <tr>
                        <td><?= $row['Nombre'] ?></td>
                        <td><?= $row['Apellido'] ?></td>
                        <td><?= $row['Tipo_documento'] ?> - <?= $row['Numero_documento'] ?></td>
                        <td><?= $row['Tipo'] ?></td>
                        <td>
                            <a href="../../controller/delete_user.php?id=<?= $row['Id_usuario'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Enlaces de paginación -->
        <nav aria-label="Paginación de usuarios">
            <ul class="pagination justify-content-center">
                <?php if($pagina_actual > 1): ?>
                    <li class="page-item"><a class="page-link" href="?pagina=<?= $pagina_actual - 1 ?>">Anterior</a></li>
                <?php endif; ?>

                <?php if($rango_inicio > 1): ?>
                    <li class="page-item"><a class="page-link" href="?pagina=1">1</a></li>
                    <?php if($rango_inicio > 2): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php for($i = $rango_inicio; $i <= $rango_fin; $i++): ?>
                    <li class="page-item <?= ($pagina_actual == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if($rango_fin < $total_paginas): ?>
                    <?php if($rango_fin < $total_paginas - 1): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                    <li class="page-item"><a class="page-link" href="?pagina=<?= $total_paginas ?>"><?= $total_paginas ?></a></li>
                <?php endif; ?>

                <?php if($pagina_actual < $total_paginas): ?>
                    <li class="page-item"><a class="page-link" href="?pagina=<?= $pagina_actual + 1 ?>">Siguiente</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
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

    $id = isset($_GET['id']);

    $sql = "SELECT p.Pregunta, r.Respuesta FROM encuesta e 
    JOIN pregunta p ON e.Id_encuesta = p.Id_encuesta
    JOIN respuesta r ON p.Id_pregunta = r.Id_pregunta 
    JOIN ficha_instructor fi ON r.Id_ficha_instructor = fi.Id_ficha_instructor 
    WHERE fi.Id_ficha_instructor = $id AND e.Estado = 'Activo'";

    $query = mysqli_query($connection, $sql);

    if (!$query) {
        die('Error en la consulta: ' . mysqli_error($connection));
    }

    $conteo_respuestas = [];
    $preguntas = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $respuesta = $row['Respuesta'];
        $pregunta = $row['Pregunta'];

        if (!isset($conteo_respuestas[$pregunta])) {
            $conteo_respuestas[$pregunta] = [];
        }

        if (!isset($conteo_respuestas[$pregunta][$respuesta])) {
            $conteo_respuestas[$pregunta][$respuesta] = 0;
        }
        $conteo_respuestas[$pregunta][$respuesta]++;
    }

    $json_data = [];
    foreach ($conteo_respuestas as $pregunta => $respuestas) {
        $total_respuestas = array_sum($respuestas); // Total de respuestas por pregunta
        $respuestas_porcentajes = [];

        // Calculamos el porcentaje de cada respuesta
        foreach ($respuestas as $respuesta => $cantidad) {
            $porcentaje = ($cantidad / $total_respuestas) * 100;
            $respuestas_porcentajes[$respuesta] = round($porcentaje, 2); // Redondear a 2 decimales
        }

        $json_data[] = [
            'pregunta' => $pregunta,
            'respuestas' => $respuestas_porcentajes
        ];
    }

    $json_data = json_encode($json_data);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados - Taxatio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
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

    <div class="container mt-4 text-center">
        <h1 style="color: rgb(25, 135, 84);">Resultados del instructor</h1>
        <p>Si no se muestran resultados estadisticos no te preocupes esto se debe a que el instructor o la instructora no ha sido encuestada</p>
        <a href="./results.php" class="btn btn-success btn-sm">Volver</a>
        <div id="chart"></div>
    </div>
    <!-- Enviar los datos JSON a JavaScript -->
    <script>
        const jsonData = <?= $json_data ?>;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../assets/js/chart.js"></script>
</body>
</html>

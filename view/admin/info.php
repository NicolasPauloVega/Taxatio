<?php
    session_start();

    // Verificamos si el usuario está logueado o no
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '' || $_SESSION['usuario'] != 1) {
        header('location: ../../view/home.php');
        exit();
    }

    include('../../model/database.php');

    // Sanitizar el id recibido por GET
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id <= 0) {
        header('location: ../../view/home.php');
        exit();
    }

    // Realizamos la consulta
    $sql = "SELECT p.Pregunta, r.Respuesta FROM pregunta p 
    JOIN respuesta r ON p.Id_pregunta = r.Id_pregunta 
    JOIN ficha_instructor fi ON r.Id_ficha_instructor = fi.Id_ficha_instructor 
    WHERE fi.Id_usuario = $id";

    $query = mysqli_query($connection, $sql);

    if (!$query) {
        die('Error en la consulta: ' . mysqli_error($connection));
    }

    $conteo_respuestas = [];
    $preguntas = [];

    // Iteramos sobre el resultado de la consulta
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

    // Convertir los datos a formato JSON para cargarlos en el script
    $json_data = [];
    foreach ($conteo_respuestas as $pregunta => $respuestas) {
        $json_data[] = [
            'pregunta' => $pregunta,
            'respuestas' => $respuestas
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

    <div class="container mt-4">
        <h1 class="text-center" style="color: rgb(25, 135, 84);">Resultados del instructor</h1>
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

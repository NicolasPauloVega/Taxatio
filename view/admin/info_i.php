<?php
    session_start();

    // Verificamos si el usuario está logueado o no
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '' || $_SESSION['usuario'] != 1) {
        header('location: ../../view/home.php');
        exit();
    }

    $user = $_SESSION['usuario'];

    include('../../model/database.php');

    $id = $_GET['id'];
    $id_instructor = $_GET['id_instructor'];

    // realizamos una consulta
    $sql = "SELECT p.Pregunta, r.Respuesta, p.Tipo_pregunta FROM pregunta p JOIN respuesta r ON p.Id_pregunta = r.Id_pregunta JOIN ficha_instructor fi ON r.Id_ficha_instructor = fi.Id_ficha_instructor JOIN usuario u ON fi.Id_usuario = u.Id_usuario WHERE p.Id_pregunta = $id AND fi.Id_usuario = $id_instructor";
    // Ejecutamos la consulta
    $query = mysqli_query($connection, $sql);

    // Contamos las respuesta y las almacenamos en arreglos
    $conteo_respuestas = [];
    $pregunta = "";

    // Iteramos sobre el resultado de la consulta
    while($row = mysqli_fetch_assoc($query)) {
        $respuesta = $row['Respuesta']; // Almacenamos las respuestas
        $pregunta = $row['Pregunta']; // Almacenamos las pregunta

        // Validamos si ya se conto la respuesta
        if (!isset($conteo_respuestas[$respuesta])) {
            $conteo_respuestas[$respuesta] = 0; // Si no se almacenaron se inicializa en 0
        }
        $conteo_respuestas[$respuesta]++; // Incrementamos el conteo de las respuestas
    }

    // Convertir los datos a formato JSON para cargarlos en el script
    $json_labels = json_encode(array_keys($conteo_respuestas)); // Para mostrar las respuestas
    $json_data = json_encode(array_values($conteo_respuestas)); // Para mostrar el conteo
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluaciones - Taxatio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-light">
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
                        <a class="nav-link text-white" href="./evaluations.php">Evaluaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./user.php">
                            <i class="fas fa-user"></i> 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../../controller/logout.php"><i class="fas fa-sign-out-alt"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav><br><br>

    <div class="container">
        <h1 class="mb-4" style="text-align: center;"><?= $pregunta ?></h1>
        <canvas id="chart"></canvas>
    </div>

    <!-- Enviar los datos JSON a JavaScript -->
    <script>
        const labels = <?= $json_labels ?>; // Creamos una variable para las etiquetas basada en las respuestas
        const data = <?= $json_data ?>; // Y creamos otra para cargar los datos en el grafico
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../assets/js/chart.js"></script>
</body>
</html>
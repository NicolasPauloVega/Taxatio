<?php
    ///////////////////////////////// Manejo de sesiones /////////////////////////////////////////////
    // Manejo de sesiones
    session_start();

    include '../../model/database.php';

    // Verificamos si el usuario está logueado o no
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '' || $_SESSION['usuario'] != 1) {
        header('location: ../../view/home.php');
        exit();
    }

    // Almacenamos la sesion
    $user = $_SESSION['usuario'];
    
    // Traemos el id
    $id = $_GET['id'];

    // Definimos una consulta
    $sql = "SELECT * FROM tipo_pregunta ti JOIN pregunta ON ti.Id_tipo_pregunta = pregunta.Id_tipo_pregunta JOIN encuesta ON pregunta.Id_encuesta = encuesta.Id_encuesta WHERE Id_pregunta = '$id'";
    // Ejecutamos la consulta
    $query = mysqli_query($connection, $sql);
    // Guardamos la informacion
    $row = mysqli_fetch_array($query);

    // Consulta para obtener todas las encuestas
    $surveys_sql = "SELECT * FROM encuesta";
    $surveys_query = mysqli_query($connection, $surveys_sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pregunta - Taxatio</title>
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

    <!-- Formulario para Crear Pregunta -->
    <div class="container my-5 d-flex justify-content-center">
        <div class="card shadow-sm p-4" style="max-width: 500px; width: 100%;">
            <h1 class="mb-4 text-success text-center">Editar Pregunta</h1>
            <form action="" method="POST">
                <?php include '../../controller/edit_question.php'; ?>
                <div class="mb-3" style="display: none;">
                    <label for="id" class="form-label text-success">ID</label>
                    <input type="number" name="id" id="id" class="form-control" value="<?= $row['Id_pregunta'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="survey" class="form-label text-success">Encuesta</label>
                    <select class="form-select" id="survey" name="survey" required>
                        <?php
                        while ($survey_row = mysqli_fetch_array($surveys_query)) {
                            $selected = ($survey_row['Id_encuesta'] == $row['Id_encuesta']) ? 'selected' : '';
                            ?>
                            <option value="<?= $survey_row['Id_encuesta'] ?>"><?= $survey_row['Trimestre'] . "° Trimestre - " . $survey_row['Ano'] . " Año." ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="question" class="form-label text-success">Pregunta</label>
                    <input type="text" class="form-control" id="question" name="question" placeholder="Escriba la pregunta aquí" value="<?= $row['Pregunta'] ?>" required>
                </div>

                <div class="mb-3">
                    <label for="response_type" class="form-label text-success">Tipo de Pregunta</label>
                    <select class="form-select" id="response_type" name="response_type" required>
                        <?php
                            if($row['Id_tipo_pregunta'] == 1){
                                ?>
                                <option value="1">Acuerdo</option>
                                <option value="2">Frecuencia</option>
                                <option value="3">Probabilidad</option>
                                <?php
                            } else if($row['Id_tipo_pregunta'] == 2){
                                ?>
                                <option value="2">Frecuencia</option>
                                <option value="1">Acuerdo</option>
                                <option value="3">Probabilidad</option>
                                <?php
                            } else {
                                ?>
                                <option value="3">Probabilidad</option>
                                <option value="1">Acuerdo</option>
                                <option value="2">Frecuencia</option>
                                <?php
                            }
                        ?>
                    </select>
                </div>

                <input type="submit" name="edit" id="edit" class="btn btn-success w-100" value="Editar">
                <div class="text-center mt-3">
                    <a href="./evaluations.php" class="text-success" style="text-decoration: none;">Volver</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
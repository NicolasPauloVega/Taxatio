<?php
    ///////////////////////////////// Manejo de sesiones /////////////////////////////////////////////
    // Manejo de sesiones
    session_start();

    // Verificamos si el usuario está logueado o no
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '') {
        header('location: ../index.php');
        exit();
    }

    // Almacenamos la sesion
    $user = $_SESSION['usuario'];

    ///////////////////////////////// Consulta SQL /////////////////////////////////////////////
    include '../model/database.php';

    # Almacenamos el id
    $id = $_GET['id'];
    $instructor = $_GET['instructor_id'];
    
    # Realizamos una consulta y ejecutamos la misma (Cargar preguntas)
    $sql = "SELECT * FROM pregunta WHERE Id_pregunta = $id ";
    $query = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($query);

    # Realizamos una consulta y ejecutamos la misma (Cargar instructores)
    $sql_u = "SELECT fi.Id_ficha_instructor, fa.Id_ficha_aprendiz FROM usuario u 
    JOIN ficha_aprendiz fa ON u.Id_usuario = fa.Id_usuario 
    JOIN ficha f ON fa.Id_ficha = f.Id_ficha 
    JOIN ficha_instructor fi ON f.Id_ficha = fi.Id_ficha 
    WHERE fa.Id_usuario = $user";
    $query_u = mysqli_query($connection, $sql_u);
    $row_u = mysqli_fetch_array($query_u);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta - Taxatio</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos de FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-success" style="padding: 1.2rem;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../assets/img/logo.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
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
                        <a class="nav-link text-white" href="./evaluate.php">Evaluar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./user.php">
                            <i class="fas fa-user"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../controller/logout.php"><i class="fas fa-sign-out-alt"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav><br>

    <?php
        $check_sql = "SELECT * FROM respuesta WHERE Id_ficha_instructor = $instructor AND Id_ficha_aprendiz = {$row_u['Id_ficha_aprendiz']} AND Id_pregunta = {$row['Id_pregunta']}";
        $check_query = mysqli_query($connection, $check_sql);

        if(mysqli_num_rows($check_query) > 0){
            ?>
            <script>
                swal.fire({
                    icon: 'warning',
                    title: 'Buen intento!',
                    text: 'Usted ya respondio esta pregunta...',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.value) {
                        window.location.href = './evaluate.php';
                    }
                });
            </script>
            <?php
        } else { ?>
        <!-- Formulario de Registro -->
        <div class="d-flex justify-content-center align-items-center vh-50">
            <div class="card p-4 shadow-sm" style="max-width: 500px; width: 100%; background-color: #ffffff;">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4 text-success">Pregunta</h3>
                    
                    <form action="../controller/evaluation.php" method="POST">
                        <div style="display: none;">
                            <input type="text" name="id_aprendiz" id="id_aprendiz" value="<?= $row_u['Id_ficha_aprendiz'] ?>">
                            <input type="text" name="id_instructor" id="id_instructor" value="<?= $instructor ?>">
                        </div>

                        <div class="mb-3">
                            <div style="display: none;">
                                <input type="text" name="id_pregunta" id="id_pregunta" value="<?= $row['Id_pregunta'] ?>">
                            </div>

                            <label for="" class=""><?= $row['Pregunta'] ?></label><br><br>

                            <?php if($row['Tipo_pregunta'] == 'Si/No'){ ?>
                                <div class="mb-3">
                                    <input type="radio" name="test" id="test" value="Si"> Si
                                </div>
                                <div class="mb-3">
                                    <input type="radio" name="test" id="test" value="No"> No
                                </div>
                            <?php } else if($row['Tipo_pregunta'] == 'Excelente/Bueno/Regular/Malo/Pesimo'){ ?>
                                <div class="mb-3">
                                    <input type="radio" name="test" id="test" value="Excelente"> Excelente
                                </div>
                                <div class="mb-3">
                                    <input type="radio" name="test" id="test" value="Bueno"> Bueno
                                </div>
                                <div class="mb-3">
                                    <input type="radio" name="test" id="test" value="Regular"> Regular
                                </div>
                                <div class="mb-3">
                                    <input type="radio" name="test" id="test" value="Malo"> Malo
                                </div>
                                <div class="mb-3">
                                    <input type="radio" name="test" id="test" value="Pesimo"> Pésimo
                                </div>
                            <?php } else {?>
                                <div class="mb-3">
                                    <h1>No se encontraron mas preguntas</h1>
                                </div>
                            <?php } ?>
                        </div>
                            <input type="submit" class="btn w-100" name="send" value="Enviar" style="background-color: #2E7D32; color: #ffffff;">
                    </form>
                </div>
            </div>
        </div><br>
        <?php } 
    ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    session_start();

    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '') {
        header('location: ../index.php');
        exit();
    }

    $user = $_SESSION['usuario'];

    include '../model/database.php';

    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if($id === null) {
        echo "<script src='../assets/js/error-id.js'></script>";
    }

    $sql = "SELECT * FROM tipo_pregunta t_i JOIN pregunta p ON t_i.Id_tipo_pregunta = p.Id_tipo_pregunta JOIN encuesta e ON p.Id_encuesta = e.Id_encuesta WHERE e.Estado = 'Activo'";
    $query = mysqli_query($connection, $sql);

    $sql_ficha = "SELECT * FROM ficha_aprendiz WHERE Id_usuario = '$user'";
    $query_ficha = mysqli_query($connection, $sql_ficha);
    $row_ficha = mysqli_fetch_array($query_ficha);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/logo.png" type="image/png">
    <title>Preguntas - Taxatio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-success" style="padding: 1.2rem;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="./home.php">
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
    </nav>

    <!-- Contenedor centrado -->
<div class="container d-flex justify-content-center">
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="card my-5">
            <div class="card-body">
                <h1 class="mb-4 text-success text-center">Preguntas</h1>
                <?php if (mysqli_num_rows($query) > 0) { ?>
                    <form action="" method="post">
                        <?php include '../controller/evaluation.php'; ?>
                        <?php
                            while ($row = mysqli_fetch_array($query)) {
                                $user_validate = "SELECT * FROM respuesta WHERE Id_ficha_aprendiz = '{$row_ficha['Id_ficha_aprendiz']}' AND Id_ficha_instructor = '$id' AND Estado = 'Activo' AND Id_pregunta = '{$row['Id_pregunta']}'";
                                $user_validate_result = mysqli_query($connection, $user_validate);
                                $user_validate_query = mysqli_fetch_array($user_validate_result);

                                if($user_validate_query){
                                    echo "<script src='../assets/js/warning.js'></script>";
                                }else{ ?>
                                    <div class="mb-3">
                                        <label for="" class="form-label"><?php echo $row['Pregunta']?></label><br>
                                        <input type="hidden" name="id_aprendiz" value="<?php echo $row_ficha['Id_ficha_aprendiz']; ?>" readonly >
                                        <input type="hidden" name="id_instructor" value="<?php echo $id; ?>" readonly >
                                        <input type="hidden" name="id_pregunta[]" value="<?php echo $row['Id_pregunta']; ?>" readonly >

                                        <?php if ($row['Id_tipo_pregunta'] == 1) { ?>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="response[<?php echo $row['Id_pregunta']; ?>]" value="Totalmente de acuerdo" required>
                                                    Totalmente de acuerdo
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="response[<?php echo $row['Id_pregunta']; ?>]" value="De acuerdo" required>
                                                    De acuerdo
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="response[<?php echo $row['Id_pregunta']; ?>]" value="Indeciso" required>
                                                    Indeciso
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="response[<?php echo $row['Id_pregunta']; ?>]" value="En desacuerdo" required>
                                                    En desacuerdo
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="response[<?php echo $row['Id_pregunta']; ?>]" value="Totalmente en desacuerdo" required>
                                                    Totalmente en desacuerdo
                                                </label>
                                            </div>
                                        <?php } elseif ($row['Id_tipo_pregunta'] == 2) { ?>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input"  type="radio" name="response[<?php echo $row['Id_pregunta']; ?>]" value="Muy frecuentemente" required>
                                                    Muy frecuentemente
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input"  type="radio" name="response[<?php echo $row['Id_pregunta']; ?>]" value="Frecuentemente" required>
                                                    Frecuentemente
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input"  type="radio" name="response[<?php echo $row['Id_pregunta']; ?>]" value="Ocasionalmente" required>
                                                    Ocasionalmente
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input"  type="radio" name="response[<?php echo $row['Id_pregunta']; ?>]" value="Raramente" required>
                                                    Raramente
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input"  type="radio" name="response[<?php echo $row['Id_pregunta']; ?>]" value="Nunca" required>
                                                    Nunca
                                                </label>
                                            </div>
                                        <?php } elseif ($row['Id_tipo_pregunta'] == 3) { ?>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input"  type="radio" name="response[<?php echo $row['Id_pregunta']; ?>]" value="Casi siempre" required>
                                                    Casi siempre
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input"  type="radio" name="response[<?php echo $row['Id_pregunta']; ?>]" value="Usualmente" required>
                                                    Usualmente
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input"  type="radio" name="response[<?php echo $row['Id_pregunta']; ?>]" value="Ocasionalmente" required>
                                                    Ocasionalmente
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input"  type="radio" name="response[<?php echo $row['Id_pregunta']; ?>]" value="Usualmente no" required>
                                                    Usualmente no
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input"  type="radio" name="response[<?php echo $row['Id_pregunta']; ?>]" value="Casi nunca" required>
                                                    Casi nunca
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php 
                                }
                            } 
                        ?>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success" name="send">Enviar</button>
                        </div>
                    </form>
                    <?php } else { ?>
                        <div class="alert alert-warning text-center" role="alert">
                            No se encontraron preguntas activas.
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
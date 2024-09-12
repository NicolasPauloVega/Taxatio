<?php
    // Manejo de sesiones
    session_start();

    // Verificamos si el usuario está logueado
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '') {
        header('location: ../index.php');
        exit();
    }

    // Almacenamos la sesión del usuario
    $user = $_SESSION['usuario'];

    // Incluimos la conexión a la base de datos
    include '../model/database.php';

    // Almacenamos el id del instructor desde la URL
    $id = $_GET['id'];
    $aprendiz = $_GET['aprendiz'];

    // Consulta para obtener todas las preguntas
    $sql = "SELECT * FROM pregunta p JOIN encuesta e ON p.Id_encuesta = e.Id_encuesta WHERE e.Estado = 'Activo' ";
    $query = mysqli_query($connection, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas - Taxatio</title>
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
    </nav>

<!-- Instructores -->
<div class="container my-5">
    <h1 class="mb-4 text-success text-center">Preguntas</h1>

    <!-- Tabla de Instructores -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-success text-center">
                <tr>
                    <th>Pregunta</th>
                    <th>Posibles respuestas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if ($query):
                ?>
                    <?php while ($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?= $row['Pregunta'] . " (" . $row['Tipo_pregunta'] . ") " ?></td>
                        <td>
                            <form action="../assets/js/response.js" method="post">
                                <?php
                                    $sql_a = "SELECT p.Id_pregunta, p.Tipo_pregunta, r.Estado FROM pregunta p JOIN respuesta r ON p.Id_pregunta = r.Id_pregunta WHERE r.Id_ficha_aprendiz = $aprendiz AND r.Id_pregunta = " . $row['Id_pregunta'] . " AND r.Id_ficha_instructor = $id;";
                                    $query_a = mysqli_query($connection, $sql_a);
                                    $row_a = mysqli_fetch_assoc($query_a);

                                    if (mysqli_num_rows($query_a) > 0 && $row_a['Estado'] == 'Evaluado') {
                                        echo "<p class='text-muted'>Resuelta</p>";
                                    } else {
                                        if ($row['Tipo_pregunta'] == 'Si/No') {
                                            ?>
                                            <div class="mb-3">
                                                <input type="hidden" name="id" id="id" value="<?= $row['Id_pregunta'] ?>">
                                                <input type="hidden" name="id_i" id="id_i" value="<?= $id ?>">
                                                <input type="hidden" name="id_a" id="id_a" value="<?= $aprendiz ?>">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="respuesta" id="Si" value="Si" required>
                                                    <label class="form-check-label" for="Si">Sí</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="respuesta" id="No" value="No" required>
                                                    <label class="form-check-label" for="No">No</label>
                                                </div>
                                            </div>
                                            <?php
                                        } elseif ($row['Tipo_pregunta'] == 'Excelente/Bueno/Regular/Malo/Pésimo') {
                                            ?>
                                            <div class="mb-3">
                                                <input type="hidden" name="id" id="id" value="<?= $row['Id_pregunta'] ?>">
                                                <input type="hidden" name="id_i" id="id_i" value="<?= $id ?>">
                                                <input type="hidden" name="id_a" id="id_a" value="<?= $aprendiz ?>">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="Excelente" id="Excelente" value="Excelente" required>
                                                    <label class="form-check-label" for="Excelente">Excelente</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="Buena" id="Buena" value="Buena" required>
                                                    <label class="form-check-label" for="Buena">Buena</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="Regular" id="Regular" value="Regular" required>
                                                    <label class="form-check-label" for="Regular">Regular</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="Regular" id="Mala" value="Mala" required>
                                                    <label class="form-check-label" for="Mala">Mala</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="Regular" id="Pesima" value="Pesima" required>
                                                    <label class="form-check-label" for="Pesima">Pésima</label>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                ?>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-check"></i> Enviar
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">No hay preguntas disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
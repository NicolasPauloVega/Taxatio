<?php
$token = $_GET['token'];
$token_hash = hash("sha256", $token);

// Conexión a la base de datos
// $mysqli = mysqli_connect('localhost', 'root', '', 'taxatio');
$mysqli = mysqli_connect('localhost', 'u813237171_admin', 'Taxatio2024**', 'u813237171_taxatio');

$sql = "SELECT * FROM usuario WHERE reset_token_hash = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    header('location: ../../index.php');
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'El link no es válido!',
            allowEscapeKey: false,
            allowOutsideClick: false,
        }).then((result) => {
            if (result.value) {
                window.location.href = '../../index.php';
            }
        });
    </script>
    <?php
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    header('location: ../../index.php');
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'El link ya no es válido!',
            allowEscapeKey: false,
            allowOutsideClick: false,
        }).then((result) => {
            if (result.value) {
                window.location.href = '../../index.php';
            }
        });
    </script>
    <?php
}
?>
<script>
    console.log("Link válido");
</script>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/img/logo.png" type="image/png">
    <title>Cambiar contraseña - Taxatio</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos de FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-success py-3">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="../../view/home.php">
                <img src="../../assets/img/logo.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
                <span class="text-white ms-2 fs-4">Taxatio</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../../view/home.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../../view/evaluate.php">Encuestar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Formulario para cambiar contraseña -->
    <div class="d-flex justify-content-center align-items-center" style="height: calc(100vh - 100px);">
        <div class="card p-4 shadow-sm" style="max-width: 500px; width: 100%;">
            <div class="card-body">
                <form action="" method="POST">
                    <?php include '../../controller/password.php'; ?>
                    <h3 class="card-title text-center text-success mb-4">Cambia contraseña</h3>

                    <div>
                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    </div>

                    <div class="mb-3">
                        <label for="pass1" class="form-label">Nueva contraseña</label>
                        <input type="password" class="form-control border-success" id="pass1" name="pass1" placeholder="Ingresa la nueva contraseña" minlength="8" required>
                    </div>

                    <div class="mb-3">
                        <label for="pass2" class="form-label">Confirmar contraseña</label>
                        <input type="password" class="form-control border-success" id="pass2" name="pass2" placeholder="Ingresa nuevamente la nueva contraseña" minlength="8" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="show-password">
                        <label class="form-check-label" for="show-password">Mostrar contraseña</label>
                    </div>

                    <input type="submit" class="btn btn-success w-100" name="send" value="Cambiar Contraseña">
                </form>
            </div>
            <a href="../../index.php" class="text-success mt-3 d-block text-center">Volver</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Show pass -->
    <script src="../../assets/js/show-password.js"></script>
</body>
</html>
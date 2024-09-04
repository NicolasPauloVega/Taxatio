<?php
session_start(); // Manejo de usuario

// Incluimos la base de datos
include('./model/database.php');

// Creamos una condición para el envío de información
if (isset($_POST["login"])) {
    // Validamos la información
    if (is_numeric($_POST["user"]) && isset($_POST["pass"])) {
        // Almacenamos la información
        $user = $_POST["user"];
        $pass = $_POST["pass"];

        // Realizamos una consulta para obtener el usuario
        $sql = "SELECT * FROM usuario WHERE Numero_documento = '$user'";
        
        // Ejecutamos la consulta
        $query = mysqli_query($connection, $sql);

        // Verificamos si se encontró el usuario
        if ($query && mysqli_num_rows($query) > 0) {
            // Almacenamos la información en un array asociativo
            $row = mysqli_fetch_assoc($query);

            // Verificamos si la contraseña es correcta
            if (password_verify($pass, $row['Contrasena'])) {
                $_SESSION['usuario'] = $row['Id_usuario'];

                // Si es un administrador
                if ($row['Id_rol'] == 1) {
                    echo "
                    <script>
                        swal.fire({
                            icon: 'success',
                            title: 'Bienvenido',
                            text: 'Bienvenido a taxatio',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = './view/admin/home.php';
                            }
                        });
                    </script>";
                }
                // Si es un aprendiz
                else if ($row['Id_rol'] == 2) {
                    echo "
                    <script>
                        swal.fire({
                            icon: 'success',
                            title: 'Bienvenido',
                            text: 'Bienvenido a taxatio',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = './view/home.php';
                            }
                        });
                    </script>";
                }
                // Si no exite
                else {
                    echo "
                    <script>
                        swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se inició sesión correctamente!',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = './index.php';
                            }
                        });
                    </script>";
                }
            } else {
                // Contraseña incorrecta
                echo "
                <script>
                    swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Contraseña incorrecta',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = 'index.php';
                        }
                    });
                </script>";
            }
        } else {
            // Usuario no encontrado
            echo "
            <script>
                swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Usuario no encontrado',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.value) {
                        window.location.href = 'index.php';
                    }
                });
            </script>";
        }
    }
    ?>
    <script>
        history.replaceState(null,null,location.pathname);
    </script>
    <?php
}
?>
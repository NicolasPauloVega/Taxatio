<?php
include '../model/database.php';

if(isset($_POST['send'])){
    if(isset($_POST['pass1']) && isset($_POST['pass2']) && isset($_POST['num'])){
        $pass = $_POST['pass1'];
        $pass_confirm = $_POST['pass2'];
        $id = $_POST['num'];

        if($pass == $pass_confirm){
            $password = password_hash($pass, PASSWORD_DEFAULT);

            $sql = "UPDATE usuario SET Contrasena = '$password' WHERE Id_usuario = $id";
            $query = mysqli_query($connection, $sql);

            if($query){
                echo "
                    <script>
                        swal.fire({
                            icon: 'success',
                            title: 'Actualizacion de contraseña exitosa!',
                            text: 'Puedes volver a iniciar sesion',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = '../index.php';
                            }
                        });
                    </script>
                ";
            }
        } else {
            echo "
                <script>
                    swal.fire({
                        icon: 'warning',
                        title: 'Upps!',
                        text: 'Algo fallo asegurate de que las contraseñas sean las mismas',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = './password.php?id={$id}';
                        }
                    });
                </script>
            ";
        }
    }
    ?>
        <script>
            history.replaceState(null,null,location.pathname);
        </script>
    <?php
}
?>
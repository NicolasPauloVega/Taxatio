<?php
    if(isset($_POST['send'])){
        if(isset($_POST['token']) && isset($_POST['pass1']) && isset($_POST['pass2'])){
            $pass = $_POST['pass1'];
            $pass_confirm = $_POST['pass2'];

            $token      = $_POST['token'];
            $token_hash = hash("sha256", $token);

            $mysqli = mysqli_connect('localhost', 'root', '', 'taxatio');

            $sql  = "SELECT * FROM usuario WHERE reset_token_hash = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $token_hash);
            $stmt->execute();

            $result = $stmt->get_result();
            $user   = $result->fetch_assoc();

            if($user === null){
                ?>
                <script>
                    swal.fire({
                        icon: 'error',
                        title: 'El link no es valido!',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = '../email.php';
                        }
                    });
                </script>
                <?php
            }

            if(strtotime($user["reset_token_expires_at"]) <= time()){
                ?>
                <script>
                    swal.fire({
                        icon: 'error',
                        title: 'El link ya no es valido!',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = '../email.php';
                        }
                    });
                </script>
                <?php
            }

            ?>
            <script>
                console.log("Link valido")
            </script>
            <?php

            if($pass == $pass_confirm){
                $password = password_hash($pass, PASSWORD_DEFAULT);

                $sql = "UPDATE usuario SET Contrasena = '$password' WHERE reset_token_hash = '$token_hash'";
                $query = mysqli_query($mysqli, $sql);

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
                                    window.location.href = '../../index.php';
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
    } else {
        header('location: ../../index.php');
        exit();
    }
?>
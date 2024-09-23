<?php

if(isset($_POST['send'])){
    if(isset($_POST['email'])){
        $email = $_POST['email'];

        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256", $token);
        
        $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

        $mysqli = mysqli_connect('localhost', 'root', '', 'taxatio');
        $sql = "UPDATE usuario SET reset_token_hash = ?, reset_token_expires_at = ? WHERE Correo_electronico = '{$email}'";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $token_hash, $expiry);  // Solo dos parámetros aquí
        $stmt->execute();

        if($mysqli->affected_rows){
            
            $mail = require '../controller/mailer.php';
            $mail->setFrom("noreplay@example.com");
            $mail->addAddress($email);
            $mail->Subject = "Solicitud de cambio de contraseña";
            $mail->Body   = <<<END

            Hola aprendiz,<br><br>

            Hemos recibido una solicitud para restablecer tu contraseña. Si no fuiste tú quien hizo esta solicitud, puedes ignorar este mensaje.<br><br>

            Para cambiar tu contraseña, simplemente haz clic en el siguiente enlace:<br><br>

            <a href="http://localhost/taxatio/view/admin/reset-password.php?token=$token">Cambiar contraseña</a><br><br>

            Este enlace será válido por poco tiempo. Si expira, deberás solicitar un nuevo cambio de contraseña.<br><br>

            Si tienes algún problema o preguntas, no dudes en contactarnos.<br><br>

            Gracias por utilizar nuestros servicios.<br><br>

            Saludos,<br>
            El equipo de Taxatio<br>

            END;

            try {
                $mail->send();
            } catch (Exception $e) {
                ?>
                <script>
                    swal.fire({
                        icon: 'error',
                        title: 'Algo salio mal!',
                        text: 'Parece que hubo un error desconocido porfavor vuelve a intentarlo más tarde',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = '../index.php';
                        }
                    });
                </script>
                <?php
            }
            ?>
            <script>
            swal.fire({
                icon: 'success',
                title: 'Mensaje enviado!',
                text: 'Te acabamos de enviar un mensaje de restablecimiento de contraseña al correo <?php echo $email; ?>',
                allowEscapeKey: false,
                allowOutsideClick: false,
            }).then((result) => {
                if (result.value) {
                    window.location.href = '../index.php';
                }
            });
            </script>
            <?php
        } else {
            ?>
            <script>
                swal.fire({
                    icon: 'error',
                    title: 'El correo no existe!',
                    text: 'El correo no existe o lo ingresaste mal porfavor usa el correo que esta guardado en la base de datos del sena @gmail o @soy.sena.edu.co',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.value) {
                        window.location.href = '../index.php';
                    }
                });
            </script>
            <?php
        }
    }
    ?>
    <script>
        history.replaceState(null,null,location.pathname);
    </script>
    <?php
}
?>
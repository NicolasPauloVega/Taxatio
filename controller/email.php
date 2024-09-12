<?php

if(isset($_POST['send'])){
    if(isset($_POST['email'])){
        $email = $_POST['email'];

        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256", $token);
        
        $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

        $mysqli = mysqli_connect('localhost', 'root', '', 'taxatio');
        $sql = "UPDATE usuario SET reset_token_hash = ?, reset_token_expires_at = ? WHERE Correo_electronico = ?";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sss", $token_hash, $expiry, $email);
        $stmt->execute();

        if($mysqli->affected_rows){
            
            $mail = require '../controller/mailer.php';
            $mail->setFrom("noreplay@example.com");
            $mail->addAddress($email);
            $mail->Subject = "Restablecer contraseña";
            $mail->Body   = <<<END

            Click <a href="http://localhost/taxatio/view/admin/reset-password.php?token=$token">here</a> to reset your password.

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
                            window.location.href = './add_ficha.php';
                        }
                    });
                </script>
                <?php
            }

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
                    window.location.href = './add_ficha.php';
                }
            });
        </script>
        <?php
    }
?>
<script>
    history.replaceState(null,null,location.pathname);
</script>
<?php
}

?>
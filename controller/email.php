<?php
    include('../model/database.php');

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    //Load Composer's autoloader
    require '../vendor/autoload.php';

    if(isset($_POST['send'])){
        if(isset($_POST['document']) && isset($_POST['num_document'])){
            
            $document = $_POST['document'];
            $num_document = $_POST['num_document'];

            $sql = "SELECT * FROM usuario WHERE Tipo_documento = '$document' AND Numero_documento = '$num_document'";
            $query = mysqli_query($connection, $sql);
            $row = mysqli_fetch_array($query);

            if(mysqli_num_rows($query) > 0)
            {
                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);
                $url = "http://localhost/taxatio/view/password.php?id={$row['Id_usuario']}";

                try {
                    //Server settings
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'nicolas.paulo.vega06@gmail.com';                     //SMTP username
                    $mail->Password   = 'yzsrczmspfzdbmhz';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
                    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('nicolas.paulo.vega@gmail.com', 'SENA');
                    $mail->addAddress("{$row['Correo_electronico']}", "{$row['Nombre']} - {$row['Apellido']}");     // Destinatario

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Asunto test'; // Asunto
                    $mail->Body    = 'Hola <a href='. $url .'>Cambiar contraseña</a>'; // Contenido

                    $mail->send(); // Se envia
                    echo "
                        <script>
                            swal.fire({
                                icon: 'success',
                                title: 'Mensaje enviado!',
                                text: 'Te hemos enviado un correo en donde podras cambiar tu contraseña',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                            }).then((result) => {
                                if (result.value) {
                                    window.location.href = '../index.php';
                                }
                            });
                        </script>
                    "; // carga un Mensaje
                } catch (Exception $e) {
                    echo "Error al enviar: {$mail->ErrorInfo}"; // Mensaje de error
                }
            } else {
                echo "Usuario no existe";
            }
        }
        ?>
        <script>
            history.replaceState(null,null,location.pathname);
        </script>
        <?php
    }
?>

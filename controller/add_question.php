<?php
    // Incluimos el archivo de conexión a la base de datos
    include '../../model/database.php';

    // Verificamos si se envió el formulario
    if (isset($_POST["save"])) {
        // Verificamos si se enviaron todos los campos
        if (empty($_POST["survey"]) || empty($_POST["question"]) || empty($_POST["type_question"])) {
            echo "
                <script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                    });
                    Toast.fire({
                        icon: 'error',
                        title: 'Hay espacios vacios!'
                    });
                </script>
            ";
        } else {
            // Almacenamos la información
            $survey = $_POST["survey"];
            $question = $_POST["question"];
            $type_question = $_POST["type_question"];

            // Realizamos la consulta
            $sql = "INSERT INTO pregunta (Id_pregunta, Id_encuesta, Id_tipo_pregunta, Pregunta) VALUES ('', '$survey', '$type_question', '$question')";

            // Ejecutamos la consulta
            $query = $connection->query($sql);

            // Verificamos si la consulta es exitosa
            if($query)
            {
                echo "
                    <script>
                        swal.fire({
                            icon: 'success',
                            title: 'Restro exitoso!',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = './evaluations.php';
                            }
                        });
                    </script>
                ";
            }
            else
            {
                echo "
                    <script>
                        swal.fire({
                            icon: 'error',
                            title: 'Error en el registro!',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = './evaluations.php';
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
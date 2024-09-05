<?php
    // Incluir la base de datos
    include('../model/database.php');

    // Validamos si ya se envió la información
    if(isset($_POST["id_instructor"]) && isset($_POST["id_aprendiz"]) && isset($_POST["id_pregunta"]) && isset($_POST["test"])) {
        // Almacenamos la información
        $id_respuesta = null;
        $id_instructor = $_POST["id_instructor"];
        $id_aprendiz = $_POST["id_aprendiz"];
        $id_pregunta = $_POST["id_pregunta"];
        $test = $_POST["test"];
        $fecha = date("Y-m-d H:i:s");
        $estado = 'Evaluado';

        // Realizamos la consulta para insertar la respuesta
        $sql = "INSERT INTO respuesta (id_ficha_aprendiz, id_ficha_instructor, id_pregunta, respuesta, fecha_hora, estado) 
        VALUES ($id_aprendiz, $id_instructor, $id_pregunta, '$test', '$fecha', '$estado')";

        // Ejecutamos la consulta
        $query = mysqli_query($connection, $sql);

        // Verificamos si la inserción fue exitosa
        if($query) {
            ?>
            <script>
                swal.fire({
                    icon: 'success',
                    title: 'Gracias por responder!',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.value) {
                        window.location.href = './evaluations.php';
                    }
                });
            </script>
            <?php
        } else {
            ?>
            <script>
                swal.fire({
                    icon: 'error',
                    title: 'Oh no algo salio mal!',
                    text: 'Hubo un error desconocido porfavor intentalo de nuevo',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.value) {
                        window.location.href = './evaluations.php';
                    }
                });
            </script>
            <?php
        }
    }
?>
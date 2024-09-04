<?php
    include('../../model/database.php'); // Incluimos la conexion

    // Comprobamos si se envio la informacion
    if(isset($_POST['edit'])){
        // Validamos is la informacion es correcta
        if(isset($_POST['id']) && isset($_POST['survey']) && isset($_POST['question']) && isset($_POST['response_type'])){
            // Guardamos la informacion
            $id = $_POST['id'];
            $survey = $_POST['survey'];
            $question = $_POST['question'];
            $response_type = $_POST['response_type'];

            // Realiazamos una consulta
            $sql = "UPDATE pregunta SET Id_encuesta = '$survey', Pregunta = '$question', Tipo_pregunta = '$response_type' WHERE Id_pregunta = '$id' ";
            // Ejecutamos la consulta
            $query = mysqli_query($connection, $sql);

            // Validamos is la informacion es correcta
            if($query){
                echo "
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Actualizacion Exitosa!',
                            showCloseButton: true,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Volver'
                        }).then((result) => {
                            if(result.isConfirmed){
                                window.location.href = './evaluations.php';
                            }
                        });
                    </script>
                ";
            }else{
                echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error en la actualización!',
                            showCloseButton: true,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Volver'
                        }).then((result) => {
                            if(result.isConfirmed){
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
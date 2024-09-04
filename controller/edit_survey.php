<?php
    include('../../model/database.php'); // Incluimos la conexion

    // Comprobamos si se envio la informacion
    if(isset($_POST['update'])){
        // Validamos is la informacion es correcta
        if(isset($_POST['id']) && isset($_POST['quarter']) && isset($_POST['year']) && isset($_POST['status'])){
            // Guardamos la informacion
            $id = $_POST['id'];
            $quarter = $_POST['quarter'];
            $year = $_POST['year'];
            $status = $_POST['status'];

            // Realiazamos una consulta
            $sql = "UPDATE encuesta SET Trimestre = '$quarter', Ano = '$year', Estado = '$status' WHERE Id_encuesta = '$id' ";
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
                            title: 'Error en la actualizacion!',
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
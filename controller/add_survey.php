<?php
    // Creamos la conexion a la base de datos
    include '../../model/database.php';

    // Validamos si se envia la informacion
    if(isset($_POST["save"])){
        // Validamos si la informacion se mando correctamente
        if(empty($_POST["quarter"]) or empty($_POST["year"]) or empty($_POST["status"])){
            echo "
                <script>
                    swal.fire({
                        icon: 'error',
                        title: 'Hay espacios!',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = './evaluations.php';
                        }
                    });
                </script>
            ";
        }else{
            // Validamos si la informacion es correcta
            if(isset($_POST["quarter"]) && isset($_POST["year"]) && isset($_POST["status"])){
                // Almacenamos la informacion
                $quarter = $_POST["quarter"];
                $year = $_POST["year"];
                $status = $_POST["status"];

                // Realizamos una consulta
                $sql = "INSERT INTO encuesta(Trimestre,Ano,Estado) VALUES('$quarter','$year','$status')";

                // Ejecutamos la consulta
                $query = $connection->query($sql);

                // Verificamos si la consulta es exitosa
                if($query){
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
                }else{
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
        }
        ?>
            <script>
                history.replaceState(null,null,location.pathname);
            </script>
        <?php
    }
?>
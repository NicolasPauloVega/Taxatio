<?php
    include '../../model/database.php';

    if(isset($_POST['assign'])){
        if(isset($_POST['user']) && is_numeric($_POST['number'])){
            $id_user = $_POST['user'];
            $number_ficha = $_POST['number'];

            // Consultamos si la ficha existe
            $sql = "SELECT * FROM ficha WHERE Numero_ficha = '$number_ficha'";
            $query = mysqli_query($connection, $sql);

            if(mysqli_num_rows($query) > 0) { // Validamos si se encontró alguna ficha
                $row = mysqli_fetch_array($query);

                // Insertamos el registro en ficha_aprendiz
                $sql_add = "INSERT INTO ficha_aprendiz(Id_ficha_aprendiz, Id_usuario, Id_ficha) VALUES('', '$id_user', '{$row['Id_ficha']}')";
                $query_add = mysqli_query($connection, $sql_add);

                if($query_add) {
                    echo "<script>
                        swal.fire({
                            icon: 'success',
                            title: 'Asignación exitosa!',
                            text: 'El usuario fue asignado con éxito a una ficha',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = './users.php';
                            }
                        });
                    </script>";
                } else {
                    echo "<script>
                        swal.fire({
                            icon: 'error',
                            title: 'Hubo un error al asignar!',
                            text: 'El aprendiz no pudo ser asignado a ninguna ficha. Asegúrate de que exista esa ficha.',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = './users.php';
                            }
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    swal.fire({
                        icon: 'error',
                        title: 'Ficha no encontrada!',
                        text: 'La ficha especificada no existe.',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = './users.php';
                        }
                    });
                </script>";
            }
        }
    }
?>
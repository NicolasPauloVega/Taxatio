<?php
include '../../model/database.php';

if (isset($_POST['update'])) {
    if (isset($_POST['ficha_aprendiz']) && isset($_POST['user']) && isset($_POST['num'])) {
        $id = $_POST['ficha_aprendiz'];
        $user = $_POST['user'];
        $num = $_POST['num'];

        $sql = "SELECT * FROM ficha WHERE Numero_ficha = '$num'";
        $query = mysqli_query($connection, $sql);
        $row = mysqli_fetch_array($query);

        if ($row) {
            $update = "UPDATE ficha_aprendiz SET Id_ficha = '{$row['Id_ficha']}' WHERE Id_ficha_aprendiz = '$id'";
                       
            $update_sql = mysqli_query($connection, $update);

            if ($update_sql) {
                ?>
                <script>
                    swal.fire({
                        icon: "success",
                        title: 'Actualizacion Exitosa!',
                        text: 'Se actualizo correctamente al instructor',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if(result){
                            window.location.href = './aprendiz.php?id=2';
                        }
                    });
                </script>
                <?php
            } else {
                ?>
                <script>
                    swal.fire({
                        icon: 'error',
                        title: 'Error en la actualización',
                        text: 'no se pudo actualizar al instructor porfavor intentalo mas tarde...',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if(result){
                            window.location.href = './aprendiz.php?id=2';
                        }
                    })
                </script>
                <?php
            }
        } else {
            ?>
                <script>
                    swal.fire({
                        icon: 'error',
                        title: 'Ficha no encontrada!',
                        text: 'La ficha no se encontro...',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if(result){
                            window.location.href = './aprendiz.php?id=2';
                        }
                    })
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
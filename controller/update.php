<?php
include '../../model/database.php';

if (isset($_POST['update'])) {
    if (isset($_POST['ficha_instructor']) && isset($_POST['user']) && isset($_POST['select']) && isset($_POST['name']) && is_numeric($_POST['num'])) {
        $id = $_POST['ficha_instructor'];
        $user = $_POST['user'];
        $select = $_POST['select'];
        $name = $_POST['name'];
        $num = $_POST['num'];
        $year = date('Y-m-d H:i:s');

        $sql = "SELECT * FROM ficha WHERE Numero_ficha = '$num'";
        $query = mysqli_query($connection, $sql);
        $row = mysqli_fetch_array($query);

        if ($row) {
            $update = "UPDATE ficha_instructor SET Id_ficha = '{$row['Id_ficha']}', Trimestre_ano = '$year', Competencia = '$select', Nombre = '$name' WHERE Id_ficha_instructor = '$id'";
                       
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
                            window.location.href = './instructor.php?id=3';
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
                            window.location.href = './instructor.php?id=3';
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
                        title: 'Sin asignacion',
                        text: 'Instructor no asignado',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if(result){
                            window.location.href = './instructor.php?id=3';
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
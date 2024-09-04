<?php
    include '../../model/database.php';

    if(isset($_POST['send'])){
        if(isset($_POST['name']) && is_numeric($_POST['number'])){
            $name = $_POST['name'];
            $number = $_POST['number'];

            $sql = "INSERT INTO ficha(Id_ficha, Numero_ficha, Nombre_ficha) VALUES('', '$number', '$name')";
            $query = mysqli_query($connection, $sql);

            if($query == 1){
                echo "<script>
                    swal.fire({
                        icon: 'success',
                        title: 'Ficha registrada correctamente!',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = './ficha.php';
                        }
                    });
                </script>";
            } else {
                echo "<script>
                    swal.fire({
                        icon: 'error',
                        title: 'No se registro correctamente la ficha!',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = './add_ficha.php';
                        }
                    });
                </script>";
            }
        }
        ?>
        <script>
            history.replaceState(null,null,location.pathname);
        </script>
    <?php
    }
?>
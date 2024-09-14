<?php

include '../../model/database.php';

if(isset($_POST['update_user'])){
    if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['last_name']) && isset($_POST['type_document']) && isset($_POST['number_document']) && isset($_POST['rol']) && isset($_POST['email'])){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $last_name = $_POST['last_name'];
        $type_document = $_POST['type_document'];
        $number_document = $_POST['number_document'];
        $rol = $_POST['rol'];
        $email = $_POST['email'];

        $sql = "SELECT * FROM usuario WHERE Numero_documento = '$number_document' AND Tipo_documento = '$type_document'";
        $query = mysqli_query($connection, $sql);

        if($query){
            $update_sql = "UPDATE usuario SET Id_rol = '$rol', Nombre = '$name', Apellido = '$last_name', Tipo_documento = '$type_document', Numero_documento = '$number_document', Correo_electronico = '$email' WHERE Id_usuario = '$id'";
            $query_update = mysqli_query($connection, $update_sql);

            if($query){
                ?>
                <script>
                    swal.fire({
                        icon: "success",
                        title: 'Actualizacion Exitosa!',
                        text: 'Se actualizo correctamente al usuario',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if(result){
                            window.location.href = './users.php';
                        }
                    });
                </script>
                <?php
            }else{
                ?>
                <script>
                    swal.fire({
                        icon: "error",
                        title: 'Error en la actualizacion!',
                        text: 'No se pudo actualizar al usaurio de manera exitosa porfavor volver a intentar',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if(result){
                            window.location.href = './users.php';
                        }
                    });
                </script>
                <?php
            }
        }
    }
}

?>
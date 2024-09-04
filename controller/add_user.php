<?php
    include('../../model/database.php'); // Incluimos la base de datos
    
    // Validamos si la informacion se envia
    if(isset($_POST["register"]))
    {
        // Validamos si la informacion que se envia es correcta
        if(isset($_POST["name"]) && isset($_POST["last_name"]) && isset($_POST["type_document"]) && is_numeric($_POST["number_document"]) && isset($_POST["rol"]) && is_numeric($_POST['number']))
        {
            // Almacenamos la informacion
            $id = null;
            $id_rol = $_POST["rol"];
            $name = $_POST["name"];
            $last_name = $_POST["last_name"];
            $type_document = $_POST["type_document"];
            $number_document = $_POST["number_document"];
            $pass = '8kY#7bM$zQw*3pL!nTx4';

            $number = $_POST['number'];

            $sql_n = "SELECT * FROM ficha WHERE Numero_ficha = $number";
            $query_n = mysqli_query($connection, $sql_n);
            $row_n = mysqli_fetch_array($query_n);

            if(mysqli_num_rows($query_n) > 0 ){
                $sql_i = "SELECT * FROM usuario WHERE Tipo_documento = '$type_document' AND Numero_documento = '$number_document'";
                $query_i = mysqli_query($connection, $sql_i);
                $row_i = mysqli_fetch_array($query_i);

                if(mysqli_num_rows($query_i)){
                    // Encriptamos la contraseña
                    $password = password_hash($pass, PASSWORD_DEFAULT);

                    // Añadimos al usuario por consulta
                    $sql = "insert into usuario(Id_usuario, Id_rol, Nombre, Apellido, Tipo_documento, Numero_documento, Contrasena) values('$id', '$id_rol', '$name', '$last_name', '$type_document', '$number_document', '$password')";

                    // Ejecutamos la consulta
                    $query = mysqli_query($connection, $sql);

                    // Validamos si la consulta es correcta
                    if($query == 1)
                    {

                        $sql_f = "SELECT * FROM usuario WHERE Tipo_documento = '$type_document' AND Numero_documento = $number_document";
                        $query_f = mysqli_query($connection, $sql_f);
                        $row = mysqli_fetch_array($query_f);

                        if(mysqli_num_rows($query_f) > 0) {
                            $sql_ = "INSERT INTO ficha_instructor(Id_ficha_instructor, Id_ficha, Id_usuario) VALUES('', '{$row_n['Id_ficha']}', '{$row['Id_usuario']}')";
                            $query_ = mysqli_query($connection, $sql_);

                            if($query_) {
                                echo "<script>
                                    swal.fire({
                                        icon: 'success',
                                        title: 'Usuario registrado correctamente!',
                                        allowEscapeKey: false,
                                        allowOutsideClick: false,
                                    }).then((result) => {
                                        if (result.value) {
                                            window.location.href = '../index.php';
                                        }
                                    });
                                </script>";
                            }
                        }
                    }
                    else
                    {
                        echo "<script>
                            swal.fire({
                                icon: 'error',
                                title: 'El usuario no se registro correctamente!',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                            }).then((result) => {
                                if (result.value) {
                                    window.location.href = './add_user.php';
                                }
                            });
                        </script>";
                    }
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
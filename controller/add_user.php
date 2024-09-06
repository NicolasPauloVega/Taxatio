<?php
    include('../../model/database.php'); // Incluimos la base de datos
    
    // Validamos si la informacion se envia
    if(isset($_POST["register"]))
    {
        // Validamos si la informacion que se envia es correcta
        if(isset($_POST["name"]) && isset($_POST["last_name"]) && isset($_POST["type_document"]) && is_numeric($_POST["number_document"]) && isset($_POST["rol"]) && isset($_POST['email']))
        {
            // Almacenamos la informacion
            $id = null;
            $id_rol = 3;
            $name = $_POST["name"];
            $last_name = $_POST["last_name"];
            $type_document = $_POST["type_document"];
            $number_document = $_POST["number_document"];
            $pass = '8kY#7bM$zQw*3pL!nTx4';
            $email = $_POST['email'];

            $sql_i = "SELECT * FROM usuario WHERE Numero_documento = '$number_document'";
            $query_i = mysqli_query($connection, $sql_i);

            if(mysqli_num_rows($query_i) > 0)
            {
                echo "<script>
                    swal.fire({
                        icon: 'error',
                        title: 'El usuario no se pudo registrar correctamente!',
                        text: 'El numero de documento ya existe!',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.value) {
                             window.location.href = './add_user.php';
                        }
                    });
                </script>";
            } else {
                // Encriptamos la contraseña
                $password = password_hash($pass, PASSWORD_DEFAULT);

                // Añadimos al usuario por consulta
                $sql = "insert into usuario(Id_usuario, Id_rol, Nombre, Apellido, Tipo_documento, Numero_documento, Correo_electronico,Contrasena) values('$id', '$id_rol', '$name', '$last_name', '$type_document', '$number_document', '$email','$password')";

                // Ejecutamos la consulta
                $query = mysqli_query($connection, $sql);

                // Validamos si la consulta es correcta
                if($query)
                {
                    echo "<script>
                        swal.fire({
                            icon: 'success',
                            title: 'Usuario registrado correctamente!',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = './users.php';
                            }
                        });
                    </script>";
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
        ?>
            <script>
                history.replaceState(null,null,location.pathname);
            </script>
        <?php
    }
?>
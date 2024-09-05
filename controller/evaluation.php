<?php
    // Incluir la base de datos
    include('../model/database.php');

    // Validamos si ya se envió la información
    if(isset($_POST["id_instructor"]) && isset($_POST["id_aprendiz"]) && isset($_POST["id_pregunta"]) && isset($_POST["test"])) {
        // Almacenamos la información
        $id_respuesta = null;
        $id_instructor = $_POST["id_instructor"];
        $id_aprendiz = $_POST["id_aprendiz"];
        $id_pregunta = $_POST["id_pregunta"];
        $test = $_POST["test"];
        $fecha = date("Y-m-d H:i:s");
        $estado = 'Evaluado';

        // Consulta para verificar si ya existe una respuesta
        $check_sql = "SELECT * FROM respuesta WHERE Id_ficha_instructor = $id_instructor AND Id_ficha_aprendiz = $id_aprendiz AND Id_pregunta = $id_pregunta";
        $check_query = mysqli_query($connection, $check_sql);

        // Verificar si ya existe una respuesta
        if(mysqli_num_rows($check_query) > 0) {
            header('Location: ../view/evaluate.php');
            exit();
        } else {
            // Realizamos la consulta para insertar la respuesta
            $sql = "INSERT INTO respuesta (id_ficha_aprendiz, id_ficha_instructor, id_pregunta, respuesta, fecha_hora, estado) 
                    VALUES ($id_aprendiz, $id_instructor, $id_pregunta, '$test', '$fecha', '$estado')";

            // Ejecutamos la consulta
            $query = mysqli_query($connection, $sql);

            // Verificamos si la inserción fue exitosa
            if($query) {
                header("Location: ../view/evaluate.php");
            } else {
                echo "<script>console.log('Respuesta incorrecta');</script>";
            }
        }
    }
?>
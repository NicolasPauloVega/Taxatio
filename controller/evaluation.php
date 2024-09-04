<?php
    // Incluir la base de datos
    include('../model/database.php');
        // Validamos si ya se envio la informacion
        if(isset($_POST["id_instructor"]) && isset($_POST["id_aprendiz"]) && isset($_POST["id_pregunta"]) && isset($_POST["test"])):
            // Almacenamos la informacion
            $id_respuesta = null;
            $id_instructor = $_POST["id_instructor"];
            $id_aprendiz = $_POST["id_aprendiz"];
            $id_pregunta = $_POST["id_pregunta"];
            $test = $_POST["test"];
            $fecha = date("Y-m-d H:i:s");
            $estado = 'Evaluado';

            // Realizamos la consulta
            $sql = "INSERT INTO respuesta (id_ficha_aprendiz, id_ficha_instructor, id_pregunta, respuesta, fecha_hora, estado) VALUES ($id_aprendiz, $id_instructor, $id_pregunta, '$test', '$fecha', '$estado')";

            // Ejecutamos la consulta
            $query = mysqli_query($connection, $sql);

            // Verrificamos si estuvo correcta y mandamos un mensaje
            if($query == 1){
                header("location: ../view/evaluate.php");
            }else{
                echo "Incorrecta";
            }

        endif;
?>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    include '../model/database.php';

    // Verificar si los campos existen antes de acceder a ellos
    $id_preguntas = isset($_POST['id_pregunta']) ? $_POST['id_pregunta'] : [];
    $id_aprendiz = isset($_POST['id_aprendiz']) ? $_POST['id_aprendiz'] : null;
    $id_instructor = isset($_POST['id_instructor']) ? $_POST['id_instructor'] : null;
    $respuestas = isset($_POST['response']) ? $_POST['response'] : [];
    $fecha = date('Y-m-d H:i:s');
    $estado = 'evaluado';

    $respuesta_existente = false;
    $exito_insercion = false;

    if (!empty($id_preguntas) && !empty($respuestas)) {
        foreach ($id_preguntas as $id_pregunta) {
            if(isset($respuestas[$id_pregunta])){
                $respuesta = $respuestas[$id_pregunta];

                // Verifica si la respuesta ya existe
                $sql = "SELECT * FROM respuesta WHERE Id_ficha_aprendiz = $id_aprendiz AND Id_ficha_instructor = $id_instructor AND Id_pregunta = $id_pregunta AND Estado = 'Evaluado'";
                $query = mysqli_query($connection, $sql);

                if(mysqli_num_rows($query) > 0){
                    $respuesta_existente = true;
                } else {
                    // Inserta la nueva respuesta
                    $insert = "INSERT INTO respuesta VALUES('', '$id_aprendiz', '$id_instructor', '$id_pregunta', '$respuesta', '$fecha', '$estado')";
                    $query_insert = mysqli_query($connection, $insert);

                    if($query_insert){
                        $exito_insercion = true;
                    }
                }
            }
        }
    }

    if($respuesta_existente){
        header('location: ./form/warning.php');
    } elseif($exito_insercion) {
        echo "<script src='../assets/js/success.js'></script>";
    } else {
        echo "<script src='../assets/js/error.js'></script>";
    }
    ?>
    <script>
        history.replaceState(null,null,location.pathname);
    </script>
    <?php
}
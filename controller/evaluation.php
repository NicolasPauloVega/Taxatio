<?php
include '../model/database.php';

if(isset($_POST['enviar'])){
    if(isset($_POST['acuerdo']) || isset($_POST['frecuencia']) || isset($_POST['probabilidad']) && isset($_POST['id']) && isset($_POST['id_i']) && isset($_POST['id_a'])){
        $id_respuesta = null;
        $acuerdo = $_POST['acuerdo'];
        $frecuencia = $_POST['frecuencia'];
        $probabilidad = $_POST['probabilidad'];
        $id_pregunta = $_POST['id'];
        $id_instructor = $_POST['id_i'];
        $id_aprendiz = $_POST['id_a'];
        $fecha_hora = date('Y-m-d H:i:s');
        $estado = 'Evaluado';

        $sql = "SELECT * FROM respuesta WHERE id_ficha_aprendiz = '$id_aprendiz' AND id_ficha_instructor = '$id_instructor' AND id_pregunta = '$id_pregunta' AND Estado = '$estado'";
        $query = mysqli_query($connection, $sql);

        if($query && mysqli_num_rows($query) > 0){
            echo "No se puede volver a ecaluar al instructor";
        }else{
            $sql_add = "INSERT INTO respuesta VALUES('$id_respuesta', '$id_aprendiz', '$id_instructor', '$id_pregunta', '$acuerdo', '$fecha_hora', '$estado'),('$id_respuesta', '$id_aprendiz', '$id_instructor', '$id_pregunta', '$frecuencia', '$fecha_hora', '$estado'),('$id_respuesta', '$id_aprendiz', '$id_instructor', '$id_pregunta','$probabilidad', '$fecha_hora', '$estado')";
            $query_add = mysqli_query($connection, $sql_add);

            if($query_add){
                echo "<script>
                    window.location.href = './evaluate.php';
                </script>";
            }else{
                echo "<script>console.log('Fallo en el envio: ". mysqli_error($connection) . "')</script>";
            }
        }
    }
}
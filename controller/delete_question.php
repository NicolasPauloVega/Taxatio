<?php
include('../model/database.php'); // Incluimos la base de datos

// Almacenamos el id
$id = $_GET['id'];

// Realizamos una sentencia sql
$sql = "DELETE FROM Pregunta WHERE Id_pregunta = '$id'";

// Ejecutamos la sentencia sql
$query = mysqli_query($connection, $sql);

// Validamos si la consulta fue exitosa
if ($query) {
    header('Location: ../view/admin/evaluations.php');
    exit(); // Asegúrate de detener la ejecución después de la redirección
}
?>

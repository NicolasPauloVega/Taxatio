<?php
// Incluimos la base de datos
include('../model/database.php');

// Almacenamos el id del usuario
$id = $_GET['id'];

// Iniciamos una transacción para asegurar que ambas eliminaciones se completen correctamente
mysqli_begin_transaction($connection);

try {
    // Eliminar registros relacionados en la tabla ficha_aprendiz
    $sql_ficha_aprendiz = "DELETE FROM ficha_aprendiz WHERE Id_usuario = '$id'";
    $query_ficha_aprendiz = mysqli_query($connection, $sql_ficha_aprendiz);
    
    if (!$query_ficha_aprendiz) {
        throw new Exception('Error al eliminar en ficha_aprendiz');
    }

    // Eliminar el usuario en la tabla usuario
    $sql_usuario = "DELETE FROM usuario WHERE Id_usuario = '$id'";
    $query_usuario = mysqli_query($connection, $sql_usuario);
    
    if (!$query_usuario) {
        throw new Exception('Error al eliminar el usuario');
    }

    // Si ambas eliminaciones fueron exitosas, confirmamos la transacción
    mysqli_commit($connection);

    // Redireccionamos
    header('location: ../view/admin/users.php');
    exit(); // Aseguramos detener la ejecución después de la redirección
} catch (Exception $e) {
    // Si hubo un error, revertimos la transacción
    mysqli_rollback($connection);

    // Puedes manejar el error aquí, por ejemplo, mostrando un mensaje o redireccionando a otra página
    echo "Error: " . $e->getMessage();
}
?>
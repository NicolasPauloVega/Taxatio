<?php
$connection = mysqli_connect('localhost', 'root', '', 'taxatio');
// $connection = mysqli_connect('localhost', 'u813237171_admin', 'Taxatio2024**', 'u813237171_taxatio');

if (mysqli_connect_errno()) {
    die('Error de conexión: ' . mysqli_connect_error());
}

$id = $_GET['id'];
$id_i = $_GET['id_instructor'];

$sql = "UPDATE ficha_instructor SET Vinculado = 'No' WHERE Id_ficha_instructor = $id";
$query = mysqli_query($connection, $sql);

if (!$query) {
    echo "Error: " . mysqli_error($connection);
} else {
    header("location: ../view/admin/eliminar_ficha_i.php?id=$id_i");
}
?>
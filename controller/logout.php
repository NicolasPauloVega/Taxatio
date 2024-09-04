<?php
    // Manejo de sesiones
    session_start();

    if(session_destroy())
    {
        header('location: ../index.php');
    }
?>
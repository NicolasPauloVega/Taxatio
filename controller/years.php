<?php
    // Funcion para mostrar años
    function Create_years($starting_year, $end_year)
    {
        // Verificamos si son datos numericos
        if(!is_numeric($starting_year) || !is_numeric($end_year))
        {
            echo "Los parametros no son correctos";
        }
        else
        {
            // Validamos si el inicio es mayor que el fin
            if($starting_year > $end_year)
            {
                // Hacemos que todos los valores sean iguales
                $aux = $starting_year;
                $starting_year = $end_year;
                $end_year = $aux;
            }

            // Mostramos y iteramos todos los años
            echo "<select class='form-select' id='year' name='year' required>";
            for($i = $starting_year; $i <= $end_year; $i++):
                echo '<option value="'.$i.'">'.$i.'</option>';
            endfor;
            echo "</select>";
        }
    }
?>
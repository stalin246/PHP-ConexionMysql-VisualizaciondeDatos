<?php

function obtenerServicios(){
    try {
        // importar las credenciales
        require "database.php";


        // Consulta SQL

        $sql = "SELECT * FROM servicios;";


        // Realizar la consulta con PHP
        $consulta = mysqli_query($conn, $sql);
        return $consulta;

        // Cerrar la conexion (opcional)
        $resultado = mysqli_close($conn);
        echo($resultado);


    } catch (\Throwable $th) {

        var_dump($th);
        //throw $th;
    }
}

obtenerServicios();
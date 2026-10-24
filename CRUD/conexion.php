<?php

    /*CREAMOS UNA FUNCION LLAMADA CONECTAR*/
    function conectar(){
        /*INFORMACION DEL SERVIDOR*/
        $host = "localhost";
        $user = "root";
        $pass = "";

        /*NOMBRE DE LA BASE DE DATOS*/
        $db ="aw221";
        
        /*PERMITIMOS CONECTAR A MYSQL*/
        $con = mysqli_connect($host, $user, $pass);
        
        /*LE VAMOS A DECIR QUE BD Y LA INFORMACION DE LA BD QUE VAMOS A USAR*/
        mysqli_select_db($con, $db);

        return $con;

    }

?>
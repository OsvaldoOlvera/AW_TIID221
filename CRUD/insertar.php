<?php

/*INCLUIR LA INFORMACION DEL ARCHIVO CONEXION.PHP*/
include("conexion.php");

/*MANDAMOS A LLAMAR LA FUNCION CONECTAR PARA EJECUTAR*/
$con = conectar();

/* RECIBIR LA INFORMACION DEL FORMULARIO */
$matricula  = $_POST['matricula'];
$nombre     = $_POST['nombre'];
$a_paterno  = $_POST['a_paterno'];
$a_materno  = $_POST['a_materno'];
$edad       = $_POST['edad'];

/*CREAR NUESTRA CONSULTA SQL PARA INSERTAR LOS DATOS EN LA TABLA ALUMNOS*/
$sql = "INSERT INTO alumnos (matricula, nombre, a_paterno, a_materno, edad) VALUES ('$matricula', '$nombre', '$a_paterno', '$a_materno', '$edad')";

/* EJECUTAR LA CONSULTA*/
$query = mysqli_query($con,$sql);

/* COMPROBAR Y DIRECCIONAR */
if($query){
    Header("Location: alumnos.php");
}else{
    echo "Error al insertar los datos del alumno: " . mysqli_error($con);
}
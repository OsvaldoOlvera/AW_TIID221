<?php

// Incluir la información del archivo conexion.php
include("conexion.php");

// Mandamos a llamar la función conectar
$con = conectar();

// Recibir el ID del alumno
$id = $_GET['id'];

// Consultar los datos del alumno
$sql = "SELECT * FROM alumnos WHERE id='$id'";

// Ejecutar la consulta
$query = mysqli_query($con, $sql);

// Obtener los datos del alumno
$row = mysqli_fetch_array($query);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar alumno</title>
</head>
<body>

    <h1>Editar alumno</h1>

    <form method="POST">

        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <input type="text" name="matricula" placeholder="Matrícula" value="<?php echo $row['matricula']; ?>">
        <input type="text" name="nombre" placeholder="Nombre" value="<?php echo $row['nombre']; ?>">
        <input type="text" name="a_paterno" placeholder="Apellido paterno" value="<?php echo $row['a_paterno']; ?>">
        <input type="text" name="a_materno" placeholder="Apellido materno" value="<?php echo $row['a_materno']; ?>">
        <input type="text" name="edad" placeholder="Edad" value="<?php echo $row['edad']; ?>">

        <button type="submit" name="actualizar">Actualizar</button>

    </form>

    <?php

    // Comprobar si se presionó el botón
    if(isset($_POST['actualizar'])){
        // Recibir los datos del formulario
        $id = $_POST['id'];
        $matricula = $_POST['matricula'];
        $nombre = $_POST['nombre'];
        $apellido_p = $_POST['apellido_p'];
        $apellido_m = $_POST['apellido_m'];
        $edad = $_POST['edad'];
        // Actualizar los datos del alumno
        $sql = "UPDATE alumnos SET
        matricula='$matricula',
        nombre='$nombre',
        apellido_p='$apellido_p',
        apellido_m='$apellido_m',
        edad='$edad'
        WHERE id='$id'";
        // Ejecutar la consulta
        $query = mysqli_query($con, $sql);
        // Comprobar y direccionar
        if($query){
            header("Location: alumnos.php");
            exit();
        }
        else{
            echo "Error al actualizar los datos";
        }
    }
    ?>
</body>
</html>
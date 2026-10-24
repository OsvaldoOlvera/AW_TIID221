<?php

/*INCLUIR LA INFORMACION DEL ARCHIVO CONEXION.PHP*/
include("conexion.php");

/*MANDAMOS A LLAMAR LA FUNCION CONECTAR PARA EJECUTAR*/
$con = conectar();

/* RECIBIMOS LA MATRÍCULA ENVIADA POR LA URL */
$id = $_GET['id'];

/*ELIMINAMOS AL ALUMNO DE LA TABLA*/
$sql = "DELETE FROM alumnos WHERE id ='$id'";
$query = mysqli_query($con, $sql);

if($query){
    Header("Location: alumnos.php");
    exit();
}else{
    echo "Error al eliminar el alumno" . mysqli_error($con);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de alumnos</title>
</head>
<body>

    <h2>LISTA DE ALUMNOS</h2>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Matrícula</th>
                <th>Nombre</th>
                <th>Apellido paterno</th>
                <th>Apellido materno</th>
                <th>Edad</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php
            while ($row = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['matricula']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['a_paterno']; ?></td>
                    <td><?php echo $row['a_materno']; ?></td>
                    <td><?php echo $row['edad']; ?></td>

                    <td>
                        <a href="delete.php?id=<?php echo $row['id']; ?>">ELIMINAR</a>
                        
                        <br>
                        <a href="editar.php?id=<?php echo $row['id']; ?>">EDITAR</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

</body>
</html>
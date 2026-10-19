<?php

/*INCLUIR LA INFORMACION DEL ARCHIVO CONEXION.PHP*/
include("conexion.php");

/*MANDAMOS A LLAMAR LA FUNCION CONECTAR PARA EJECUTAR*/
$con = conectar();

/*DAME TODOS LOS REGISTROS DE LA TABLA ALUMNOS*/
$sql = "SELECT * FROM alumnos";

/*EJECUTAR LA CONSULTA Y TENDREMOS ACCESO A LA CONEXION*/
$query = mysqli_query($con,$sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            margin: 30px;
        }

        h1 {
            font-family: Georgia, serif;
            font-size: 38px;
            color: #333333;
            margin-bottom: 25px;
        }

        table {
            border-collapse: collapse;
            width: auto;
            text-align: left;
        }

        th, td {
            border: 1px solid #555555;
            padding: 8px 5px;
            font-size: 16px;
        }

        th {
            font-family: Georgia, serif;
            font-weight: bold;
            background-color: #f2f2f2;
        }

        td {
            background-color: #ffffff;
        }

        a {
            color: #5555aa;
            text-decoration: underline;
            cursor: pointer;
        }

        a:hover {
            color: red;
        }
    </style>
</head>
<body>

<table border = "1">
    <h1>Alumnos</h1>

    <thead>
        <tr>
            <th>ID</th>
            <th>MATRÍCULA</th>
            <th>NOMBRE</th>
            <th>A_PATERNO</th>
            <th>A_MATERNO</th>
            <th>EDAD</th>
            <th>ACCIONES</th>
        </tr>
    </thead>
        <tbody>
            <tr>
                <?php
                    while($row = mysqli_fetch_array($query)){
                ?>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['matricula'] ?></td>
                    <td><?php echo $row['nombre'] ?></td>
                    <td><?php echo $row['a_paterno'] ?></td>
                    <td><?php echo $row['a_materno'] ?></td>
                    <td><?php echo $row['edad'] ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $row['id'] ?>">Editar</a> <br>
                        <br>
                        <a href="delete.php?id=<?php echo $row['id'] ?>">Eliminar</a>
                    </td>
                </tr>
                <?php
                    }   
                ?>
        </tbody>

    </table>
    <h1>FORMULARIO</h1>
    <form action="insertar.php" method="POST">
        <input type="text" class="form-control" name="matricula" placeholder="Matrícula">
        <input type="text" class="form-control" name="nombre" placeholder="Nombre">
        <input type="text" class="form-control" name="a_paterno" placeholder="Apellido Paterno">
        <input type="text" class="form-control" name="a_materno" placeholder="Apellido Materno">
        <input type="text" class="form-control" name="edad" placeholder="Edad">
        <button type="submit">Guardar</button>
    </form>
    
</body>
</html>
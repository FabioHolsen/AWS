<?php
        function conexion(){
                $host = "tubasededatos";
                $user = "admin";
                $password = "admin123";
                $database = "alumnos";

        $conexion = mysqli_connect($host,$user,$password,$database);
        if (!$conexion) {
                die("Error de conexion: " . mysqli_connect_error());
        }
        return $conexion;
        }

        $conexion = conexion();
        $result = mysqli_query($conexion, "SELECT * FROM alumnos");
?>

<HTML>
<head>
        <title>Consulta alumnos</title>
</head>
<body>
        <h1>Alumnos</h1>
        <table border="1">
        <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Clase</th>
                <th>Correo electronico</th>
        </tr>
<?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
                <td><?= htmlspecialchars($row['nombre']) ?></td>
                <td><?= htmlspecialchars($row['apellido1'] . " " . $row['apellido2']) ?></td>
                <td><?= htmlspecialchars($row['clase']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>

        </tr>
<?php endwhile; ?>
</table>
</body>
</HTML>

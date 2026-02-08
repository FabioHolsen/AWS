<?php
        function conexion(){
                $host = "basedatos.cluster-ro-cpkgio2u8zmx.us-east-1.rds.amazonaws.com";
                $user = "admin";
                $password = "admin123";
                $database = "productos";

        $conexion = mysqli_connect($host,$user,$password,$database);
        if (!$conexion) {
                die("Error de conexion: " . mysqli_connect_error());
        }
        return $conexion;
        }

        $conexion = conexion();
        $result = mysqli_query($conexion, "SELECT * FROM producto");
?>

<HTML>
<head>
        <title>Consulta productos</title>
</head>
<body>
        <h1>Productos</h1>
        <table border="1">
        <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Color</th>
                <th>Descripcion</th>
                <th>Precio</th>
        </tr>
<?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
                <td><?= htmlspecialchars($row['ID']) ?></td>
                <td><?= htmlspecialchars($row['nombre']) ?></td>
                <td><?= htmlspecialchars($row['color']) ?></td>
                <td><?= htmlspecialchars($row['descripcion']) ?></td>
                <td><?= htmlspecialchars($row['precio']) ?></td>

        </tr>
<?php endwhile; ?>
</table>
</body>
</HTML>

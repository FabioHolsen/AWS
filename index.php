<?php
$error = null;
$result = null;

function conexion(){
    $host = getenv('DB_HOST');
    $user = getenv('DB_USER');
    $password = getenv('DB_PASS');
    $database = getenv('DB_NAME');

    $conexion = mysqli_connect($host, $user, $password, $database);

    if (!$conexion) {
        return false;
    }

    return $conexion;
}

$conexion = conexion();

if (!$conexion) {
    $error = "Servicio temporalmente no disponible. Inténtelo más tarde.";
    error_log("Error de conexión: " . mysqli_connect_error());
} else {
    
    $result = mysqli_query($conexion, "SELECT * FROM producto");

    if (!$result) {
        $error = "Error al obtener los productos.";
        error_log("Error en la consulta: " . mysqli_error($conexion));
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

<header>
    <h1>Catálogo de Productos</h1>
    <p>Gestión y visualización de productos</p>
</header>

<main>
    <h2>Listado</h2>

    <?php if ($error): ?>
        
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php elseif ($result && mysqli_num_rows($result) > 0): ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Color</th>
                <th>Descripción</th>
                <th>Precio</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['ID']) ?></td>
                <td><?= htmlspecialchars($row['nombre']) ?></td>
                <td><?= htmlspecialchars($row['color']) ?></td>
                <td><?= htmlspecialchars($row['descripcion']) ?></td>
                <td><?= number_format($row['precio'], 2, ',', '.') ?> €</td>
            </tr>
            <?php endwhile; ?>

        </table>

    <?php else: ?>
        
        <p>No hay productos disponibles.</p>
    <?php endif; ?>

    <div class="imagen">
        <img src="https://proyectofinal-holsenmalavia.s3.us-east-1.amazonaws.com/gestoria-pyme.jpg" alt="Imagen S3">
    </div>

</main>

<footer>
    © 2026 · Proyecto PHP + MySQL + AWS S3
</footer>

</body>
</html>

<?php
if ($result) {
    mysqli_free_result($result);
}
if ($conexion) {
    mysqli_close($conexion);
}
?>

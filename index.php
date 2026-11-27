<?php
//conexión con la base de datos
$conexion = new mysqli("localhost", "admin", "c123", "trabajadores");

if($conexion->connect_error){
	dire("Error de conexión: " . $conexion->connect_error);
}

//Crear y actualizar datos de empleados

if ($_SERVER["REQUEST_METHOD"] === "POST"){
	$id=$_POST["id"] ?? "";
	$nombre=$_POST["nombre"];
	$email=$_POST["email"];
	$phone=$_POST["phone"];
	$salario=$_POST["salario"];
	$fingre=$_POST["fingre"];
	$estado=$_POST["estado"];

	if($id === "") {
        $stmt = $conexion->prepare("CALL crear_empleado(?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiss", $nombre, $email, $phone, $puesto, $salario, $fingre, $estado);
    } else {
        $stmt = $conexion->prepare("CALL upd_empleado(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssis", $nombre, $email, $phone, $puesto, $salario, $estado);
    }
    $stmt->execute();
    $stmt->close();
    $conexion->next_result();
    header("Location: index.php");
    exit;
}

//Eliminar empleados

if (isset($_GET["eliminar"])) {
    $id = (int)$_GET["eliminar"];
    $stmt = $conexion->prepare("CALL del_empleado(?, ?)");
    $stmt->bind_param("ii", $id, $p_conf);
    $stmt->execute();
    $stmt->close();
    $conexion->next_result();
    header("Location: index.php");
    exit;
}

//Inforamción de los empleados

if(isset($_GET["información"])) {
    $id = (int)$_GET["información"];
    $stmt = $conexion->prepare("CALL info_empleados(?)");
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $stmt->close();
    $conexion->next_result();
    header("Location: index.php");
    exit;
}

if(isset($_GET["nombres"])) {
    $id = (int)$_GET["nombres"];
    $stmt = $conexion->prepare("CALL info_empleados2(?)");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conexion->next_result();
    header("Location: index.php");
    exit;
}


//Listar empleados
$empleados = $conexion->query("CALL listar_empleados()");

//Editar empleados
$editar = ["nombre" => "", "email" => "", "phone" => "", "puesto" => "", "salario" => "", "fingre" => "", "estatus" => ""];
if (isset($_GET["editar"])) {
    $id_editar = (int)$_GET["editar"];
    $res = $conexion->query("SELECT * FROM empleados WHERE id = $id_editar");
    if ($fila = $res->fetch_assoc()) {
        $editar = $fila;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <title>CRUD Empleados - Debian</title>
</head>
<body>
<h1>Prueba Técnia | Getsión de empleados</h1>

<form method="POST" action="index.php">
        <input type="hidden" name="id" value="<?= $editar['id'] ?>">
        <input type="text" name="nombre" placeholder="Nombre" value="<?= htmlspecialchars($editar['nombre']) ?>" required>
        <input type="text" name="email" placeholder="Correo electrónico" value="<?= htmlspecialchars($editar['email']) ?>" required>
        <input type="text" name="phone" placeholder="Teléfono" value="<?= htmlspecialchars($editar['phone']) ?>" required>
        <input type="text" name="puesto" placeholder="Puesto" value="<?= htmlspecialchars($editar['puesto']) ?>" required>
        <input type="number" step="0.01" name="salario" placeholder="Salario" value="<?= $editar['salario'] ?>" required>
        <input type="text" name="fingre" placeholder="Fecha de ingreso" value="<?= htmlspecialchars($editar['fingre']) ?>" required>
        <input type="text" name="estado" placeholder="Estatus" value="<?= htmlspecialchars($editar['estado']) ?>" required>
        <button type="submit"><?= $editar['id'] ? 'Actualizar' : 'Guardar' ?></button>
        <?php if ($editar['id']): ?>
            <a href="index.php" style="padding: 8px;">Cancelar</a>
        <?php endif; ?>
</form>

<table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Telefóno</th>
                <th>Puesto</th>
                <th>Salario</th>
                <th>Fecha de ingreso</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($emp = $empleados->fetch_assoc()): ?>
            <tr>
                <td><?= $emp['id'] ?></td>
                <td><?= htmlspecialchars($emp['nombre']) ?></td>
                <td><?= htmlspecialchars($emp['email']) ?></td>
                <td><?= htmlspecialchars($emp['phone']) ?></td>
                <td><?= htmlspecialchars($emp['puesto']) ?></td>
                <td>$<?= number_format($emp['salario'], 2) ?></td>
                <td><?= htmlspecialchars($emp['fingre']) ?></td>
                <td><?= htmlspecialchars($emp['estado']) ?></td>
                <td>
                    <a href="index.php?editar=<?= $emp['id'] ?>">Editar</a> |
                    <a href="index.php?eliminar=<?= $emp['id'] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>

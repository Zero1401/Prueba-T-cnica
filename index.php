<?php
echo "Holap mundo";
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

?>


<?php
include("conexion.php");
include("funciones.php");

$query = "";
$salida = array();
$query = "SELECT * FROM usuarios ";

if (isset($_POST["search"]["value"])) {
    $query .= 'WHERE nombre LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR apellidos LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR telefono LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR email LIKE "%' . $_POST["search"]["value"] . '%" ';
}

if (isset($_POST["order"]) && isset($_POST["order"]["0"]) && isset($_POST["order"]["0"]["column"]) && isset($_POST["order"]["0"]["dir"])) {
    $query .= 'ORDER BY ' . $_POST["order"]["0"]["column"] . ' ' . $_POST["order"]["0"]["dir"] . ' ';
} else {
    $query .= 'ORDER BY id DESC ';
}

//Se hizo una modificacion para las variables start y length que son valores de dataTables ya que me presentaban un error al momento de paginar
$start = isset($_POST["start"]) ? $_POST["start"] : 0;
$length = isset($_POST["length"]) ? $_POST["length"] : -1;

if ($length != -1) {
    $query .= 'LIMIT ' . $start . ',' . $length;
}

$stmt = $conexion->prepare($query);
$stmt->execute();
$resultado = $stmt->fetchAll();
$datos = array();
$filtered_rows = $stmt->rowCount();
foreach ($resultado as $fila) {
    $imagen = '';
    if ($fila["imagen"] != '') {
        $imagen = '<img src="img/' . $fila["imagen"] . '" class="img-thumbnail" width="50" height="35"/>';
    } else {
        $imagen = '';
    }

    $sub_array = array();
    $sub_array[] = $fila["id"];
    $sub_array[] = $fila["nombre"];
    $sub_array[] = $fila["apellidos"];
    $sub_array[] = $fila["telefono"];
    $sub_array[] = $fila["email"];
    $sub_array[] = $imagen;
    $sub_array[] = $fila["fecha_creacion"];
    $sub_array[] = '<button type="button" name="editar" id="' . $fila["id"] . '" class="btn btn-warning btn-xs editar">Editar</button>';
    $sub_array[] = '<button type="button" name="borrar" id="' . $fila["id"] . '" class="btn btn-danger btn-xs borrar">Borrar</button>';
    $datos[] = $sub_array;
}
$salida = array(
    "draw" => isset($_POST["draw"]) ? intval($_POST["draw"]) : 0,
    "recordsTotal" => $filtered_rows,
    "recordsFiltered" => obtener_todos_registros(),
    "data" => $datos
);

echo json_encode($salida);
?>

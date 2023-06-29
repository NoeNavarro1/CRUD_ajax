<?php
include ("conexion.php");
include ("funciones.php");


if ($_POST["operacion"] == "Crear") {
    $imagen = '';
    if($_FILES["imagen_usuario"]["name"] != ''){
        $imagen = subir_imagen();
    }

$stmt = $conexion -> prepare("INSERT INTO usuarios(nombre , apellidos, imagen, telefono, email) VALUES(:nombre, :apellidos, :imagen, :telefono, :email)");

$resultado = $stmt ->execute(
    array(
        ':nombre' => $_POST["nombre"],
        ':apellidos' => $_POST["apellidos"],
        ':telefono' => $_POST["telefono"],
        ':email' => $_POST["email"],
        ':imagen' => $imagen

    )

    );

    if (!empty($resultado)) {
        echo 'Registro creado';
    }
}

//CODIGO DE EDITAR ACTUALIZADO Y CON LA MEJORA DE QUERER ACTUALIZAR CON IMAGEN INDEPENDIENTEMENTE DEL USUARIO
if ($_POST["operacion"] == "Editar") {
    $imagen = '';

    // Verificar si se ha seleccionado una imagen para subir
    if ($_FILES["imagen_usuario"]["name"] != '') {
        $imagen = subir_imagen();
    }

    $stmt = $conexion->prepare("UPDATE usuarios SET nombre=:nombre, apellidos=:apellidos, imagen=:imagen, telefono=:telefono, email=:email WHERE id=:id");

    $resultado = $stmt->execute(
        array(
            ':nombre' => $_POST["nombre"],
            ':apellidos' => $_POST["apellidos"],
            ':telefono' => $_POST["telefono"],
            ':email' => $_POST["email"],
            ':imagen' => $imagen,
            ':id' => $_POST["id_usuario"]
        )
    );

    if (!empty($resultado)) {
        echo 'Registro actualizado';
    }
}


//CODIGO DE EDITAR ANTERIOR QUE PODRA FUNCIONAR DESPUES
// if ($_POST["operacion"] == "Editar") {
//     $imagen = '';
//     if($_FILES["imagen_usuario"]["name"] != ''){
//         $imagen = subir_imagen();
//     }else{
//         $imagen = $_POST["imagen_usuario_oculta"];
//     }

// $stmt = $conexion -> prepare("UPDATE usuarios SET nombre=:nombre, apellidos=:apellidos, imagen=:imagen, telefono=:telefono, email=:email WHERE id=:id");

// $resultado = $stmt ->execute(
//     array(
//         ':nombre' => $_POST["nombre"],
//         ':apellidos' => $_POST["apellidos"],
//         ':telefono' => $_POST["telefono"],
//         ':email' => $_POST["email"],
//         ':imagen' => $imagen,
//         ':id' => $_POST["id_usuario"]
//         )
//     );

//     if (!empty($resultado)) {
//         echo 'Registro actualizado';
//     }

<?php
//funcion para pbtener imagen y almacenarla en la carpeta img 
function subir_imagen(){
    if (isset($_FILES["imagen_usuario"])) {

        $extension = explode('.', $_FILES["imagen_usuario"]['name']);
        $nuevo_nombre = rand() . '.' . $extension[1];
        $ubicacion = './img/' . $nuevo_nombre;
        move_uploaded_file($_FILES["imagen_usuario"]['tmp_name'], $ubicacion);
        return $nuevo_nombre;
    }
}

//funcion para obtener el nombre y para que los nombres no se dupliquen 
function obtener_nombre_imagen($id_usuario){
    include('conexion.php');
    $stmt = $conexion -> prepare("SELECT imagen from usuarios WHERE id = '$id_usuario'");
    $stmt ->execute();
    $resultado = $stmt -> fetchAll();
    foreach($resultado as $fila){
        return $fila['imagen'];
    } 
}

function obtener_todos_registros(){
    include('conexion.php');
    $stmt = $conexion -> prepare("SELECT * from usuarios");
    $stmt ->execute();
    $resultado = $stmt -> fetchAll();
    return $stmt -> rowCount();
}
?>
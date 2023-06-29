<?php
//funcion para obtener imagen y almacenarla en la carpeta img 
function subir_imagen(){
    if (isset($_FILES["imagen_usuario"])) {

        //extrae la extensión del archivo y genera un nuevo nombre de archivo aleatorio utilizando la función rand().
        $extension = explode('.', $_FILES["imagen_usuario"]['name']);
        $nuevo_nombre = rand() . '.' . $extension[1];
        $ubicacion = './img/' . $nuevo_nombre;
        //se mueve el archivo desde su ubicación temporal a la ubicación definitiva utilizando move_uploaded_file().
        move_uploaded_file($_FILES["imagen_usuario"]['tmp_name'], $ubicacion);
        return $nuevo_nombre;
    }
}

//obtener el nombre de la imagen asociada a un usuario específico en la base de datos.
//funcion para obtener el nombre y para que los nombres no se dupliquen 
function obtener_nombre_imagen($id_usuario){
    include('conexion.php');
    $stmt = $conexion -> prepare("SELECT imagen from usuarios WHERE id = '$id_usuario'");
    $stmt ->execute();

    //El resultado se almacena en la variable $resultado y se itera sobre ella para obtener el nombre de la imagen.
    $resultado = $stmt -> fetchAll();
    foreach($resultado as $fila){
        return $fila['imagen'];
    } 
}

//obtener el número total de registros en la tabla "usuarios" de la base de datos.
function obtener_todos_registros(){
    include('conexion.php');
    $stmt = $conexion -> prepare("SELECT * from usuarios");
    $stmt ->execute();
    //se almacena el resultado en la variable $resultado
    $resultado = $stmt -> fetchAll();
    //se utiliza la función rowCount() para contar el número de filas devueltas por la consulta y se devuelve este valor.
    return $stmt -> rowCount(); 
}
?>
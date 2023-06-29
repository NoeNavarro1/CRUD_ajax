<?php

include ("conexion.php");
include ("funciones.php");

if (isset($_POST["id_usuario"])) { // Verifica si se ha enviado la variable "id_usuario"

    // Se llama a la función "obtener_nombre_imagen" pasando el valor de "id_usuario" como argumento
    // El resultado se almacena en la variable $imagen
    $imagen = obtener_nombre_imagen($_POST["id_usuario"]);

    // Si la variable $imagen no está vacía (es decir, se encontró una imagen asociada al usuario),
    // se elimina el archivo de imagen correspondiente utilizando la función "unlink"
    if($imagen != ''){
        unlink("img/" . $imagen);
    }

// Se prepara una consulta SQL para eliminar un registro de la tabla "usuarios" con el valor "id" igual a :id
$stmt = $conexion -> prepare("DELETE FROM usuarios WHERE id=:id");

// Se ejecuta la consulta SQL, pasando el valor de "id_usuario" como valor para :id en la consulta preparada
// El resultado de la ejecución se almacena en la variable $resultado
$resultado = $stmt ->execute(
    array(
        ':id' => $_POST["id_usuario"]
        )
    );

    // Si el resultado no está vacío (es decir, la eliminación se realizó correctamente),
    // se muestra el mensaje "Registro eliminado"
    if (!empty($resultado)) {
        echo 'Registro eliminado';
    }
}
?>
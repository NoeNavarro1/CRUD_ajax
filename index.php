<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!--Estilos de CSS-->
    <link rel="stylesheet" href="css/estilos.css">

    <title>Curso CRUD con PHP, PDO , Ajax y Datatables.js</title>
</head>

<body>
    <div class="container fondo">
        <h1 class="text-center">Curso CRUD con PHP, PDO , Ajax y Datatables.js</h1>
        <div class="row">
            <div class="col-2 offset-10">
                <div class="text-center">
                    <!-- Boton para modal -->
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalUsuario" id="botonCrear">
                        <i class="bi bi-plus-circle-fill"></i>Crear
                    </button>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="table-responsive">
            <table id="datos_usuario" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Imagen</th>
                        <th>Fecha Creación</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!--Ventana para el modal-->
    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="index.php" id="formulario" method="POST" enctype="multipart/form-data" action="">
                    <div class="moda-content">
                        <div class="modal-body">
                            <label for="nombre">Ingrese el nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" autocomplete="off">
                            <br>

                            <label for="apellidos">Ingrese los apellidos</label>
                            <input type="text" name="apellidos" id="apellidos" class="form-control" autocomplete="off">
                            <br>

                            <label for="telefono">Ingrese el telefono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control" autocomplete="off">
                            <br>

                            <label for="email">Ingrese el correo</label>
                            <input type="email" name="email" id="email" class="form-control" autocomplete="off">
                            <br>

                            <label for="imagen">Selecciona una imagen</label>
                            <input type="file" name="imagen_usuario" id="imagen_usuario" class="form-control">
                            <span id="imagen_subida"></span>
                            <br>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="id_usuario" id="id_usuario">
                            <input type="hidden" name="operacion" id="operacion">
                            <input type="submit" name="action" id="action" class="btn btn-success" value="Crear">

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#botonCrear").click(function() {
                $("#formulario")[0].reset();
                $(".modal-title").text("Crear usuario");
                $("#action").val("Crear");
                $("#operacion").val("Crear"); 
                $("#imagen_subida").html("");
            })
            
            //Funcionalidad de el propio DataTables para mostrar y filtrar los datos
            var dataTable = $('#datos_usuario').DataTable({
                "processing":true,
                "serverSide":true,
                "order": [],
                "ajax": {
                    url: "obtener_registros.php",
                    type: "POST",
                },
                "columnDefs": [{
                    "targets":[3,4,5,7,8], //este targets sirve para los datos que no queremos que se filtren de las columnas
                    "orderable":false
                }, 
            ],
            "language":{ //se cambia el lenguaje a español para un mejor ententimiento
                "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    }
            });


            //Aqui esta el codigo para la insercion de los datos
            $(document).on("submit", "#formulario", function(event) {
                event.preventDefault();
                //obtenemos los datos del form con .val()
                var nombres = $("#nombre").val();
                var apellidos = $("#apellidos").val();
                var telefono = $("#telefono").val();
                var email = $("#email").val();
                var extension = $("#imagen_usuario").val().split('.').pop().toLowerCase();

                //hacemos una cndicion para el formato admitido para las imagenes
                if (extension != '') {
                    if (jQuery.inArray(extension, ["gif", "png", "jpg", "jpeg"]) == -1) {
                        alert("Formato de imagen invalido");
                        $("#imagen_usuario").val('');
                        return false;
                    }
                }
                
                //solicitud ajax para enviar datos del formulario
                //se verifica que las variables o datos no esten vacios de lo contrario te soltara una alerta
                if (nombres != '' && apellidos != '' && email != '') {
                    $.ajax({
                        url: "crear.php",
                        method: 'POST',
                        //crea un objeto FormData a partir del formulario actual, lo que permite enviar datos en formato de formulario.
                        data: new FormData(this), 
                        contentType: false,
                        processData: false, //no se procesan los datos
                        success: function(data) {
                            alert(data);
                            $('#formulario')[0].reset();
                            $('#modalUsuario').modal('hide');
                            dataTable.ajax.reload(); //se recarga la tabla
                        }
                    });
                } else {
                    alert("Algunos campos son obligatorios");
                }
            });


            //funcionalidad ajax para actualizar los datos
            //Funcionalidad de editar
            $(document).on('click', '.editar', function() {
                //recupera el valor del atributo "id" del elemento en el que se hizo clic
                var id_usuario = $(this).attr("id");
                $.ajax({
                    url: 'obtener_registro.php',
                    method: 'POST',
                    data: { 
                        id_usuario: id_usuario
                    },
                    dataType: 'json', //espera recibir datos en formato JSON como respuesta del servidor.

                    //Si la solicitud AJAX tiene éxito, se ejecuta la función success
                    success: function(data) {
                        //se utilizan para asignar los valores de los campos del formulario dentro del modal con los datos recibidos del servidor.
                        $('#modalUsuario').modal('show');
                        $('#nombre').val(data.nombre);
                        $('#apellidos').val(data.apellidos);
                        $('#telefono').val(data.telefono);
                        $('#email').val(data.email);
                        $('.modal-title').text("Editar Usuario");
                        $('#id_usuario').val(id_usuario);
                        $('#imagen_subida').html(data.imagen_usuario);
                        $('#action').val("Editar");
                        $('#operacion').val("Editar");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });

            });
            
            //funcionalidad ajax para borrar los datos
            //Funcionalidad de Borrar
            $(document).on('click', '.borrar', function() {
                //recupera el valor del atributo "id" del elemento en el que se hizo clic
                var id_usuario = $(this).attr('id');
                //se muestra una ventana de confirmacion
                if (confirm("Estas seguro de borrar este registro" + " " + id_usuario)) {
                    //se realiza una solicitud AJAX utilizando jQuery
                    $.ajax({
                        url: 'borrar.php',
                        method: 'POST',
                        data: { //se envían los datos al servidor
                            id_usuario: id_usuario
                        },
                        success: function(data) {
                            alert(data);
                            dataTable.ajax.reload(); //actualiza la tabla DataTables,
                        }
                    });
                } else {
                    return false;
                }
            });


        });
    </script>

</body>

</html>
<?php
    require_once "main.php";

     //almacenando datos
     $nombre = limpiar_cadena($_POST['categoria_nombre']);
     $ubicacion = limpiar_cadena($_POST['categoria_ubicacion']);

      //verificando campos obligatorios
    if($nombre == ""){
        echo '  <div class="notification is-danger is-light">
                  <strong>¡No has llenado todos los campos que son obligatorios!</strong>
                 </div>';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}", $nombre)){
        echo '  <div class="notification is-danger is-light">
        <strong>¡Nombre no permitido, verifica el formato!</strong>
        </div>';
        exit();
    }

    if($ubicacion!=""){
        if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}", $ubicacion)){
            echo '  <div class="notification is-danger is-light">
            <strong>¡Ubicacion no permitida, verifica el formato!</strong>
            </div>';
            exit();
        }
    }

     //verificando nombre
     $check_nombre= conexion();
     $check_nombre = $check_nombre->query("SELECT categoria_nombre FROM categoria WHERE categoria_nombre = '$nombre'");
     if($check_nombre->rowCount()>0){
         echo '  <div class="notification is-danger is-light">
                     <strong>Nombre ingresado ya registrado, ingresa otro!</strong>
                  </div>';
         exit();
     }
     $check_nombre=null;

    //guardado los datos en la base de datos
    $guardar_categoria = conexion();
    $guardar_categoria= $guardar_categoria->prepare("INSERT INTO categoria(categoria_nombre,categoria_ubicacion	) 
    VALUES(:nombre,:ubicacion)");

    $marcadores =[
        ":nombre" => $nombre,
        ":ubicacion" => $ubicacion
    ];

    $guardar_categoria->execute($marcadores);
    if($guardar_categoria->rowCount()==1){
        echo '  <div class="notification is-info is-light">
        <strong>Categoria registrada exitosamente!</strong>
        </div>';

    }else{
        echo '  <div class="notification is-danger is-light">
        <strong>Error al registrar la categoria, intente nuevamente!</strong>
        </div>';
        exit();
    }

    $guardar_categoria=null;
?>
<?php 
    require_once "main.php";
    require_once "../inc/session.php";

    //almacenando datos
    $codigo = limpiar_cadena($_POST['producto_codigo']);
    $nombre = limpiar_cadena($_POST['producto_nombre']);
    $precio = limpiar_cadena($_POST['producto_precio']);
    $stock= limpiar_cadena($_POST['producto_stock']);
    $categoria= limpiar_cadena($_POST['producto_categoria']);

     //verificando campos obligatorios
     if($codigo == "" || $nombre == "" ||  $precio == "" ||  $stock == ""||  $categoria == ""){
        echo '  <div class="notification is-danger is-light">
                  <strong>¡No has llenado todos los campos que son obligatorios!</strong>
                 </div>';
        exit();
    }

     //verificando integridad de los datos
     if(verificar_datos("[a-zA-Z0-9- ]{1,70}", $codigo)){
        echo '  <div class="notification is-danger is-light">
        <strong>Codigo no permitido, verifica el formato!</strong>
        </div>';
        exit();
    }

     if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}", $nombre)){
        echo '  <div class="notification is-danger is-light">
        <strong>¡Nombre no permitido, verifica el formato!</strong>
        </div>';
        exit();
    }

    if(verificar_datos("[0-9.]{1,25}", $precio)){
        echo '  <div class="notification is-danger is-light">
        <strong>¡Precio no permitido, verifica el formato!</strong>
        </div>';
        exit();
    }

    if(verificar_datos("[0-9]{1,25}", $stock)){
        echo '  <div class="notification is-danger is-light">
        <strong>¡Stock no permitido, verifica el formato!</strong>
        </div>';
        exit();
    }
    
       //verificando el codigo que no exista
       $check_codigo = conexion();
       $check_codigo = $check_codigo->query("SELECT producto_codigo FROM producto where producto_codigo = '$codigo'");
       if($check_codigo->rowCount()>0){
           echo '  <div class="notification is-danger is-light">
                       <strong>El codigo ya  esta registrado!</strong>
                    </div>';
           exit();
       }

     $check_codigo == null;


      //verificando el nombre que no exista
      $check_nombre = conexion();
      $check_nombre =  $check_nombre->query("SELECT producto_nombre FROM producto where  producto_nombre = '$nombre'");
      if($check_nombre->rowCount()>0){
          echo '  <div class="notification is-danger is-light">
                      <strong>El nombre del producto ya esta registrado!</strong>
                   </div>';
          exit();
      }
    $check_nombre == null;

    
      
      //verificando el categoria que no exista
      $check_categoria = conexion();
      $check_categoria =  $check_categoria ->query("SELECT categoria_id FROM categoria where categoria_id = '$categoria'");
      if($check_categoria->rowCount()<=0){
          echo '  <div class="notification is-danger is-light">
                      <strong>La categoria del producto no existe!</strong>
                   </div>';
          exit();
      }

    $check_categoria  == null;
    
      //directorio de imagenes
      $img_dir="../img/productos/";
      //comprobando si se selecciono una imagen
      if($_FILES['producto_foto']['name'] != "" && $_FILES['producto_foto']['size']>0){
        //verificando el directorio de imagen
        if(!file_exists($img_dir)){
            if(!mkdir($img_dir,0777)){
                echo '  <div class="notification is-danger is-light">
                             <strong>No se puede crear el directorio :(</strong>
                        </div>';
                exit();
            }
        }
        //verificando el formato de las imagenes
        if(mime_content_type($_FILES['producto_foto']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['producto_foto']['tmp_name']) != "image/png"){
            echo '  <div class="notification is-danger is-light">
                      <strong>Formato de imagen no aceptado</strong>
                    </div>';
                    exit();
        }

        //verificando el peso de la imagen
        if(($_FILES['producto_foto']['size']/1024)>3072){
            echo '  <div class="notification is-danger is-light">
                      <strong>Imagen seleccionada supera el peso permitido</strong>
                    </div>';
                    exit();
        }

        //comprobando el fomato de la imagen
        switch(mime_content_type($_FILES['producto_foto']['tmp_name'])){
            case 'image/jpeg':
                 $img_ext=".jpg";
            break;
            case 'image/png':
                $img_ext=".png";
           break;
        }


        chmod($img_dir,0777);
        $img_nombre=renombrar_fotos($nombre);
        $foto=$img_nombre.$img_ext;

        //moviendo el imagen al directorio
        if(!move_uploaded_file($_FILES['producto_foto']['tmp_name'],$img_dir.$foto)){
            echo '  <div class="notification is-danger is-light">
                         <strong>No podemos subir o cargar la imagen al sistema</strong>
                    </div>';
          exit();
        }

      }else{
        $foto="";
      }


    //guardado los datos en la base de datos
    $guardar_producto = conexion();
    $guardar_producto= $guardar_producto->prepare("INSERT INTO producto(producto_codigo,producto_nombre,producto_precio,producto_stock,producto_foto,categoria_id,usuario_id ) 
    VALUES(:codigo,:nombre,:precio,:stock,:foto,:categoria,:usuario)");

$marcadores =[
    ":codigo" => $codigo,
    ":nombre" => $nombre,
    ":precio" => $precio,
    ":stock" => $stock,
    ":foto" => $foto,
    ":categoria"=>$categoria,
    ":usuario"=>$_SESSION['id'],
];

$guardar_producto->execute($marcadores);
if($guardar_producto->rowCount() == 1){
    echo '  <div class="notification is-info is-light">
    <strong>Producto registrado!</strong>
   </div>';
}else{
    if(is_file($img_dir.$foto)){
        chmod($img_dir,$foto,0777);
        unlink($img_dir.$foto);
    }
    echo '  <div class="notification is-danger is-light">
    <strong>Ocurrio un error al registrar el producto!</strong>
   </div>';
}

$guardar_producto = null;

?>
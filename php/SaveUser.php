<?php
    require_once "main.php";
    //almacenando datos
    $nombre = limpiar_cadena($_POST['usuario_nombre']);
    $apellido = limpiar_cadena($_POST['usuario_apellido']);
    $usuario = limpiar_cadena($_POST['usuario_usuario']);
    $email = limpiar_cadena($_POST['usuario_email']);
    $clave1 = limpiar_cadena($_POST['usuario_clave_1']);
    $clave2 = limpiar_cadena($_POST['usuario_clave_2']);

    //verificando campos obligatorios
    if($nombre == "" || $apellido == "" ||  $usuario == "" ||  $clave1 == ""||  $clave2 == ""){
        echo '  <div class="notification is-danger is-light">
                  <strong>¡No has llenado todos los campos que son obligatorios!</strong>
                 </div>';
        exit();

    }
    
    //verificando integridad de los datos
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)){
        echo '  <div class="notification is-danger is-light">
        <strong>¡Nombre no permitido, verifica el formato!</strong>
        </div>';
        exit();
    }

    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)){
        echo '  <div class="notification is-danger is-light">
        <strong>Apellido no permitido, verifica el formato!</strong>
        </div>';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)){
        echo '  <div class="notification is-danger is-light">
        <strong>Usuario no permitido, verifica el formato!</strong>
        </div>';
        exit();
    }
    
    if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave2)){
        echo '  <div class="notification is-danger is-light">
                    <strong>Contraseña no permitida, verifica el formato!</strong>
                </div>';
        exit();
    }

    //verificando el email que no exista
    if($email != ""){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $check_email = conexion();
            $check_email = $check_email->query("SELECT usuario_email FROM usuario where usuario_email = '$email'");
            if($check_email->rowCount()>0){
                echo '  <div class="notification is-danger is-light">
                <strong>Correo ya registrado!</strong>
                 </div>';
                  exit();
            }

        $check_email == null;

        }else{
            echo '  <div class="notification is-danger is-light">
                       <strong>Correo no permitido, verifica el formato!</strong>
                    </div>';
            exit();
        }
    }
    
     //verificando el email que no exista
    $check_usuario = conexion();
        $check_usuario = $check_usuario->query("SELECT usuario_usuario FROM usuario where usuario_usuario = '$usuario'");
        if($check_usuario->rowCount()>0){
            echo '  <div class="notification is-danger is-light">
                        <strong>Usuario ya registrado!</strong>
                     </div>';
            exit();
        }

     $check_usuario == null;
    

         
     //verificando las claves que coincidana
        if($clave1 != $clave2){
            echo '  <div class="notification is-danger is-light">
            <strong>Las contraseñas ingresadas no coinciden!</strong>
             </div>';
            exit();
        }else{
            $clave = password_hash($clave1,PASSWORD_BCRYPT,["costo"=>10]);

        }

    //guardado los datos en la base de datos
    $guardar_Usuarios = conexion();
    $guardar_Usuarios=$guardar_Usuarios->prepare("INSERT INTO usuario(usuario_nombre,usuario_apellido,usuario_usuario,usuario_clave,usuario_email) 
    VALUES(:usuario, :apellido, :usuario, :clave, :email)");
   
    $marcadores =[
        ":nombre" => $nombre,
        ":apellido" => $apellido,
        ":usuario" => $usuario,
        ":clave" => $clave,
        ":email" => $email
    ];

    $guardar_Usuarios->execute($marcadores);
    if($guardar_Usuarios->rowCount() == 1){
        echo '  <div class="notification is-info is-light">
        <strong>Usuario registrado!</strong>
       </div>';
    }else{
        echo '  <div class="notification is-danger is-light">
        <strong>Ocurrio un error al registrar el usuario!</strong>
       </div>';
    }
    
    $guardar_Usuarios = null;
?>
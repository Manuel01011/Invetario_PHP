<?php
    //almacenando datos de los inputs
     $user = limpiar_cadena($_POST['login_usuario']);
     $clave = limpiar_cadena($_POST['login_clave']);

     if($user == "" || $clave == ""){
        echo '  <div class="notification is-danger is-light">
                  <strong>¡No has llenado todos los campos que son obligatorios!</strong>
                 </div>';
        exit();

    }
    
     //verificando integridad de los datos
     if(verificar_datos("[a-zA-Z0-9]{4,20}", $user)){
        echo '  <div class="notification is-danger is-light">
        <strong>¡Usuario no permitido, verifica el formato!</strong>
        </div>';
        exit();
    }

     if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave)){
        echo '  <div class="notification is-danger is-light">
        <strong>¡Clave no permitida, verifica el formato!</strong>
        </div>';
        exit();
    }

    $check_user = conexion();
    $check_user = $check_user->query("SELECT * FROM usuario WHERE usuario_usuario = '$user'");
    if($check_user->rowCount()==1){
        $check_user= $check_user->fetch();

        if($check_user['usuario_usuario']==$user && password_verify($clave,$check_user['usuario_clave'])){

            $_SESSION['id'] = $check_user['usuario_id'];
            $_SESSION['nombre'] = $check_user['usuario_nombre'];
            $_SESSION['apellido'] = $check_user['usuario_apellido'];
            $_SESSION['usuario'] = $check_user['usuario_usuario'];

            if(headers_sent()){
                echo "<script> window.location.href='index.php?Vista=home';</scritp>";
            }else{
                header("Location: index.php?Vista=home");
            }

        }else{
            echo '  <div class="notification is-danger is-light">
            <strong>¡Usuario o clave incorrectos!</strong>
            </div>';
        }
    }else{
         echo '  <div class="notification is-danger is-light">
        <strong>¡Usuario o clave incorrectos!</strong>
        </div>';
    }
    $check_user = null;
?>
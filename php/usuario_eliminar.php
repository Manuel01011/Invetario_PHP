<?php
  $user_id_del= limpiar_cadena($_GET['user_id_del']);

  //verificar usuario
  $check_usuario = conexion();
  $check_usuario=$check_usuario->query("SELECT usuario_id From usuario WHERE usuario_id = '$user_id_del'");

  if($check_usuario->rowCount()==1){

    //verificar usuario
    $check_productos = conexion();
    $check_productos=$check_productos->query("SELECT usuario_id From producto WHERE usuario_id = '$user_id_del' LIMIT 1");

    if($check_productos->rowCount()<= 0){

        $eliminar_usuario = conexion();
        $eliminar_usuario=$eliminar_usuario->prepare("DELETE FROM usuario WHERE usuario_id =:id");

        $eliminar_usuario->execute([":id"=>$user_id_del]);

        if($eliminar_usuario->rowCount()==1){
            echo '
            <div class="notification is-info is-light">
                <strong>¡Usuario eliminada!</strong><br>
                Los datos del usuario se eliminaron con exito
            </div>
        ';
        }else{
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se puede eliminar el usuario, por favor intente nuevamente
            </div>
        ';
        }
        $eliminar_usuario = null;


    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se puede eliminar el usuario por que esta relacionado con productos
            </div>
        ';
    }
    $check_productos = null;
  }else{
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Usuario a eliminar no existe
            </div>
        ';
  }
  $check_usuario=null;
  
?>
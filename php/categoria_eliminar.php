<?php
    $category_id_del= limpiar_cadena($_GET['category_id_del']);

   //verificar categoria
  $check_categoria = conexion();
  $check_categoria=$check_categoria->query("SELECT categoria_id From categoria WHERE categoria_id = '$category_id_del'");

  if($check_categoria->rowCount()==1){

    //verificando productos
    $check_productos = conexion();
    $check_productos=$check_productos->query("SELECT categoria_id From producto WHERE usuario_id = '$category_id_del' LIMIT 1");

    if($check_productos->rowCount()<=0){
        $eliminar_categoria = conexion();
        $eliminar_categoria=$eliminar_categoria->prepare("DELETE FROM categoria WHERE categoria_id =:id");

        $eliminar_categoria->execute([":id"=>$category_id_del]);

        if($eliminar_categoria->rowCount()==1){
            echo '
            <div class="notification is-info is-light">
                <strong>¡Categoria eliminada!</strong><br>
                Los datos de la categoria se eliminaron con exito
            </div>
        ';
        }else{
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se puede eliminar la categoria, por favor intente nuevamente
            </div>
        ';
        }
        $eliminar_categoria= null;

    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se puede eliminar la categoria, ya que tiene productos asociados
        </div>
        ';
    }
    $check_productos = null;

  }else{
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No se puede eliminar la categoria, por favor intente nuevamente
    </div>
    ';
  }
  $check_categoria=null;

?>
<?php
    $inicio = ($pagina>0) ? (($registros*$pagina)-$registros) : 0;
  
    $table="";

    $campos="producto.producto_id, producto.producto_codigo, producto.producto_nombre, 
    producto.producto_precio, producto.producto_stock, producto.producto_foto, categoria.categoria_nombre
    ,usuario.usuario_nombre, usuario.usuario_apellido";

    if(isset($busqueda) && $busqueda!=""){

        $consulta="SELECT $campos FROM producto inner join categoria on producto.categoria_id=categoria.categoria_id
        inner join usuario on producto.usuario_id=usuario.usuario_id WHERE producto.producto_codigo LIKE '%$busqueda%' 
        or producto.producto_nombre LIKE '%$busqueda%' ORDER BY producto.producto_nombre ASC LIMIT $inicio, $registros";
        
        $consulta_Total="SELECT COUNT(producto_id) FROM producto WHERE producto_codigo LIKE '%$busqueda%' 
        or producto_nombre LIKE '%$busqueda%'";

    }elseif($categoria_id>0){

        $consulta="SELECT $campos FROM producto inner join categoria on producto.categoria_id=categoria.categoria_id
        inner join usuario on producto.usuario_id=usuario.usuario_id WHERE producto.categoria_id='$categoria_id' ORDER BY producto.producto.nombre ASC LIMIT $inicio, $registros";
        
        $consulta_Total="SELECT COUNT(producto_id) FROM producto WHERE categoria_id='$categoria_id'";

    } else {
        $consulta="SELECT $campos FROM producto inner join categoria on producto.categoria_id=categoria.categoria_id
        inner join usuario on producto.usuario_id=usuario.usuario_id ORDER BY producto.producto_nombre ASC LIMIT $inicio, $registros";
        
        $consulta_Total="SELECT COUNT(producto_id) FROM producto";
    }

    $conexion=conexion();
    $datos=$conexion->query($consulta);
    $datos= $datos->fetchAll(); 

    $total=$conexion->query($consulta_Total);
    $total=(int) $total->fetchColumn();

    $Npaginas= ceil($total/$registros);


    if($total>=1 && $pagina<=$Npaginas){
        
        $count=$inicio+1;
        $pagina_inicio=$inicio+1;
        foreach($datos as $elementos){
            $table.='
                        <article class="media">
                             <figure class="media-left">
                                  <p class="image is-64x64">';
                                  if(is_file("./img/productos/".$elementos['producto_foto'])){
                                    $table.='  <img src="./img/productos/'.$elementos['producto_foto'].'">';
                                  }else{
                                     $table.='  <img src="./img/producto.png">';
                                  }
                                 
             $table.='</p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        <p>
                            <strong>'.$count.' - '.$elementos['producto_nombre'].'</strong><br>
                            <strong>CODIGO:</strong> '.$elementos['producto_codigo'].', 
                            <strong>PRECIO:</strong> '.$elementos['producto_precio'].', 
                            <strong>STOCK:</strong> '.$elementos['producto_stock'].', 
                            <strong>CATEGORIA:</strong> '.$elementos['categoria_nombre'].', 
                            <strong>REGISTRADO POR:</strong> '.$elementos['usuario_nombre'].' '.$elementos['usuario_apellido'].'
                        </p>
                    </div>
                    <div class="has-text-right">
                        <a href="index.php?Vista=product_img&product_id_up='.$elementos['producto_id'].'" class="button is-link is-rounded is-small">Imagen</a>

                        <a href="index.php?Vista=product_update&product_id_up='.$elementos['producto_id'].'" class="button is-success is-rounded is-small">Actualizar</a>

                        <a href="'.$url.$pagina.'&product_id_del='.$elementos['producto_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                    </div>
                </div>
            </article>

            <hr>

            ';
            $count++;
        }
        $pagina_final=$count-1;

    } else {
        if($total>=1){
            $table.='
                <p class="has-text-centered">
                     <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                        Haga clic acá para recargar el listado
                     </a>
                </p>
            ';
        } else {
            $table.='<p class="has-text-centered">No hay registros en el sistema</p>';
        }
    }

    if($total>=1 && $pagina<=$Npaginas){
        $table.='
            <p class="has-text-right">Mostrando Productos <strong>'.$pagina_inicio.'</strong> al <strong>'.$pagina_final.'</strong> de un <strong>total de '.$total.'</strong></p>
        ';
    }
    
    if($total>=1 && $pagina<=$Npaginas){
         echo paginador_tablas($pagina,$Npaginas,$url,7);
    }

    $conexion=null;
    echo $table; 
?>
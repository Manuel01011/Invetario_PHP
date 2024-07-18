<?php
    $inicio = ($pagina>0) ? (($registros*$pagina)-$registros) : 0;

    $table="";
    if(isset($busqueda) && $busqueda!=""){

        $consulta="SELECT * FROM usuario WHERE ((usuario_id != '".$_SESSION['id']."') AND (usuario_nombre LIKE '%$busqueda%'
        OR (usuario_apellido LIKE '%$busqueda%' OR (usuario_usuario LIKE '%$busqueda%'
        OR (usuario_email LIKE '%$busqueda%')) ORDER BY usuario_nombre ASC LIMIT $inicio, $registros";
        
        $consulta_Total="SELECT COUNT(usuario_id) FROM usuario WHERE
        ((usuario_id != '".$_SESSION['id']."') AND (usuario_nombre LIKE '%$busqueda%'
        OR (usuario_apellido LIKE '%$busqueda%' OR (usuario_usuario LIKE '%$busqueda%'
        OR (usuario_email LIKE '%$busqueda%'))";

    }else{
        $consulta="SELECT * FROM usuario WHERE usuario_id != '".$_SESSION['id']."' ORDER BY usuario_nombre ASC LIMIT $inicio, $registros";
        
        $consulta_Total="SELECT COUNT(usuario_id) FROM usuario WHERE usuario_id != '".$_SESSION['id']."'";
    }

    $conexion=conexion();
    $datos=$conexion->query($consulta);
    $datos= $datos->fetchAll(); 
    $total=$conexion->query($consulta_Total);
    $total=(int) $total->fetchColumn();

    $Npaginas= ceil($total/$registros);

    $table.='
         <div class="table-container">
          <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                   <tr class="has-text-centered">
                       <th>#</th>
                       <th>Nombres</th>
                       <th>Apellidos</th>
                      <th>Usuario</th>
                      <th>Email</th>
                     <th colspan="2">Opciones</th>
                   </tr>
                </thead>
            <tbody>
    ';

    if($total>=1 && $pagina<=$Npaginas){
        
        $count=$inicio+1;
        $pagina_inicio=$inicio+1;
        foreach($datos as $elementos){
            $table.='
                <tr class="has-text-centered" >
                        <td>'.$count.'</td>
                        <td>'.$elementos['usuario_nombre'].'</td>
                        <td>'.$elementos['usuario_apellido'].'</td>
                        <td>'.$elementos['usuario_usuario'].'</td>
                        <td>'.$elementos['usuario_email'].'</td>
                        <td>
                            <a href="index.php?Vista=user_update&user_id_up='.$elementos['usuario_id'].'" class="button is-success is-rounded is-small">Actualizar</a>
                        </td>
                        <td>
                            <a href="'.$url.$pagina.'&user_id_del='.$elementos['usuario_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                        </td>
                </tr>

            ';
            $count++;
        }
        $pagina_final=$count-1;

    }else{
        if($total>=1){
            $table.='
                 <tr class="has-text-centered" >
                    <td colspan="7">
                        <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                            Haga clic acá para recargar el listado
                        </a>
                    </td>
                </tr>
            ';
        }else{
            $table.='
                <tr class="has-text-centered" >
                    <td colspan="7">
                        No hay registros en el sistema
                    </td>
                </tr>
            ';
        }
    }

    $table.='
                
                </tbody>
            </table>
        </div>
    ';

    if($total>=1 && $pagina<=$Npaginas){
        $table.='
            <p class="has-text-right">Mostrando usuarios <strong>'.$pagina_inicio.'</strong> al <strong>'.$pagina_final.'</strong> de un <strong>total de '.$total.'</strong></p>
        ';
    }
    
    if($total>=1 && $pagina<=$Npaginas){
         echo paginador_tablas($pagina,$Npaginas,$url,7);

    }

    $conexion=null;
    echo $table; 
?>
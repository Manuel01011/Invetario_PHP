<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Lista de productos por categoría</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

    ?>
    <div class="columns">

        <div class="column is-one-third">
            <h2 class="title has-text-centered">Categorías</h2>
                 <?php
                    $categoria=conexion();
                    $categoria= $categoria->query("SELECT * FROM categoria");
                    if( $categoria->rowCount()>0){
                        $categoria= $categoria->fetchAll();
                        foreach($categoria as $row){
                            echo '<a href="index.php?Vista=product_category&category_id=' . $row['categoria_id'] . '" class="button is-link is-inverted is-fullwidth">' . $row['categoria_nombre'] . '</a>';
                        }
                    }else{
                        echo '<p class="has-text-centered" >No hay categorías registradas</p>';
                    }
                    $categoria=null;
                ?>
        </div>



        <div class="column">
            <?php
                $categoria_id=(isset($_GET['category_id'])) ? $_GET['category_id'] : 0;

                $categorias=conexion();
                $categorias= $categorias->query("SELECT * FROM categoria WHERE categoria_id='$categoria_id'");
                if( $categorias->rowCount()>0){
                    $categorias= $categorias->fetch();
                    echo '
                      <h2 class="title has-text-centered">'.$categorias['categoria_nombre'].'</h2>
                      <p class="has-text-centered pb-6" >'.$categorias['categoria_ubicacion'].'</p>
                    ';

                     //  eliminar producto
                    if(isset($_GET['product_id_del'])){
                        require_once "./php/producto_eliminar.php";
                    }

                    if(!isset($_GET['page'])){
                        $pagina = 1;
                    }else{
                        $pagina=(int) $_GET['page'];
                        if($pagina <= 1){
                            $pagina = 1;
                        }
                    }

                    $pagina = limpiar_cadena($pagina);

                    $url="index.php?Vista=product_category&category_id=$categoria_id&page=";
                    $registros=15;
                    $busqueda="";

                    require_once "./php/producto_lista.php";
                }else{
                    echo '<p class="has-text-centered" >No hay categorías registradas</p>';
                }
                $categorias=null;
            ?>


        </div>

    </div>
</div>
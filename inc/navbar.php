<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="index.php?Vista=home">
        <img src="./img/12201509.png" width="65" height="35">
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link"> Usuario </a>

                <div class="navbar-dropdown">
                <a class="navbar-item" href="index.php?Vista=user_new"> Crear </a>
                <a class="navbar-item" href="index.php?Vista=user_list"> Listar </a>
                <a class="navbar-item" href="index.php?Vista=user_search"> Buscar </a>
                </div>
            </div>


            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link"> Categoria </a>

                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?Vista=category_new"> Crear </a>
                    <a class="navbar-item" href="index.php?Vista=category_list"> Listar </a>
                    <a class="navbar-item" href="index.php?Vista=category_search"> Buscar </a>
                </div>

            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link"> Productos </a>

                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?Vista=product_new"> Crear </a>
                    <a class="navbar-item" href="index.php?Vista=product_list"> Listar </a>
                    <a class="navbar-item" href="index.php?Vista=product_category"> Por Categoria </a>
                    <a class="navbar-item" href="index.php?Vista=product_search"> Buscar </a>
                </div>
            </div>
        </div>
    </div>
       
    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a href="index.php?Vista=user_update&user_id_up=<?php echo $_SESSION['id']; ?>" class="button is-primary is-rounded">
            Mi cuenta
          </a>
          <a href="index.php?Vista=logout" class="button is-link is-rounded">
             logout
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>
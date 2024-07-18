<?php require "./inc/login.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
   <?php
    include"./inc/head.php"
   ?>
</head>
<body>

<!--video -->

<?php 
    if(!isset($_GET['Vista']) || $_GET['Vista'] == ""){
        $_GET['Vista'] = "login";
    }

    if(is_file("./vista/".$_GET['Vista'].".php") && $_GET['Vista'] !== "login" && $_GET['Vista'] !== "404"){
        include"./inc/navbar.php";

        include"./vista/".$_GET['Vista'].".php";

        include"./inc/script.php";
    }else{
        if($_GET['Vista'] == "login"){
            include"./vista/login.php";
        }else{
            include"./vista/404.php";
        }
    }
?>


    
</body>
</html>
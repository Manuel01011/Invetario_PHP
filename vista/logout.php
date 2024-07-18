<?php
    session_destroy();

    if(headers_sent()){
        echo "<script> window.location.href='index.php?Vista=login';</scritp>";
    }else{
        header("Location: index.php?Vista=login");
    }
?>
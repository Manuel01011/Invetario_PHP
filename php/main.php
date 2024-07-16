<!--Conexion a base de datos-->
<?PHP

    function conexion(){
        return $pdo =  new PDO('mysql:host=localhost;dbname=inventariocrud','root','');
    }

    //verificar datos del login
    function verificar_datos($filtro, $cadena){
        if(preg_match("/^".$filtro."$/",$cadena)){
            
        }
    }

?>
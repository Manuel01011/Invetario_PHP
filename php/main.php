<!--Conexion a base de datos-->
<?PHP

    function conexion(){
        return $pdo =  new PDO('mysql:host=localhost;dbname=inventariocrud','root','');
    }

    //verificar datos de los formulario
    function verificar_datos($filtro, $cadena){
        if(preg_match("/^".$filtro."$/",$cadena)){
            return false;
        }else{
            return true;
        }
    }

    //limpiar las cadenas de texto; trim() elimina los espacios es blanco
    // stripcslashes() elimina los '/' de las cadenas de texto
    // str_ireplace() elimina un tipo de sentencia en este caso <script>
    function limpiar_cadena($cadena){
        $cadena = trim($cadena);
        $cadena = stripcslashes($cadena);
        $cadena = str_ireplace("<script>","",$cadena);
        $cadena=str_ireplace("</script>", "", $cadena);
		$cadena=str_ireplace("<script src", "", $cadena);
		$cadena=str_ireplace("<script type=", "", $cadena);
		$cadena=str_ireplace("SELECT * FROM", "", $cadena);
		$cadena=str_ireplace("DELETE FROM", "", $cadena);
		$cadena=str_ireplace("INSERT INTO", "", $cadena);
		$cadena=str_ireplace("DROP TABLE", "", $cadena);
		$cadena=str_ireplace("DROP DATABASE", "", $cadena);
		$cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
		$cadena=str_ireplace("SHOW TABLES;", "", $cadena);
		$cadena=str_ireplace("SHOW DATABASES;", "", $cadena);
		$cadena=str_ireplace("<?php", "", $cadena);
		$cadena=str_ireplace("?>", "", $cadena);
		$cadena=str_ireplace("--", "", $cadena);
		$cadena=str_ireplace("^", "", $cadena);
		$cadena=str_ireplace("<", "", $cadena);
		$cadena=str_ireplace("[", "", $cadena);
		$cadena=str_ireplace("]", "", $cadena);
		$cadena=str_ireplace("==", "", $cadena);
		$cadena=str_ireplace(";", "", $cadena);
		$cadena=str_ireplace("::", "", $cadena);
		$cadena=trim($cadena);
		$cadena=stripslashes($cadena);
		return $cadena;

    }

?>
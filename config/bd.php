<?php

class BD{

    public static $instancia = null;
    public static function crearInstancia(){

        if(!isset(self::$instancia)){
            $opciones[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            self::$instancia = new PDO('mysql:host=localhost;port=3310;dbname=aplicacion', 'root', '', $opciones);
            //echo "Conexión a la BBDD establecida";
        }
        return self::$instancia;

    }

}

?>
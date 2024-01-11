                                        SISTEMA DE LIBRO DE RECLAMACIONES
-------------------------------------------------------------------------------------------------------------------

--Info Account Admin--

Username: ketinrojaspadilla@gmail.com
Password: 98admin12

Password encryptado: OThhZG1pbjEy

--Errores en servidor local(LOCALHOST)--

1. Las funciones de enviar correos pueden causar problemas, el sistema esta configurado para un dominio y host ya comprado en la web.

2. Para usar la conexión a base de datos, tiene que configurar con las siguientes lineas de codigo(ejemplo), en un servidor web no tiene ningun tipo de error.

<?php

//conexion en localhost xampp

class Conexion
{
    public static function Conectar()
    {
        define('servidor', 'localhost');
        define('nombre_bd', 'reclamaciones_db');
        define('usuario', 'root');
        define('password', '');
        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        try {
            $conexion = new PDO("mysql:host=" . servidor . "; dbname=" . nombre_bd, usuario, password, $opciones);
            return $conexion;
        } catch (Exception $e) {
            die("Error en: " . $e->getMessage());
        }
    }
}
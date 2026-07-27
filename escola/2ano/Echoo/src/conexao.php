<?php
    
    if(strpos($_SERVER['SERVER_ADDR'], '127.') === 0 || $_SERVER['SERVER_ADDR'] === '::1'){
        $conf = parse_ini_file("config_mysql_local.ini");
        //$conf = parse_ini_file("config_postgres_local.ini");
    }else{
        $conf = parse_ini_file("config_mysql_www.ini");
    }


    $string_connection = $conf["driver"] .
            ":dbname=" . $conf["database"] .
            ";host=" . $conf["server"] .
            ";port=" . $conf["port"];

    try {
        $conn = new PDO(
            $string_connection,
            $conf["user"],
            $conf["password"]
        );
        
    } catch (Exception $e) {
        echo "<p>Erro ao se conectar no banco de dados. </p>";
        echo $e->getMessage();
    }
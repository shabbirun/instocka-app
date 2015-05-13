<?php
class Connection{
    
    public function __construct(){
        
    }
    
    public static function cnx(){
        $connect = mysqli_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD,DB_DATABASE);
        /* check connection */
        if (!$connect) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        return $connect;
    }
    
    public static function cnx_ob(){
        $cn = new mysqli(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
        if ($cn->connect_errno) {
            echo "Failed to connect to MySQL: (" . $cn->connect_errno . ") " . $cn->connect_error;
            exit();
        }
        return $cn;
    }
}

?>
<?php

class login_dao{
    
    private $con;//conexion
    public function __construct(){
        $this->con = Connection::cnx();
    }
    
    public function login_validate($name,$pass){
        global $user;
        $bool = false;
        if(!empty($name) && !empty($pass)){
            $Sql="SELECT id FROM user_login WHERE name='".$name."' AND password='".$pass."' OR name_login='".$name."' AND password_login='".$pass."'";
            $res = mysqli_query($this->con, $Sql)or die(mysqli_error());
            $res = $res->fetch_object();
        }else{
            $res = false;
        }
        
        //var_dump($res);
        if($res){
            $bool = true;
            $user->set_session($name,$pass);
        }
        return $bool;
    }
    
    public function get_user_data($name,$pass){
        $Sql = "SELECT id,BIGCOMM_API_TOKEN, BIGCOMM_PATH, BIGCOMM_USERNAME FROM user_login WHERE name_login='".$name."' AND password_login='".$pass."'";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        return $Sql;
    }
    
}

?>
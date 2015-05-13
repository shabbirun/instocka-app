<?php
class user{
    private $name = null;
    private $pass = null;
    private static $bigcomm_api_token;
    private static $bigcomm_path = null;
    private static $bigcomm_username = null;
    private static $userId = null;
    
    public function __construct(){
        
    }
    
    public function get_name(){
        return !empty($this->name)?$this->name:$_SESSION['_user@name_'];
    }
    public function set_name($value){
        $this->name = $value; 
    }
    public function get_pass(){
        return $this->pass;
    }
    public function set_pass($value){
        $this->pass = $value;
    }
    
    public static function get_bigcomm_api_token(){
        if(isset($_SESSION['_user@bigcomm_api_token_'])){
            self::$bigcomm_api_token = $_SESSION['_user@bigcomm_api_token_'];
        }
        return self::$bigcomm_api_token;
    }
    
    public static function get_bigcomm_path(){
        if(isset($_SESSION['_user@bigcomm_path_'])){
            self::$bigcomm_path = $_SESSION['_user@bigcomm_path_'];
        }
        return self::$bigcomm_path;
    }
    
    public static function get_bigcomm_username(){
        if(isset($_SESSION['_user@bigcomm_username_'])){
            self::$bigcomm_username = $_SESSION['_user@bigcomm_username_'];
        }
        return self::$bigcomm_username;
    }
    
    public static function get_user_id(){
        if(isset($_SESSION['_user@id_'])){
            self::$userId = $_SESSION['_user@id_'];
        }
        return self::$userId;
    }
    
    public function set_user_data($value){
            $_SESSION['_user@bigcomm_api_token_'] = $value->BIGCOMM_API_TOKEN;
            $_SESSION['_user@bigcomm_path_'] = $value->BIGCOMM_PATH;
            $_SESSION['_user@bigcomm_username_'] = $value->BIGCOMM_USERNAME;
            $_SESSION['_user@id_'] = $value->id;
    }
    
    public function get_session(){
        if(isset($_SESSION['_user@name_'])){
            return $_SESSION['_user@name_'];
        }else{
            
        }
    }
    public function check_session(){
        if(isset($_SESSION['_user@name_']) and isset($_SESSION['_user@pass_'])){
            return true;
        }else{
            return false;
        }
    }
    public function set_session($name,$pass){
        $_SESSION['_user@name_'] = $name;
        $_SESSION['_user@pass_'] = $pass;
    }
    public function set_session_panel($data){
        $_SESSION['_user@name_'] = $data->name;
        $_SESSION['_user@pass_'] = $data->password;
        $this->set_user_data($data);
    }
    public function session_unregister(){
        session_destroy();
    }
    
}
?>
<?php
require 'dao/login_dao.php';

class login{//controller
    private $login;

    public function __construct(){
        
        $this->login = new login_dao();
    }
    
    public function view_login($segments){
        global $user;
        if(!$user->check_session()){
            //include 'view/login.php';
            include 'view/logo.php';
        }else{
            $admin = new admin();
            $admin->view_admin($segments); 
        }       
    }
    
    public function view_login_validate($segments){
        global $user;
        if(isset($_POST['user'])){
            $name = $_POST['user'];
        }else{
            $name = null;
        }
        if(isset($_POST['password'])){
            $pass = $_POST['password'];
        }else{
            $pass = null;
        }
        
        if($this->login->login_validate($name,$pass)){
            $user_data = $this->login->get_user_data($name,$pass);
            if($user_data){
                $user->set_user_data($user_data);//session data
            }
            $admin = new admin();
            $admin->view_admin($segments); 
        }else{
            echo '<div class="msg-system">invalid user or password</div>';
            $this->view_login($segments);
        }
        //include 'view/login.php';
    }
    
    public function logout(){
        global $user;
        $user->session_unregister();
        include 'view/login.php';
    }
}
?>
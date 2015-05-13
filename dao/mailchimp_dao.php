<?php

class mailchimp_dao{
    
    private $customer_id = null;
    private $con=null;
    private $user_id = 0;
    
    public function __construct(){
        $this->con = Connection::cnx();
        $this->user_id = user::get_user_id();
        
    }
    
    public function setUserId($value){
        $this->user_id = $value;
    }
    
    public function getList(){

    }
    
    public function test(){
        print_r(array('test'=>'hii'));
    }
    
    public function getOptionMail(){
        $Sql = "SELECT name FROM option_mail WHERE option_check='y' AND user_login_id='".$this->user_id."'";
        $Sql = mysqli_query($this->con,$Sql)or die(mysqli_error($this->con));
        $Sql = $Sql->fetch_object();
        return $Sql->name;
    }
    
    public function setOptionMail($name){
        $Sql = "UPDATE option_mail op1, option_mail op2 SET op2.option_check='y', op1.option_check='n', op2.date=NOW() WHERE op2.name='".$name."' AND op1.name!='".$name."' AND op1.user_login_id='".$this->user_id."' AND op2.user_login_id='".$this->user_id."'";
        $Sql = mysqli_query($this->con,$Sql);
        return $Sql;
    }
    
    public function getCustomMail(){
        $Sql = "SELECT from_email,from_name,subject,body,header_image,header_bg,footer,footer_bg FROM custom_mail WHERE user_login_id='".$this->user_id."'";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        return $Sql;
    }
    public function setCustomMail($data){
        $Sql = "UPDATE custom_mail SET from_email  = '".$data['from_email']."',
                                       from_name   = '".$data['from_name']."',
                                       subject     = '".$data['subject']."',
                                       header_image= '".$data['image_name']."',
                                       body        = '".$data['body']."',
                                       header_bg   = '".$data['header_bg']."',
                                       footer      = '".$data['footer']."',
                                       footer_bg   = '".$data['footer_bg']."',
                                       date=NOW()  WHERE user_login_id='".$this->user_id."'";
        $Sql = mysqli_query($this->con,$Sql)or die(mysqli_error($this->con));
        return $Sql;
    }
    
    public function getMailchimp(){
        $Sql = "SELECT list_name,list_id,list_web_id,campaign_name FROM mailchimp WHERE user_login_id='".$this->user_id."'";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        return $Sql;
    }
    public function setMailchimp($data){
        $Sql = "UPDATE mailchimp SET list_name='".$data['list_name']."', list_id='".$data['list_id']."', list_web_id='".$data['list_web_id']."',campaign_name='".$data['campaign_name']."', date=NOW() WHERE user_login_id='".$this->user_id."'";
        $Sql = mysqli_query($this->con,$Sql);
        return $Sql;
    }
    
    public function getImage(){
        $Sql = "SELECT header_image FROM custom_mail WHERE user_login_id='".$this->user_id."'";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        return (!empty($Sql))?$Sql->header_image:'';
    }
}
<?php

class Contact{
    private $phpmailer = null; 
    
    public function __construct(){
        
    }
    
    public function view_contact($arr){
        $a = (!empty($arr[1]))?$arr[1]:'';
        switch($a){
            case 'form';
                $this->form();
            break;
            
            case 'send':
                $this->sendMail();
            break;
            
            
            default:
                $this->form();
            break;
        }
    }
    
    public function form(){
        $data = array();
        $active = 'contact';
        include 'view/contact_us.php';
    }
    
    private function sendMail(){
        $data = array();
        $active = 'contact';
        //var_dump($_POST);
        $name    = $_POST['name'];
        $email   = $_POST['email'];
        $phone   = $_POST['phone'];
        $message = $_POST['message'];
        $superadmin_mail = SUPER_ADMIN_EMAIL;
        
        //print_r($customer);exit();
        $mail = new mail();
        $user    = $customer['user'];
        $product = $customer['product'];
        //preapare mail to send
        $subject = 'In Stock Alerts - '.$email.' require information';
        $body  = $message;
        //mig1098@hotmail.com
        try{
            $mail->simpleSend(array(  
                                    'From'      => $email,
                                    'FromName'  => $name,
                                    'AddAddress'=> array($superadmin_mail,'<'.$superadmin_mail.'>'),
                                    'AddReplyTo'=> array($name,$email),
                                    'Subject'   => $subject,
                                    'Body'      => $body
                                  ));
             $data['msg']='Mail sent...';                     
        }catch(Exception $ex){
            //echo $ex->getMessage().'-'.$ex->getFile().' [on line:'.$ex->getLine().']';//$ex->getMessage().'-'.$ex->getLine().'-'.$ex->getFile()
            $data['msg']='Can not send mail...';
        }
        include 'view/contact_us.php';
    }
}
<?php

use model\mailchimp;

class mailchimpC{

    public $mailchimp_dao=null;
    public $mailchimp = null;
    const OPTION_MAILCHIMP = 'mailchimp';
    const OPTION_CUSTOM_MAIL = 'custom_mail';
    const FOLDER_HEADERS = 'assets/images/headers/';
    

    public function __construct(){
        $this->mailchimp_dao = new mailchimp_dao(); 
        $this->mailchimp = new mailchimp('b0ddd6e7ed66757f4f5d69d271531a4b-us8'); 
    }

    public function view_mailchimp($arr){

        $a = !empty($arr[1]) ? $arr[1] : '';

        switch($a){

            case 'list':
                $this->getLists();
            break;

            case 'list_client'://se necesita el id de la lista
                $this->getListClientes('5735c7a0c9');
            break;

            

            case 'subscribe':

                $this->subscribe();

            break;

            

            case 'test':

                echo 'this is a test';

                var_dump($arr);

            break;

            

            case 'list_campaigns':

                $this->getCampaigns();

            break;

            

            case 'list_templates':

                $this->getTemplatesOpt();

            break;

            

            case 'custom_mail':

            //echo 'gfhfghgfh';

                //var_dump($_POST);

            break;

            

            case 'template':

                $this->template();

            break;

            

            case 'set':

                $this->setCustomMail();

            break;

            

            default:

                $this->getLists();

                //var_dump($arr);

            break;

        }

    }

    

    public function getLists(){

        //return $this->mailchimp->call('lists/list');

        print_r($this->mailchimp->getLists());

    }

    

    public function getListClientes($list_id){

        print_r($this->mailchimp->getListClientsByListMembers($list_id));

    }

    

    public function getCampaigns(){

        print_r($this->mailchimp->getCamapigns());

    }

    

    public function getTemplates(){

        print_r($this->mailchimp->getTemplates());

    }

    

    public function getTemplatesOpt(){

        $option = array(

                        'types'=>array('user'=>'true','gallery'=>'false','base'=>'true')

        );

        print_r($this->mailchimp->getTemplatesOption($option));

    }

    

    public function subscribe(){

        $subscriber = array(

                    'id'                => '7595af95f4',

                    'email'             => array('email'=>'mig1098@hotmail.com','leid'=>'438389'),

                    'merge_vars'        => array('FNAME'=>'miglio', 'LNAME'=>'esaud'),

                    'double_optin'      => false,

                    'update_existing'   => true,

                    'replace_interests' => false,

                    'send_welcome'      => false,

        );

        print_r($this->mailchimp->subscribeToList($subscriber));

        // Array ( [email] => programmer1@apolomultimedia.com [euid] => 6ce5407df3 [leid] => 149653709 ) 

        //Array ( [email] => mig1098@hotmail.com [euid] => 9a47cf552c [leid] => 184336109 ) 

        

        //Array ( [email] => mig1098@hotmail.com [euid] => 9a47cf552c [leid] => 188593413 ) 

    }

    

    public function setCustomMail(){

        global $user;

        $mailchimp_dao = new mailchimp_dao();

        //first: set or update data

        if(!empty($_POST) && ($_POST['check'] == self::OPTION_MAILCHIMP || $_POST['check'] == self::OPTION_CUSTOM_MAIL)){

            $mailchimp_dao->setOptionMail($_POST['check']);

            //var_dump($_POST);

            if($_POST['check'] == self::OPTION_MAILCHIMP){

                

                $dataList = explode('|',$_POST['mailchimp_list_data']);

                

                $data = array('list_id'      => $dataList[0],

                              'list_web_id'  => $dataList[1],

                              'list_name'    => $dataList[2],

                              'campaign_name'=>$_POST['mailchimp_campaign_name']);

                $mailchimp_dao->setMailchimp($data);//update data

                

            }else{

                $nameImage = $this->uploadImage();

                if(empty($nameImage)){ $nameImage = $mailchimp_dao->getImage();}

                

                $data = array('from_email'=> addslashes($_POST['custom_from_email']),

                              'from_name' => addslashes($_POST['custom_from_name']),

                              'subject'   => addslashes($_POST['custom_subject']),

                              'body'      => addslashes($_POST['custom_body']),

                              'image_name'=> $nameImage,

                              'header_bg' => addslashes($_POST['header_bg']),

                              'footer'    => addslashes($_POST['footer']),

                              'footer_bg' => addslashes($_POST['footer_bg']),

                              );

                $mailchimp_dao->setCustomMail($data);//update data

            }

        }

        //second: get data

        $data = array();

        $data = $this->getData($mailchimp_dao->getOptionMail());     

        //view

        $active = 'mailchimp';

        include 'view/admin_mailchimp.php';

    }

    //to fill fields mailchimp and custom_mail

    private function getData($optionMail){

        $mailchimp_dao = new mailchimp_dao();

        $custom = $mailchimp_dao->getCustomMail();//custom

        $chimp = $mailchimp_dao->getMailchimp();//mailchimp

        //

        $data = array();

        $data['option_mail'] = $optionMail;

        $data['custom_mail'] = array('from_email'=> $custom->from_email,

                                     'from_name' => $custom->from_name,

                                     'subject'   => $custom->subject,

                                     'body'      => stripslashes($custom->body),

                                     'header_image'    => $custom->header_image,

                                     'header_bg' => $custom->header_bg,

                                     'footer'    => $custom->footer,

                                     'footer_bg' => $custom->footer_bg

                                     );

        $data['mailchimp']   = array('list_name'=>$chimp->list_name,'list_id'=>$chimp->list_id,'list_web_id'=>$chimp->list_web_id,'campaign_name'=>$chimp->campaign_name);//falta contruir esta parte

        

        //

        return $data;

    }

    

    public function uploadImage(){

        $name = null;

        

        $allowedExts = array("gif", "jpeg", "jpg", "png");

        $temp = explode(".", $_FILES["file"]["name"]);

        $extension = end($temp);

        

        if ((  ($_FILES["file"]["type"] == "image/gif")

            || ($_FILES["file"]["type"] == "image/jpeg")

            || ($_FILES["file"]["type"] == "image/jpg")

            || ($_FILES["file"]["type"] == "image/pjpeg")

            || ($_FILES["file"]["type"] == "image/x-png")

            || ($_FILES["file"]["type"] == "image/png"))

            && ($_FILES["file"]["size"] < 500000)

            && in_array($extension, $allowedExts))

        {

          if ($_FILES["file"]["error"] > 0) {

                //echo "Return Code: " . $_FILES["file"]["error"] . "<br>";

              } else {

                //echo "Upload: " . $_FILES["file"]["name"] . "<br>";

                //echo "Type: " . $_FILES["file"]["type"] . "<br>";

                //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";

                //echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

                

                move_uploaded_file($_FILES["file"]["tmp_name"], self::FOLDER_HEADERS . $_FILES["file"]["name"]);

                $name = $_FILES["file"]["name"];

                //echo "Stored in: " . self::FOLDER_HEADERS . $_FILES["file"]["name"];

            }

        } else {

          //echo "Invalid file";

          //exit();

        }

        

        return $name;

    }

    

    public function template(){

        $mailchimp_dao = new mailchimp_dao();

        $this->mailchimp = new mailchimp();

        

        $custom = $mailchimp_dao->getCustomMail();//custom

        

        $template['custom_mail'] = array('from_email'=> $custom->from_email,

                                     'from_name' => $custom->from_name,

                                     'subject'   => $custom->subject,

                                     'body'      => $custom->body,

                                     'header_image' => $custom->header_image,

                                     'header_bg' => $custom->header_bg,

                                     'footer'    => $custom->footer,

                                     'footer_bg' => $custom->footer_bg

                                     );

        

        include 'view/admin_mailchimp_template.php';

    }

}
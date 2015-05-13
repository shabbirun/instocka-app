<?php
namespace controller;
/*
 * class for popup in bigcommerce
 */
use library\cssfile;

class popup{
    private $cssfile = null;
    private $userId = null;
    const FOLDER_IMAGE = 'assets/images/popup/';
    
    public function __construct(){
        $this->cssfile = new cssfile();
        $this->userId = \user::get_user_id();
    }
    
    public function view_popup($arr){
        $a = (!empty($arr[1]))?$arr[1]:'';
        switch($a){
            case 'write':
                $this->write_css();
            break;
            
            case 'read';
                $this->read_css();
            break;
            
            default:
                $this->test();
            break;
        }
    }
    
    private function test(){
        $url_file = BASE_URL.URLTO_CSS;
        echo $url_file;
    }
    
    public function read_css(){
        $url_file = URLTO_CSS.'bg_style'.$this->userId.'.css';
        if(!file_exists($url_file)){
            $url_css_default = URLTO_CSS.'default.css';
            $cssdata = stripslashes($this->cssfile->read_cssfile($url_css_default));
            $this->cssfile->write_cssfile($url_file,stripslashes($cssdata));
        }
        //echo $url_file;
        $data = array();
        $data['css_data'] = '';
        $data['url_css'] = '';
        $data['user_id'] = $this->userId;
        try{
            $data['css_data'] = stripslashes($this->cssfile->read_cssfile($url_file));
            $data['url_css'] = BASE_URL.$url_file;
            
            //echo 'read';
            //echo nl2br($data);
        }catch(\Exception $e){
            echo 'no read '.$e->getMessage();
        }
        
        include 'view/admin_popup.php';
    }
    
    public function write_css(){
        $url_file = URLTO_CSS.'bg_style'.$this->userId.'.css';
        
        if(isset($_POST['css_default'])){
            $url_css_default = URLTO_CSS.'default.css';
            $cssdata = stripslashes($this->cssfile->read_cssfile($url_css_default));
        }else{
            $cssdata = (!empty($_POST['write_data']))?$_POST['write_data']:null;
        }
        
        try{
            
            $nameimage = $this->uploadImage();
            if(!empty($_POST['write']) && !empty($_POST['write_data'])){
                $resp = $this->cssfile->write_cssfile($url_file,stripslashes($cssdata));
                //echo 'se inserto';
            }
        }catch(\Exception $e){
            echo 'no se inserto '.$e->getMessage();
        }
        
        $data['css_data'] = 'no server response';
        
        $data = array();
        $data['css_data'] = '';
        $data['url_css'] = '';
        $data['user_id'] = $this->userId;
        try{
            $data['css_data'] = stripslashes($this->cssfile->read_cssfile($url_file));
            $data['url_css'] = BASE_URL.$url_file;
        }catch(\Exception $e){
            echo $e->getMessage();
        }
        include 'view/admin_popup.php';
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
                //print_r('user_id: '.\user::get_user_id());
                $name ='background_'.\user::get_user_id().'.'.$extension;
                move_uploaded_file($_FILES["file"]["tmp_name"], self::FOLDER_IMAGE . $name);
                //$name = $_FILES["file"]["name"];
                //echo "Stored in: " . self::FOLDER_HEADERS . $_FILES["file"]["name"];
            }
        } else {
          //echo "Invalid file";
          //exit();
        }
        
        return $name;
    }
    
    public function default_cssfile(){
        
    }
    
    
    
    
}
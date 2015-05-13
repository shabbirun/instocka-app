<?php
class admin_dao{
    private $con;
    private $cxobject;//object
    private $user_id = 0;
    private $custom_mail_default = array(
        'subject'=>'{{product_name}} has been updated',
        'body'=>'<p>Greetings: {{subscriber_first_name}} {{subscriber_last_name}} with mail {{subscriber_email}}</p>
                 <p>Product : {{product_name}}&nbsp;</p>
                 <p>Url: {{product_url}}</p>',
        'header_bg'=>'#F5F5F5',
        'footer_bg'=>'#F5F5F5',
        'header_image'=>'header_default_54be98322cc07.jpg'
    );
    public function __construct(){
        $this->con = Connection::cnx();
        $this->user_id = user::get_user_id();
    }
    public function getCount($Sql){
        $count = mysqli_num_rows($Sql);
        return !empty($count)?$count:0;
    }
    public function getLastFile(){
        $Sql="SELECT name,date FROM file ORDER BY id DESC LIMIT 1";
        $Sql=mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        return $Sql;
    }
    public function getPendingNotifications($date,$ini=null,$limit=null){
        $query = "";
        if(!empty($date)){
            $query = " AND (IF(p.updated_at > 0,p.updated_at,p.created_at) BETWEEN '".$date['date_begin']."' AND '".$date['date_end']."' )";  
        }
        $query2 = "";
        if($ini >= 0 && $limit != null){
            $query2 = " LIMIT ".$ini.", ".$limit;
        }
        $Sql = "SELECT c.first_name, c.last_name, c.email, p.product_title, IF(p.updated_at > 0, DATE_FORMAT(p.updated_at,'%m/%d/%Y'), DATE_FORMAT(p.created_at,'%m/%d/%Y')) AS created_at, p.updated_at FROM customer c INNER JOIN product p ON c.id = p.customer_id WHERE sent='n' AND p.user_login_id='".$this->user_id."'".$query." ORDER BY IF(p.updated_at > 0,p.updated_at,p.created_at) DESC ".$query2;
        $Sql = mysqli_query($this->con,$Sql);
        //$Sql = $Sql->fetch_object();
        return $Sql;
    }
    public function getNotified($date,$ini=null,$limit=null){
        $query = "";
        if(!empty($date)){
            $query = " AND (IF(p.updated_at > 0,p.updated_at,p.created_at) BETWEEN '".$date['date_begin']."' AND '".$date['date_end']."' )";  
        }
        $query2 = "";
        if($ini >= 0 && $limit != null){
            $query2 = " LIMIT ".$ini.", ".$limit;
        }
        $Sql = "SELECT c.first_name, c.last_name, c.email, p.product_title, if(p.updated_at > 0, DATE_FORMAT(p.updated_at,'%m/%d/%Y'), DATE_FORMAT(p.created_at,'%m/%d/%Y')) AS created_at, p.updated_at FROM customer c INNER JOIN product p ON c.id = p.customer_id WHERE sent='y' AND p.user_login_id='".$this->user_id."'".$query." ORDER BY IF(p.updated_at > 0,p.updated_at,p.created_at) DESC ".$query2;
        $Sql = mysqli_query($this->con,$Sql);
        //$Sql = $Sql->fetch_object();
        return $Sql;
    }
    public function getSubscribed($date,$ini=null,$limit=null){
        $query = "";
        if(!empty($date)){
            $query = " AND (IF(updated_at > 0,updated_at,created_at) BETWEEN '".$date['date_begin']."' AND '".$date['date_end']."' )";  
        }
        $query2 = "";
        if($ini >= 0 && $limit != null){
            $query2 = " LIMIT ".$ini.", ".$limit;
        }
        $Sql = "SELECT id,first_name,last_name,email,if(updated_at > 0, DATE_FORMAT(updated_at,'%m/%d/%Y'), DATE_FORMAT(created_at,'%m/%d/%Y'))  AS created_at FROM customer WHERE user_login_id='".$this->user_id."' ".$query.$query2;
        $Sql = mysqli_query($this->con,$Sql);
        return $Sql;
    }
    public function setNewUser($user){
        $user['store'] = mysqli_real_escape_string($this->con,$user['store']);
        $user['store_url'] = mysqli_real_escape_string($this->con,$user['store_url']);
        //print_r($user);
        $Sql="INSERT INTO user_login(user_token_id,name,password,store,store_url,email,BIGCOMM_API_TOKEN,BIGCOMM_PATH,BIGCOMM_USERNAME) VALUES('".$user['user_token_id']."','".$user['name']."','".$user['password']."','".$user['store']."','".$user['store_url']."','".$user['email']."','".$user['BIGCOMM_API_TOKEN']."','".$user['BIGCOMM_PATH']."','".$user['BIGCOMM_USERNAME']."')";
        $Sql = mysqli_query($this->con,$Sql);
        $id = mysqli_insert_id($this->con);
        $this->setCustomMail($id,$user['email'],$user['store']);
        $this->setMailchimp($id);
        $this->setOptionMail($id);
        return $id;
    }
    public function updateUser($user,$user_login_id){
        $user['store'] = mysqli_real_escape_string($this->con,$user['store']);
        $user['store_url'] = mysqli_real_escape_string($this->con,$user['store_url']);
        //print_r($user);
        $Sql="UPDATE user_login SET name='".$user['name']."',password='".$user['password']."',store='".$user['store']."',store_url='".$user['store_url']."',email='".$user['email']."' WHERE id='".$user_login_id."'";
        $Sql = mysqli_query($this->con,$Sql);
        return $user_login_id;
    }
    private function setMailchimp($user_id){
        $Sql = "INSERT INTO mailchimp(name_custom_mail,user_login_id,date) VALUES('mailchimp','".$user_id."',NOW())";
        $Sql = mysqli_query($this->con,$Sql);
        return $Sql;
    }
    private function setCustomMail($user_id,$from_email,$from_name){
        $Sql = "INSERT INTO custom_mail(name_custom_mail,from_email,from_name,user_login_id,date,subject,body,header_bg,footer_bg,header_image) VALUES('custom_mail','".$from_email."','".$from_name."','".$user_id."',NOW(),'".$this->custom_mail_default['subject']."','".$this->custom_mail_default['body']."','".$this->custom_mail_default['header_bg']."','".$this->custom_mail_default['footer_bg']."','".$this->custom_mail_default['header_image']."')";
        $Sql = mysqli_query($this->con,$Sql);
        return $Sql;
    }
    private function setOptionMail($user_id){
        $array = array(
                    array('name'=>'custom_mail','option_check'=>'y'),
                    array('name'=>'mailchimp','option_check'=>'n')
        );
        for($i = 0; $i < count($array); $i++){
            $Sql = "INSERT INTO option_mail(name,option_check,user_login_id,date) VALUES('".$array[$i]['name']."','".$array[$i]['option_check']."','".$user_id."',NOW())";
            $Sql = mysqli_query($this->con,$Sql);
        }
        return $Sql;
    }
    public function productsNotification(){
        $this->cxobject = Connection::cnx_ob();
        $Sql = "SELECT count(product_id) as count, product_title,product_id, DATE_FORMAT(created_at,'%m/%d/%Y') AS created_at, updated_at FROM product WHERE sent=? AND user_login_id=? GROUP BY product_id";
        //$stmt = $this->cxobject->stmt_init();
        $stmt = $this->cxobject->prepare($Sql);
        $params = array('sent'=>'y','user_login_id'=>$this->user_id);
        $stmt->bind_param("si", $params['sent'],$params['user_login_id']);
        $stmt->execute();
        $stmt->bind_result($count, $product_title, $product_id, $created_at, $updated_at);
        $data = array();
        while($stmt->fetch()){
            $data[] = (object)array('count'=>$count,'title'=>$product_title,'product_id'=>$product_id,'created_at'=>$created_at,'updated_at'=>$updated_at);
        }
        return $data;
    }
    public function productsPending(){
        $this->cxobject = Connection::cnx_ob();
        $Sql = "SELECT count(product_id) as count, product_title,product_id, DATE_FORMAT(created_at,'%m/%d/%Y') AS created_at, updated_at FROM product WHERE sent=? AND user_login_id=? GROUP BY product_id";
        //$stmt = $this->cxobject->stmt_init();
        $stmt= $this->cxobject->prepare($Sql);
        $params = array('sent'=>'n','user_login_id'=>$this->user_id);
        $stmt->bind_param("si", $params['sent'],$params['user_login_id']);
        $stmt->execute();
        $stmt->bind_result($count, $product_title, $product_id, $created_at, $updated_at);
        $data = array();
        while($stmt->fetch()){
            $data[] = (object)array('count'=>$count,'title'=>$product_title,'product_id'=>$product_id,'created_at'=>$created_at,'updated_at'=>$updated_at);
        }
        return $data;
    }
    public function getUserInfo($user_login_id=false){
        $uid = ($user_login_id==false)?$this->user_id:$user_login_id;
        $Sql = "SELECT ul.name,ul.email,DATE_FORMAT(ut.date, '%Y-%m-%d') as date_created FROM user_login ul INNER JOIN user_token ut  ON ut.id=ul.user_token_id WHERE ul.id='".$uid."'";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        return $Sql;
    }
    public function getPaypal($user_login_id=false){
        $uid = ($user_login_id==false)?$this->user_id:$user_login_id;
        $Sql = "SELECT user_login_id,option_selection1,amount,ipn_track_id,txn_id FROM paypal WHERE user_login_id='".$uid."'";
        $Sql = mysqli_query($this->con,$Sql);
        return $Sql;
    }
    public function getLastPaypalRow($user_login_id=false){
        $uid = ($user_login_id==false)?$this->user_id:$user_login_id;
        $Sql = "SELECT user_login_id,option_selection1,amount,ipn_track_id,txn_id FROM paypal WHERE user_login_id='".$uid."' ORDER BY id DESC";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        return $Sql;
    }
    public function getSuperAdmin($id){
        $Sql = "SELECT mailchimp_apikey,mailchimp_list_id,mailchimp_web_id FROM super WHERE id='".$id."'";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        return $Sql;
    }
}
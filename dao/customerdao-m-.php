<?php

class customerdao{
    private $con=null;
    
    public function __construct(){
        $this->con = Connection::cnx();
    }
    
    public function insertCustomer($customer,$user_login_id){
        $Sql="INSERT INTO customer(first_name,last_name,email,user_login_id,created_at) VALUES('".$customer['first_name']."','".$customer['last_name']."','".$customer['email']."','".$user_login_id."',".$customer['date'].")";
        mysqli_query($this->con,$Sql);
        $id = mysqli_insert_id($this->con);
        return $id;
    }
    
    public function insertProduct($data,$user_login_id){
        $data['product_title'] = mysqli_real_escape_string($this->con, $data['product_title']);
        $Sql="INSERT INTO product(product_title,customer_id,product_id,sent,user_login_id,created_at) VALUES('".$data['product_title']."','".$data['customer_id']."','".$data['product_id']."','".$data['sent']."','".$user_login_id."',".$data['date'].")";
        mysqli_query($this->con,$Sql);
    }
    
    public function validateCustomer($customer, $user_login_id){
        $bool = false;
        $Sql="SELECT email FROM customer WHERE email like '".$customer['email']."' AND user_login_id='".$user_login_id."'";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        if($Sql){
            $bool = true;
        }
        return $bool;
    }
    
    public function getCustomerIdByEmail($customer,$user_login_id){
        $Sql="SELECT id FROM customer WHERE email='".$customer['email']."' AND user_login_id='".$user_login_id."' ";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        
        return $Sql->id;
    }
    
    public function validateProduct($product,$user_login_id){
        $bool = false;
        $Sql = "SELECT id FROM product WHERE product_id='".$product['product_id']."' AND customer_id='".$product['customer_id']."' AND user_login_id='".$user_login_id."'";
        //echo $Sql;
        $Sql = mysqli_query($this->con,$Sql)or die(mysqli_error($this->con));
        $Sql = $Sql->fetch_object();

        if($Sql){
            $bool = true;
        }
        return $bool;
    }
    
    public function updateCustomer($customer,$user_login_id){
        $bool=false;
        $Sql = "UPDATE customer SET first_name='".$customer['first_name']."',last_name='".$customer['last_name']."', updated_at=".$customer['date']." WHERE email='".$customer['email']."' AND user_login_id='".$user_login_id."'";
        $Sql = mysqli_query($this->con,$Sql);
    }
    
    public function updateProduct($data,$user_login_id){
        $data['product_title'] = mysqli_real_escape_string($this->con, $data['product_title']);
        $Sql="UPDATE product SET product_title='".$data['product_title']."',customer_id='".$data['customer_id']."',product_id='".$data['product_id']."',sent='".$data['sent']."', updated_at=".$data['date']." WHERE product_id='".$data['product_id']."' AND customer_id='".$data['customer_id']."' AND user_login_id='".$user_login_id."' ";
        mysqli_query($this->con,$Sql);
    }
    
    public function getUserId($data){
        $Sql = "SELECT id FROM user_login WHERE BIGCOMM_PATH like '%".$data['store_url']."' or store_url like '%".$data['store_url']."' ";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        return ($Sql)?$Sql->id:false;
    }
    
    public function insertToken($data){
        $data['user_context'] = mysqli_real_escape_string ($this->con,$data['user_context']);
        $Sql = "INSERT INTO user_token(access_token,scope,user_id,user_username,user_email,context,date) VALUES('".$data['access_token']."','".$data['scope']."','".$data['user_id']."','".$data['user_username']."','".$data['user_email']."','".$data['context']."',NOW())";
        $Sql = mysqli_query($this->con,$Sql)or die(mysqli_error($this->con));
    }
    
    public function updateToken($data,$payload){
        $data['user_context'] = mysqli_real_escape_string ($this->con,$data['user_context']);
        $Sql = "UPDATE user_token set access_token='".$data['access_token']."',scope='".$data['scope']."',user_id='".$data['user_id']."',user_username='".$data['user_username']."',user_email='".$data['user_email']."',context='".$data['context']."' WHERE id='".$payload->id."'";
        $Sql = mysqli_query($this->con,$Sql)or die(mysqli_error($this->con));
        
    }
    
    public function validateUserToken($user){
        $Sql = "SELECT id as user_token_id,access_token,scope,user_id,user_username,user_email,context FROM user_token WHERE user_id='".$user['id']."' AND user_email='".$user['email']."' AND context='".$user['context']."'";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        return $Sql;
    }
    
    public function validateUserLogin($user){
        $Sql = "SELECT id,user_token_id,name,password,store,store_url,email,BIGCOMM_API_TOKEN,BIGCOMM_PATH,BIGCOMM_USERNAME FROM user_login WHERE user_token_id='".$user->user_token_id."' AND password='".$user->access_token."'";
        $Sql = mysqli_query($this->con, $Sql);
        $Sql = $Sql->fetch_object();
        return ($Sql)?$Sql:false;
    }
    
    public function clientUninstall($user){
        $Sql = "DELETE ut, ul FROM user_token ut, user_login ul WHERE ut.user_id ='".$user['id']."' AND ut.context like '%".$user['store_hash']."' AND ut.id=ul.user_token_id";
        $Sql = mysqli_query($this->con,$Sql);
        if(!$Sql){
            
        }
    }
    
    public function getWebhookData($user_login_id){
        $Sql = "SELECT id,webhook_id FROM webhook WHERE user_login_id='".$user_login_id."'";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        return ($Sql)?$Sql:false;
    }
    
    public function webhookInsert($data){
        $data['destination'] = mysqli_real_escape_string ($this->con,$data['destination']);
        $data['scope']       = mysqli_real_escape_string ($this->con,$data['scope']);
        $Sql = "INSERT INTO webhook(user_login_id,webhook_id,scope,destination,is_active) VALUES('".$data['user_login_id']."','".$data['webhook_id']."','".$data['scope']."','".$data['destination']."','".$data['is_active']."')";
        $Sql = mysqli_query($this->con, $Sql);
    }
    
    public function webhookUpdate($data){
        $data['destination'] = mysqli_real_escape_string ($this->con,$data['destination']);
        $data['scope']       = mysqli_real_escape_string ($this->con,$data['scope']);
        $Sql = "UPDATE webhook SET webhook_id='".$data['webhook_id']."',scope='".$data['scope']."',destination='".$data['destination']."',is_active='".$data['is_active']."' WHERE user_login_id='".$data['user_login_id']."'";
        $Sql = mysqli_query($this->con, $Sql);
    }
    
    public function webhookDelete($data){
        
    }
    
    public function contextExist($context){
        $Sql="SELECT ut.id, ut.user_id, ut.user_email, ut.context, ul.id as user_login_id FROM user_token ut INNER JOIN user_login ul ON ut.id=ul.user_token_id  WHERE context='".$context."' ORDER BY id DESC LIMIT 1";
        $Sql = mysqli_query($this->con, $Sql);
        $Sql = $Sql->fetch_object();
        error_log(json_encode(array('user'=>$Sql->user_id)));
        return !empty($Sql->user_id)?$Sql:false;
    }
    
    
    
}
?>
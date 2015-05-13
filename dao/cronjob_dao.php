<?php

class cronjob_dao{
    private $con;//conexion
    private $user_id=0;
    
    public function __construct(){
        $this->con = Connection::cnx();
    }
    
    public function getCustomers(){
        $Sql = "SELECT id, first_name, last_name, email FROM customer";
        $Sql = mysqli_query($this->con, $Sql);
        return $Sql;
    }
    
    public function getCustomer($customer_id){
        
    }
    
    public function getProduct($customer_id){
        $Sql = "SELECT id, customer_id,product_id FROM product WHERE customer_id='".$customer_id."'";
        $Sql = mysqli_query($this->con, $Sql);
        $Sql = $Sql->fetch_object();
        return $Sql;
    }
    
    public function getProducts($idToBegin, $user_login_id=false, $product_id=false){
        $query = " ";
        if($user_login_id != false){
            $query = " AND p.user_login_id='".$user_login_id."' AND p.product_id='".$product_id."'";
        }
        $Sql = "SELECT p.id, p.customer_id, p.product_id, p.option_sku, p.sent, c.first_name, c.last_name, c.email, p.user_login_id FROM product p INNER JOIN customer c ON p.customer_id = c.id WHERE p.sent='n' AND p.id>".(int)$idToBegin.$query;
        //print_r($Sql);
        $Sql = mysqli_query($this->con, $Sql);
        return $Sql;
    }
    
    public function getLastProductId(){
        $Sql = "SELECT id FROM product ORDER BY id DESC LIMIT 1";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        return ($Sql)?$Sql->id:false;
    }
    
    public function getProductsLimitBegin($limit){
        $Sql = "SELECT p.id, p.customer_id, p.product_id, p.sent, c.first_name, c.last_name, c.email FROM product p INNER JOIN customer c ON p.customer_id = c.id WHERE p.sent='n'";
        $Sql = mysqli_query($this->con, $Sql);
        return $Sql;
    }
    
    public function updateSent($product_id,$option_sku,$sent='y'){
        $Sql = "UPDATE product SET sent='".$sent."', updated_at=NOW() WHERE id='".$product_id."' AND option_sku='".$option_sku."'";
        $Sql = mysqli_query($this->con, $Sql);
    }
    
    public function checkToFollow(){
        $bool = false;
        $Sql = "SELECT id FROM product WHERE sent='n'";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        
        if($Sql){
            $bool = true;
        }
        return $bool;
    }
    
    public function geUsers(){
        $Sql = "SELECT id, name FROM user_login ";
        $Sql = mysqli_query($this->con, $Sql);
        return $Sql;
    }
    
    public function getUserInfo($id){
        $Sql = "SELECT ul.name,ul.store,ul.store_url,ul.email,ul.BIGCOMM_API_TOKEN,ul.BIGCOMM_PATH,ul.BIGCOMM_USERNAME, ut.access_token, ut.context FROM user_login ul INNER JOIN user_token ut WHERE ul.user_token_id=ut.id AND ul.id ='".$id."'";
        //print_r($Sql);
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        return $Sql;
    } 
    
    public function setUserId($value){
        $this->user_id = $value;
    }
    
    public function insertTestData($data){
        /*
        $data['data'] = mysqli_real_escape_string ($this->con,$data['data']);
        $Sql = "INSERT INTO test_data(data,date) VALUES('".$data['data']."', NOW())";
        $Sql = mysqli_query($this->con,$Sql);
        return $Sql;*/
    }
    
    public function setCounter($data){
        $Sql = "INSERT INTO cronjob(table_product_id,created_at) VALUES('".$data['table_product_id']."',NOW())";
        $Sql = mysqli_query($this->con,$Sql);
    }
    
    public function getCounter($data = null){
        $Sql = "SELECT COUNT(*) as count FROM cronjob";
        $Sql = mysqli_query($this->con, $Sql);
        $Sql = $Sql->fetch_object();
        return ($Sql)?$Sql->count:false;
    }
    
    public function limitCounterTime($addtime = '01:40:00'){
        $Sql = "SELECT IF(ADDTIME(created_at,'".$addtime."') <= NOW(),true,false) as reset_table from cronjob ORDER BY created_at DESC LIMIT 1";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        return ($Sql)?$Sql->reset_table:false;
    }
    
    public function updateCounter($data){
        
    }
    
    public function checkCounterStatus(){
        
    }
    
    public function truncate_tables($table){
        if(is_array($table)){
            foreach($table as $value){
                mysqli_query($this->con,"TRUNCATE TABLE ".$value);
            }
        }else if(is_string($table)){
            mysqli_query($this->con,"TRUNCATE TABLE ".$table);
        }
        
    }
    
    public function getExpired($user_login_id){
        $Sql = "SELECT DATE_FORMAT(ut.date, '%Y-%m-%d') as date, pay_flag, pay_begin FROM user_token ut INNER JOIN user_login ul ON ut.id = ul.user_token_id WHERE ul.id='".$user_login_id."'"; 
        $Sql = mysqli_query($this->con, $Sql);
        $Sql = $Sql->fetch_object();
        return $Sql;
    }
    
    public function updatePaid($data){
        $Sql = "update user_token ut INNER JOIN user_login ul ON ut.id = ul.user_token_id set ut.pay_flag='".$data['flag']."', ut.pay_begin='".$data['begin']."' WHERE ul.id='".$data['user_login_id']."'";
        $Sql = mysqli_query($this->con,$Sql);
        return $Sql;
    }
    public function getIdByContext($context){
        $Sql = "SELECT ul.id FROM user_token ut INNER JOIN user_login ul ON ut.id=ul.user_token_id WHERE context = '".$context."'";
        $Sql = mysqli_query($this->con,$Sql);
        $resp = $Sql->fetch_object();
        
        return !empty($resp->id)?$resp->id:false;
    }
}
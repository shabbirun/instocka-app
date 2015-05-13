<?php
class manager_dao{
    private $con;
    public function __construct(){
        $this->con = Connection::cnx();
    }
    public function checkLogin($u,$p){
        $Sql = "SELECT id, login, password FROM super WHERE login='".$u."' AND password='".$p."'";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        if($Sql){
            return $Sql;
        }else{
            return false;
        }
    }
    public function loginUpdate($data){
        if(!empty($data['login']) && !empty($data['password'])){
            $Sql = "UPDATE super SET login='".$data['login']."' , password='".$data['password']."',mailchimp_apikey='".$data['mailchimp_apikey']."',mailchimp_list_id='".$data['mailchimp_list_id']."',mailchimp_web_id='".$data['mailchimp_web_id']."' WHERE id='".$data['id']."'";
            $Sql = mysqli_query($this->con,$Sql);
            return $Sql;
        }
    }
    public function loginGet(){
        $Sql = "SELECT id, login, password,mailchimp_apikey,mailchimp_list_id,mailchimp_web_id FROM super WHERE id=1";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        return $Sql;
    }
    public function getUsers(){
        $Sql = "SELECT DATE_FORMAT(ut.date, '%Y-%m-%d') as date, CASE ut.pay_flag WHEN 0 THEN 'No' WHEN 1 THEN 'YES' END as paid, ut.pay_flag as pay_flag, ut.pay_begin as pay_begin, ut.pay_expire as pay_expire, ul.name,ul.email, ul.store_url, ul.id as user_login_id FROM user_token ut INNER JOIN user_login ul ON ut.id=ul.user_token_id";
        $Sql = mysqli_query($this->con,$Sql);
        return $Sql;
    }
    public function paypalInsert($data){
        //option_selection1   -> date
        //option_selection2   -> user login id 
        $Sql = "INSERT INTO paypal(user_login_id,option_selection1,amount,ipn_track_id,txn_id,date) VALUES('".$data['user_login_id']."','".$data['option_selection1']."','".$data['amount']."','".$data['ipn_track_id']."','".$data['txn_id']."',DATE_FORMAT(NOW(),'%Y-%m-%d'))";
        $Sql = mysqli_query($this->con,$Sql);
        return $Sql;
    }
    public function updatePaid($data){
        $Sql = "update user_token ut INNER JOIN user_login ul ON ut.id = ul.user_token_id set ut.pay_flag='".$data['flag']."', ut.pay_begin='".$data['begin']."' WHERE ul.id='".$data['user_login_id']."'";
        $Sql = mysqli_query($this->con,$Sql);
        return $Sql;
    }
    public function lastPaypalTxnId($data){
        $Sql = "SELECT txn_id FROM paypal WHERE user_login_id='".$data['user_login_id']."' ORDER BY id DESC LIMIT 1";
        $Sql = mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        if($Sql){
            $txn_id = $Sql->txn_id;
        }else{
            return false;
        }
        return $txn_id;
    }
}
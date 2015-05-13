<?php
class Payment_stat_dao{
    private $con=null;
    private $user_login_id;
    
    public function __construct($uid){
        $this->user_login_id = $uid;
        $this->con = Connection::cnx();
    }
    
    public function getPaypalList(){
        $Sql = "SELECT id,option_selection1,amount,ipn_track_id,txn_id,date FROM paypal WHERE user_login_id='".$this->user_login_id."'";
        $Sql = mysqli_query($this->con,$Sql);
        $array = array();
        while($resp = $Sql->fetch_object()){
            $array[] = array(
                'id' => $resp->id,
                'option_selection1' => $resp->option_selection1,
                'amount' => $resp->amount,
                'ipn_track_id' => $resp->ipn_track_id,
                'txn_id' => $resp->txn_id,
                'date' => $resp->date
            );
        }
        return !empty($array)?$array:false;
    }
    
    public function getPaypalCountList(){
        $Sql = "SELECT COUNT(*) as total FROM paypal WHERE user_login_id='".$this->user_login_id."'";
        $Sql=mysqli_query($this->con,$Sql);
        $Sql = $Sql->fetch_object();
        return $Sql?$Sql->total:false;
    }
    
    public function getLastRow(){
        $Sql = "SELECT id,option_selection1,amount,ipn_track_id,txn_id,date FROM paypal WHERE user_login_id='".$this->user_login_id."' ORDER BY id DESC LIMIT 1";
        $Sql = mysqli_query($this->con,$Sql);
        $resp = $Sql->fetch_object();
        return !empty($resp)?array(
                'id' => $resp->id,
                'option_selection1' => $resp->option_selection1,
                'amount' => $resp->amount,
                'ipn_track_id' => $resp->ipn_track_id,
                'txn_id' => $resp->txn_id,
                'date' => $resp->date
            ):false;
    }
    
    public function getUserData(){
        $Sql = "SELECT DATE_FORMAT(ut.date,'%Y-%m-%d') as created_at FROM user_token ut INNER JOIN user_login ul ON ut.id=ul.user_token_id WHERE ul.id = '".$this->user_login_id."'";
        $Sql = mysqli_query($this->con,$Sql);
        $resp = $Sql->fetch_object();
        $array = array(
            'created_at'=>$resp->created_at
        );
        return !empty($array)?$array:false;
    }
}
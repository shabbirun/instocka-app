<?php
/**
 * Check if is paypal paid
 * return status: paid, cancelled, trial
 * */
class Payment_stat{
    private $today = '0000-00-00';
    
    private $pay_flag      = 0;//unable 0 | enable 1
    private $pay_begin     = '';
    private $pay_expire    = '';
    //
    const TRIAL              = 'trial';
    const CANCELLED          = 'cancelled';
    private $user_created_at = '0000-00-00';
    private $user_login_id   = null;
    private $message = array();
    //
    private $payment_stat_dao = null;
    
    public function __construct($user_login_id){
        $this->today = date('Y-m-d');
        $this->user_login_id = $user_login_id;
        $this->payment_stat_dao = new Payment_stat_dao($this->user_login_id);
    }
    
    public function process(){
        if($last_paid = $this->getLastRow()){
            $this->status($last_paid);
        }else{
            $this->unsubscribed($this->getUserData()['created_at']);
        }
    }
    
    private function status($last_paid){//paypal status
        if($last_paid['txn_id'] == 'trial'){
            //count 15 days
        }else if($last_paid['txn_id'] == 'cancelled'){
            //disabled
        }else{
            //count 31 days
        }
    }
    
    private function unsubscribed($createdAt){//no paypal
        var_dump('unsubs');
        var_dump($createdAt);
    }
    
    
    public function ExpireAt(){
        //set message
    }
    //
    public function getLastRow(){
        return $this->payment_stat_dao->getLastRow();
    }
    
    public function getPaypalList(){
        return $this->payment_stat_dao->getPaypalList();
    }
    
    public function getPaypalCountList(){
        return $this->payment_stat_dao->getPaypalCountList();
    }
    
    public function getUserData(){
        return $this->payment_stat_dao->getUserData();
    }
    
    
}

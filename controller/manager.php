<?php
/*
https://www.paypal.com/us/cgi-bin/webscr?cmd=_display-ipns-history
*/
class Manager{
    private $manager_dao;
    public function __construct(){
        $this->manager_dao = new manager_dao();
    }
    public function view_manager($arr){
        $a = (!empty($arr[1]))?$arr[1]:'panel';
        if($a != 'ipn'){
            if(!$this->check_login()){
                $this->login();
                exit();
            }
        }
        switch($a){
            case 'panel':
                $this->panel();
            break;
            case 'settings':
                $this->settings();
            break;
            case 'ipn':
                $this->paypal_ipn(); 
            break;
            case 'ipnreturncancel':
               $this->ipnreturncancel();
            break;
            case 'logout':
                $this->logout();
            break;
            default:
                $this->login();
            break;
        }
    }
    private function login(){
        include 'view/manager_login.php';
    }
    private function check_login(){
        if(!empty($_SESSION['manager_log']) && !empty($_SESSION['manager_pas'])){
            return true;
        }
        $name = (!empty($_POST['user']))?$_POST['user']:false;
        $pass = (!empty($_POST['password']))?$_POST['password']:false;
        if($name === false && $pass === false){
            return false;        
        }
        if($chk = $this->manager_dao->checkLogin($name,$pass)){
            $_SESSION['manager_log'] = $chk->login;
            $_SESSION['manager_pas'] = $chk->password;
            return true;
        }else{
            return false;
        }
    }
    private function logout(){
        session_destroy();
        $this->login();
    }
    public function panel(){
        $add_days = function($days){
            $expire = date('Y-m-d', strtotime($days. ' + 31 days'));
            return $expire;
        };
        $users = $this->manager_dao->getUsers();
        $data = array('users'=>array());
        while($resp = $users->fetch_object()){
            $lastPaypalTxnId = $this->manager_dao->lastPaypalTxnId(array('user_login_id'=>$resp->user_login_id));
            if(!$lastPaypalTxnId){$lastPaypalTxnId='trial';};
            $data['users'][] = array(
                'date' => $resp->date,
                'pay_flag'  => $resp->pay_flag,
                'paid'    => $resp->paid,
                'pay_begin' => !empty($resp->pay_begin)?$resp->pay_begin:$lastPaypalTxnId,
                'pay_expire' => !empty($resp->pay_begin)?$add_days($resp->pay_begin):$lastPaypalTxnId,
                'name' => $resp->name,
                'email' => $resp->email,
                'store_url' => $resp->store_url,
            );
        }
        include 'view/manager_panel.php';
    }
    public function settings(){
        if(!empty($_POST['action']) && $_POST['action'] == 'update'){
            $user = array(
            'login'             => $_POST['user'],
            'password'          => $_POST['password'],
            'mailchimp_apikey'  => trim($_POST['mailchimp_apikey']),
            'mailchimp_list_id' => $_POST['mailchimp_list_id'],
            'mailchimp_web_id'  => $_POST['mailchimp_web_id'],
            'id'=>1
            );
            $this->manager_dao->loginUpdate($user);
        }
        $data = array();
        $r = $this->manager_dao->loginGet();
        $data['login']             = $r->login;
        $data['password']          = $r->password;
        $data['mailchimp_apikey']  = $r->mailchimp_apikey;
        $data['mailchimp_list_id'] = $r->mailchimp_list_id;
        $data['mailchimp_web_id']  = $r->mailchimp_web_id;
        $data['mailchimp_list'] = array();
        if(!empty($r->mailchimp_apikey)){
            $mailchimp = new \model\mailchimp($r->mailchimp_apikey);
            $list = $mailchimp->getLists();
            foreach($list['data'] as $row){
                $data['mailchimp_list'][] = array(
                    'id'         => $row['id'],
                    'web_id'     => $row['web_id'],
                    'name'       => $row['name'],
                    'visibility' => $row['visibility']
                );
            }
        }
        include 'view/manager_settings.php';
    }
    private function paypal_ipn(){
        $payaltest = false; //turn to false to try real transactions, true to sandbox.
        $req       = 'cmd=_notify-validate';
        $fullipnA  = array();
        foreach ($_POST as $key => $value)
        {
        	$fullipnA[$key] = $value;
         	$encodedvalue   = urlencode(stripslashes($value));
        	$req           .= "&$key=$encodedvalue";
        }
        $fullipn = $this->Array2Str(" : ", "\n", $fullipnA);
        if (!$payaltest){
        	$url ='https://www.paypal.com/cgi-bin/webscr';	
        }else{
        	$url ='https://www.sandbox.paypal.com/cgi-bin/webscr'; 	
        }
        /*
        $curl_result = $curl_err='';
        $fp          = curl_init();
        curl_setopt($fp, CURLOPT_URL,$url);
        curl_setopt($fp, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($fp, CURLOPT_POST, 1);
        curl_setopt($fp, CURLOPT_POSTFIELDS, $req);
        curl_setopt($fp, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
        curl_setopt($fp, CURLOPT_HEADER , 0); 
        curl_setopt($fp, CURLOPT_VERBOSE, 1);
        curl_setopt($fp, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($fp, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($fp);
        $curl_err = curl_error($fp);
        curl_close($fp);
        */ 
        // Variables enviadas por Paypal
        $item_name        = $_POST['item_name'];
        $item_number      = $_POST['item_number'];
        $payment_status   = (!empty($_POST['payment_status']))?$_POST['payment_status']:'';
        $payment_currency = $_POST['mc_currency'];
        $receiver_email   = $_POST['receiver_email'];
        $payer_email      = $_POST['payer_email'];
        $txn_type         = $_POST['txn_type'];
        $pending_reason   = $_POST['pending_reason'];
        //$payment_type     = $_POST['payment_type'];
        //$custom_key       = $_POST['custom'];
        $payment_amount   = (!empty($_POST['mc_gross']))?$_POST['mc_gross']:'0.00';
        $date             = (!empty($_POST['option_selection1']))?$_POST['option_selection1']:date('Y-m-d');
        $user_login_id    = $_POST['option_selection2'];
        $ipn_track_id     = (!empty($_POST['ipn_track_id']))?$_POST['ipn_track_id']:'trial';
        $txn_id           = (!empty($_POST['txn_id']))?$_POST['txn_id']:'trial';//transaction id
        //test address_country
        $r = '[18-Dec-2014 17:50:05 America/New_York] cmd=_notify-validate&mc_gross=1.00&protection_eligibility=Ineligible&address_status=unconfirmed&payer_id=N3WAUXSEHHQVQ&tax=0.00&address_street=jron+mi+cas&payment_date=14%3A49%3A50+Dec+18%2C+2014+PST&payment_status=Completed&charset=windows-1252&address_zip=51&first_name=Victor&option_selection1=2014-12-18&option_selection2=44&mc_fee=0.35&address_country_code=PE&address_name=test&notify_version=3.8&custom=&payer_status=unverified&business=accounting%40apolomultimedia.com&address_country=Peru&address_city=Lima&quantity=1&verify_sign=A9buyXS0gbPur4ij.803Qb7GkCc5ADsLcJY5MIyywFc7VPScjX6IWzKr&payer_email=programmer3%40apolomultimedia.com&option_name1=paid_on&option_name2=id_user&txn_id=3JE99949KJ582533X&payment_type=instant&payer_business_name=test&last_name=Obregon&address_state=Lima&receiver_email=accounting%40apolomultimedia.com&payment_fee=0.35&receiver_id=CU4EME4R27RAA&txn_type=web_accept&item_name=test&mc_currency=USD&item_number=001&residence_country=PE&handling_amount=0.00&transaction_subject=&payment_gross=1.00&shipping=0.00&ipn_track_id=e5302a55e3944
[18-Dec-2014 17:50:05 America/New_York] VERIFIED';
/**
[19-Dec-2014 17:52:34 America/New_York] &txn_type=subscr_signup&subscr_id=I-09MGACNAR70W&last_name=ramirez vivanco&option_selection1=2014-12-19&option_selection2=44&residence_country=PE&mc_currency=USD&item_name=Instockalerts App Monthly Subscription&amount1=0.00&business=shabbir@instockalerts.co&amount3=15.00&recurring=1&payer_status=verified&payer_email=accounting@apolomultimedia.com&first_name=gaston enrique&receiver_email=shabbir@instockalerts.co&payer_id=CU4EME4R27RAA&option_name1=paid_on&option_name2=id_user&reattempt=1&password=sZV2xTYmUEjSk&item_number=001&subscr_date=14:51:56 Dec 19, 2014 PST&username=pp-sandychum&charset=windows-1252&period1=15 D&mc_amount1=0.00&period3=1 M&mc_amount3=15.00&auth=AzXb7oNaR9NjvKneIOx8gw9tSuBTMUfROsE4Xs75ZHLzMl03cWoOSySHBvJSxcd3T28useNcPv4jOB6D3pMR1Iw&form_charset=UTF-8
[19-Dec-2014 18:08:20 America/New_York] cmd=_notify-validate&transaction_subject=&payment_date=15%3A08%3A10+Dec+19%2C+2014+PST&txn_type=send_money&last_name=Obregon&residence_country=PE&payment_gross=16.00&mc_currency=USD&business=accounting%40apolomultimedia.com&payment_type=instant&protection_eligibility=Ineligible&verify_sign=AHCWsUSRuzw8W1OvKiL2VxG-d4P2A9Y0bQb-tXoceSmNcIunqBMloLli&payer_status=unverified&payer_email=programmer3%40apolomultimedia.com&txn_id=9GY36315PX042201G&receiver_email=accounting%40apolomultimedia.com&first_name=Victor&payer_id=N3WAUXSEHHQVQ&receiver_id=CU4EME4R27RAA&payer_business_name=test&payment_status=Completed&payment_fee=1.16&mc_fee=1.16&mc_gross=16.00&charset=windows-1252&notify_version=3.8&ipn_track_id=59af31de59fb0
*/
/**
[19-Dec-2014 18:56:33 America/New_York] cmd=_notify-validate&txn_type=subscr_signup&subscr_id=I-08G63AV4TYKR&last_name=ramirez+vivanco&option_selection1=2014-12-19&option_selection2=44&residence_country=PE&mc_currency=USD&item_name=Instockalerts+App+Monthly+Subscription&amount1=0.00&business=shabbir%40instockalerts.co&amount3=15.00&recurring=1&verify_sign=Ai-b982n2iVAcerrtbynh94w7MhcAEanAgcrURNKt8g1qpzCdlN5aAd3&payer_status=verified&payer_email=accounting%40apolomultimedia.com&first_name=gaston+enrique&receiver_email=shabbir%40instockalerts.co&payer_id=CU4EME4R27RAA&option_name1=paid_on&option_name2=id_user&reattempt=1&item_number=001&subscr_date=15%3A56%3A17+Dec+19%2C+2014+PST&charset=windows-1252&notify_version=3.8&period1=15+D&mc_amount1=0.00&period3=1+M&mc_amount3=15.00&ipn_track_id=b25c8f9842543
*/
        error_log($req);
        //error_log($response);
        	// Verifico el estado de la orden
        	if ($payment_status != "Completed")
        	{
        		//TransLog("El pago no fue aceptado por paypal - Estado del Pago: $payment_status");
        		//exit();
        	}
        	//todo bien hasta ahora, la transacción ha sido confirmada por lo tanto puedo realizar mis tareas, 
        	//actualizar DB, stock, acreditar cómputos, activar cuentas etc etc
//subscr_signup , subscr_payment , subscr_cancel
            if($txn_type =='subscr_signup'){
                $this->paypalInsert(array(
                    'user_login_id'     => $user_login_id,
                    'option_selection1' => $date,
                    'amount'            => $payment_amount,
                    'ipn_track_id'      => $ipn_track_id,
                    'txn_id'            => $txn_id
                ));
            }else if($txn_type =='subscr_payment'){
                $this->paypalInsert(array(
                    'user_login_id'     => $user_login_id,
                    'option_selection1' => $date,
                    'amount'            => $payment_amount,
                    'ipn_track_id'      => $ipn_track_id,
                    'txn_id'            => $txn_id
                ));
            }else if($txn_type =='subscr_cancel'){
                $this->paypalInsert(array(
                    'user_login_id'     => $user_login_id,
                    'option_selection1' => $date,
                    'amount'            => $payment_amount,
                    'ipn_track_id'      => $ipn_track_id,
                    'txn_id'            => 'cancelled'
                ));
            }
            if(floatval($payment_amount) > 0){
                $this->update_pay(array(
                    'flag'  =>1,
                    'begin' => $date,
                    'user_login_id' => $user_login_id
                ));
            }else{
                $this->update_pay(array(
                    'flag'  =>0,
                    'begin' => '',
                    'user_login_id' => $user_login_id
                ));
            }
    }
    private function TransLog($message)
    {	
    	//$this->notify_webmaster($message);	
    }
    private function Array2Str($kvsep, $entrysep, $a){
    	$str = "";
    	foreach ($a as $k=>$v)
    	{
    		$str .= "{$k}{$kvsep}{$v}{$entrysep}";
    	}
    	return $str;
    }
    private function notify_webmaster($message)
    {
    }
    private function update_pay($data){
        $this->manager_dao->updatePaid($data);
    }
    private function paypalInsert($data){
        $this->manager_dao->paypalInsert($data);
    }
    private function ipnreturncancel(){
        $req = '';
        foreach ($_POST as $key => $value)
        {
         	$encodedvalue   = urlencode(stripslashes($value));
        	$req           .= "&$key=$encodedvalue";
        }
        error_log($req);
    }
}
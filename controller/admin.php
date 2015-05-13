<?php

class admin{//controller
    public $admin_dao = null;
    private $mailchimp_dao = null;
    const ACCOUNT_SUPER = 'Shabbir@instockalerts.co';//accounting@apolomultimedia.com
    const TRIAL = 'App Store Free Trial';
    const LIMIT=50;
    public function __construct(){
        $this->admin_dao = new admin_dao();
    }
    
    public function view_admin($arr){
        $a = (!empty($arr[1]))?$arr[1]:'';
        $EXPIRE = $this->buttonExpired();
        define('EXPIRE',$EXPIRE);
        
        switch($a){
            case 'subscribed';
                $this->subscribed($arr);
            break;
            
            case 'pending':
                $this->pending();
            break;
            
            case 'notified':
                $this->notified();
            break;
            
            case 'mail':
                $this->mailchimp();
            break;
            
            case 'popup':
                $this->popup();
            break;
            
            case 'newuser':
                $this->new_user();
            break;
            
            case 'install':
                $this->instructionsInstall();
            break;
            
            case 'products':
                $this->products();
            break;
            
            case 'subscribers_csv':  
                $this->createCSV();
            break;
            
            case 'billing':
                $this->billing();
            break;
            
            case 'exp':
                $this->isExpired($arr[2]);
            break;
            
            default:
                $this->pending();
            break;
        }
    }
    
    private function isExpired($uid){
        $paymentstatus = new Payment_stat($uid);
        $paymentstatus->process();
    }
    
    public function subscribed($arr){
        global $user;
        //$csv = ()?;
        //var_dump($arr);
        $date = array();
        if(!empty($_POST['date_begin']) && !empty($_POST['date_end'])){
            $date = array('date_begin'=>$this->dateFormat($_POST['date_begin']),'date_end'=>$this->dateFormat($_POST['date_end']));
            $data = array('date_begin'=>$_POST['date_begin'],'date_end'=>$_POST['date_end']);
        }
        $init = (!empty($_GET['p']))?$_GET['p']:1;
        $customers = $this->admin_dao->getSubscribed($date);
        $paginate = new pagination();
        $total = $this->admin_dao->getCount($customers);
        $paginate->items($total);
        $paginate->limit(self::LIMIT);
        $paginate->currentPage($init);
        $paginate->parameterName("p");
        $init2 = (self::LIMIT)*($init-1);
        $customers = $this->admin_dao->getSubscribed($date,$init2,self::LIMIT);
        $active = 'subscribed';
        include 'view/admin_subscribed.php';
    }
    
    public function pending(){
        global $user;
        
        $date = array();
        if(!empty($_POST['date_begin']) && !empty($_POST['date_end'])){
            $date = array('date_begin'=>$this->dateFormat($_POST['date_begin']),'date_end'=>$this->dateFormat($_POST['date_end']));
            $data = array('date_begin'=>$_POST['date_begin'],'date_end'=>$_POST['date_end']);
        }
        $init = (!empty($_GET['p']))?$_GET['p']:1;
        $pendingNotify = $this->admin_dao->getPendingNotifications($date);
        $paginate = new pagination();
        $total = $this->admin_dao->getCount($pendingNotify);
        $paginate->items($total);
        $paginate->limit(self::LIMIT);
        $paginate->currentPage($init);
        $paginate->parameterName("p");
        $init2 = (self::LIMIT)*($init-1);
        $pendingNotify = $this->admin_dao->getPendingNotifications($date,$init2,self::LIMIT);
        $active = 'pending';
        include 'view/admin_pending.php';
    }
    
    public function notified(){
        global $user;
        $date = array();
        if(!empty($_POST['date_begin']) && !empty($_POST['date_end'])){
            $date = array('date_begin'=>$this->dateFormat($_POST['date_begin']),'date_end'=>$this->dateFormat($_POST['date_end']));
            $data = array('date_begin'=>$_POST['date_begin'],'date_end'=>$_POST['date_end']);
        }
        $init = (!empty($_GET['p']))?$_GET['p']:1;
        $notified = $this->admin_dao->getNotified($date);
        $paginate = new pagination();
        $total = $this->admin_dao->getCount($notified);
        $paginate->items($total);
        $paginate->limit(self::LIMIT);
        $paginate->currentPage($init);
        $paginate->parameterName("p");
        $init2 = (self::LIMIT)*($init-1);

        $notified = $this->admin_dao->getNotified($date,$init2,self::LIMIT);
        $active = 'notified';
        include 'view/admin_notified.php';
    }
    
    public function products(){
        $active = 'products';
        $data = array();
        
        $prodNotify = $this->admin_dao->productsNotification();
        foreach($prodNotify as $p1){
            $data[$p1->product_id] = array('id'=>$p1->product_id,'title'=>$p1->title,'notified'=>$p1->count,'created_at'=>$p1->created_at,'updated_at'=>$p1->updated_at,'pending'=>0);
        }
        $prodPending = $this->admin_dao->productsPending();
        foreach($prodPending as $p2){
            if(empty($data[$p2->product_id])){
                $data[$p2->product_id] = array('id'=>$p2->product_id,'title'=>$p2->title,'notified'=>0,'pending'=>$p2->count,'created_at'=>$p2->created_at,'updated_at'=>$p2->updated_at);
            }else{
                $data[$p2->product_id]['pending']=$p2->count;
            }
        }
        
        include 'view/admin_products.php';
    }
    
    public function mailchimp(){
        global $user;
        $mailchimp_dao = new mailchimp_dao();
        $custom = $mailchimp_dao->getCustomMail();//mailchimp data
        $chimp = $mailchimp_dao->getMailchimp();//custom_mail data
        //
        $data = array();
        $data['option_mail'] = $mailchimp_dao->getOptionMail();//option radio
        $data['mailchimp']   = array('list_name'    =>$chimp->list_name,'list_id'=>$chimp->list_id,'list_web_id'=>$chimp->list_web_id,'campaign_name'=>$chimp->campaign_name);//falta contruir esta parte
        $data['custom_mail'] = array('from_email'   => $custom->from_email,
                                     'from_name'    => $custom->from_name,
                                     'subject'      => $custom->subject,
                                     'body'         => stripslashes($custom->body),
                                     'header_image' => $custom->header_image,
                                     'header_bg'    => $custom->header_bg,
                                     'footer'       => $custom->footer,
                                     'footer_bg'    => $custom->footer_bg
                                     );
        // view
        $active = 'mailchimp';
        include 'view/admin_mailchimp.php';
    }
    
    public function popup(){
        $popup = new \controller\popup();
        $active = 'popup';
        $data = $popup->read_css();//include in
    }
    
    public function new_user($array = null){
        $data = (!empty($array) && !empty($array['password']))?array('user_token_id'=>$array['user_token_id'],'name'=>$array['username'],'password'=>$array['password'],'email'=>$array['email']):null;
        include 'view/admin_newuser.php';
    }
    
    public function add_user(){//into panel bigcommerce
        global $user;
        if(!empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['store']) && !empty($_POST['store_url']) && !empty($_POST['email']) && !empty($_POST['BIGCOMM_API_TOKEN'])  && !empty($_POST['BIGCOMM_PATH'])  && !empty($_POST['BIGCOMM_USERNAME'])){
            $user_data = array('name'=>$_POST['name'],
                          'user_token_id'=>$_POST['user_token_id'],
                          'password'=>$_POST['password'],
                          'store'=>$_POST['store'],
                          'store_url'=>$_POST['store_url'],
                          'email'=>$_POST['email'],
                          'BIGCOMM_API_TOKEN'=>$_POST['BIGCOMM_API_TOKEN'],
                          'BIGCOMM_PATH'=>str_replace('/api/v2/','',$_POST['BIGCOMM_PATH']),
                          'BIGCOMM_USERNAME'=>$_POST['BIGCOMM_USERNAME']
                          );
            $user_login_id = $this->admin_dao->setNewUser($user_data);//VALIDATE TRY CATCH
            
            $user_data['id'] = $user_login_id;
            $user_session_data = (object)$user_data;
            $user->set_session_panel($user_session_data);
            //var_dump($user_session_data);
            $this->pending();
        }else{
            $data['msg']='Any fields are empty...';
            include 'view/admin_newuser.php';
        }
    }
    
    public function show(){
        
    }
    
    public function open_dir(){
        $F = '';
        $e = $this->admin_dao->getLastFile();
        return  $e->name;
    }
    
    public function createCSV(){
        global $user;
        $date = array();
        if(!empty($_POST['date_begin']) && !empty($_POST['date_end'])){
            $date = array('date_begin'=>$this->dateFormat($_POST['date_begin']),'date_end'=>$this->dateFormat($_POST['date_end']));
            //$data = array('date_begin'=>$_POST['date_begin'],'date_end'=>$_POST['date_end']);
        }
        $data = array(
                        'url_folder'=>null,
                        'columns'   =>array('id','first_name','last_name','email'),
                        'list'      => array()
        );
        $subscribed = $this->admin_dao->getSubscribed($date);
        
        while($resp = $subscribed->fetch_object()){
            $data['list'][]=array($resp->id,$resp->first_name,$resp->last_name,$resp->email);
        }
        //var_dump($data);exit();
        $csv_create = new library\csv_create($data);
        $csv_create->download();
        /*$active = 'subscribed';
        include 'view/admin_subscribed.php';*/
    }
    
    public function instructionsInstall(){
        
        $data = array();
        //$user_info = $this->admin_dao->get();
        $data['user_info'] = array(
            'name'=>'programmer',
            'email'=>''
        );
        $active = 'install';
        include 'view/admin_install.php';
    }
    
    public function billing(){
        global $user;
        //
        $data = array();
        $userInfo = $this->admin_dao->getUserInfo();
        $paypal = $this->admin_dao->getPaypal();
        //
        $data['message'] = '';
        $data['paypal'] = array();
        while($resp = $paypal->fetch_object()){
            $data['paypal'][] = array(
                'option_selection1' => $resp->option_selection1,
                'amount'            => $resp->amount,
                'ipn_track_id'      => $resp->ipn_track_id,
                'txn_id'            => $resp->txn_id
            );
        }
        $data['account_super'] = self::ACCOUNT_SUPER;
        $data['name']          = $userInfo->name;
        $data['email']         = $userInfo->email;
        $data['date_created']  = $userInfo->date_created;
        $data['user_login_id'] = user::get_user_id();
        
        //subscription
        $date = date('Y-m-d');
        $subs = '';
        $expire = '';
        
        if(empty($data['paypal'])){//for trial
            $subs = self::TRIAL;
            $expire = date('Y-m-d', strtotime($data['date_created']. ' + 14 days'));// $data['date_created'];
        }else{//for paid an paids expired
            $subs = 'Paid';
            $last = $this->admin_dao->getLastPaypalRow();
            
            $expire = date('Y-m-d', strtotime($last->option_selection1. ' + 31 days'));
            if(strtotime($date) > strtotime($expire)){
                //echo 'expired';
                $data['message'] = 'Your subscription has expired';
            }else{
                //echo 'follow';
                //$data['message'] = 'Your subscription is about to expire, renew today!';
            }
        }
        
        
        $data['subscription'] = $subs;
        $data['expire'] = $expire;
        
        $active = 'plans';
        include 'view/admin_billing.php';
    }
    
    public function buttonExpired(){
        global $user;
        //
        $data = array();
        $userInfo = $this->admin_dao->getUserInfo();
        $paypal = $this->admin_dao->getPaypal();
        //
        $data['message'] = '';
        $data['paypal'] = array();
        while($resp = $paypal->fetch_object()){
            $data['paypal'][] = array(
                'option_selection1' => $resp->option_selection1,
                'amount'            => $resp->amount,
                'ipn_track_id'      => $resp->ipn_track_id,
                'txn_id'            => $resp->txn_id
            );
        }
        $data['date_created']  = $userInfo->date_created;
        
        //subscription
        $date = date('Y-m-d');
        $subs = '';
        $expire = '';
        
        if(empty($data['paypal'])){//for trial
            $subs = self::TRIAL;
            $expire = date('Y-m-d', strtotime($data['date_created']. ' + 14 days'));// $data['date_created'];
        }else{//for paid an paids expired
            $subs = 'Paid';
            $last = $this->admin_dao->getLastPaypalRow();
            
            $expire = date('Y-m-d', strtotime($last->option_selection1. ' + 31 days'));
            if(strtotime($date) > strtotime($expire)){
                //echo 'expired';
                $data['message'] = 'Your subscription has expired';
            }else{
                //echo 'follow';
                //$data['message'] = 'Your subscription is about to expire, renew today!';
            }
        }
        return 'Expire: '.$expire;
    }
    
    private function dateFormat($date){
        $new = explode('/',$date);//month,day,year
        $year = $new[2];
        $month = $new[0];
        $day = $new[1];
        
        return $year.'/'.$month.'/'.$day;
    }
    
    
}

?>
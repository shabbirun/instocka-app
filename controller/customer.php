<?php
/**
 * 
 * @customer is used for several store users which ones accept the aplication
 * 
 * 
 * */
class customer{
    private $customerdao=null;
    private $superadmin_id = 1;
    private $contextExist = false;
    public function __construct(){
        $this->customerdao = new customerdao();   
    }
    public function view_customer($arr){
        $a = $arr[1];
        switch($a){
            case 'insert':
                $this->insert();
            break;
            case 'test':
                print_r($this->getUserId());
            break;
            case 'auth':
                $this->getAccesToken();
            break;
            case 'panel'://bigcommerce merchant panel
                $this->clientPanel();
            break;
            case 'uninstall':
                $this->clientUninstall();
            break;
            case 'webhook':
                $this->createWebhook();
            break;
            case 'getwebhooks':
                $this->getWebhooks();
            break;
            case 'deleteWebhook':
                $this->deleteWebhook($arr[2]);
            break;
            case 'getStore':
                $this->getStoreInformation();
            break;
            default:
                echo 'server error';
            break;
        }
    }
    public function clientPanel(){
        global $user;
        $resp = null;
        $payload = Bigcommerce\Api\Client::verify($_GET['signed_payload'],CLIENT_SECRET);
        if(!empty($payload) && isset($payload['user']['id'])){
            $user1 = $this->publicClientValidate($payload);
        }else{
            exit('payload out');
        }
        //var_dump($user1);
        if(!empty($user1)){
            $resp = $this->customerdao->validateUserLogin($user1);
        }
        //var_dump($resp);
        if(!empty($resp)){
            //print_r($resp);
            $user->set_session_panel($resp);
            $admin = new admin();
            $admin->view_admin('');
        }else if(!empty($user1->user_username)){
            $data = array('user_token_id'=>$user1->user_token_id,'username'=>$user1->user_username,'password'=>$user1->access_token,'email'=>$user1->user_email);
            $admin = new admin();
            $admin->new_user($data);
        }else{
            //throw new MigException();
            exit('<strong>Install have failed, try to install again</strong>');
        }
    }
    /*
    public function clientValidateToPanel($user,$payload){
        $user1 = $this->customerdao->validateUserToken(array('id'=>$payload->user_id,'email'=>$payload->user_email,'context'=>$payload->context));
        //var_dump($user1);
        if(!empty($user1)){
            $resp = $this->customerdao->validateUserLogin($user1);
        }
        if(!empty($resp)){
            $user->set_session_panel($resp);
            $admin = new admin();
            $admin->view_admin('');
        }else if(!empty($user1->user_username)){
            $data = array('user_token_id'=>$user1->user_token_id,'username'=>$user1->user_username,'password'=>$user1->access_token,'email'=>$user1->user_email);
            $admin = new admin();
            $admin->new_user($data);
        }else{
            //throw new MigException();
            exit('<strong>Install have failed, try to install again</strong>');
        }
    }*/
    public function publicClientValidate($payload){
        $user = array('id'        => $payload['user']['id'],
                      'email'     => $payload['user']['email'],
                      'context'   => $payload['context'],
                      'store_hash'=> $payload['store_hash'],
                      'timestamp' => $payload['timestamp']);
        return $this->customerdao->validateUserToken($user);
    }
    private function loginMerchant(){
    }
    public function getAccesToken(){
        global $user;
        $tokenUrl = "https://login.bigcommerce.com/oauth2/token";
        $connection = new Bigcommerce\Api\Connection();
        $this->checkContext(1);
        $connection->setCipher('rsa_rc4_128_sha');//'rsa_rc4_128_sha' | 'RC4-SHA'
        $connection->verifyPeer(false);
        
        $response = $connection->post($tokenUrl, array(
            "client_id" => CLIENT_ID,
            "client_secret" => CLIENT_SECRET,
            "redirect_uri" => REDIRECR_URI,
            "grant_type" => "authorization_code",
            "code" => $_GET['code'],
            "scope" => $_GET['scope'],
            "context" => $_GET['context']
        ));
        //print_r($response);
        $data = array('access_token'=>$response->access_token,
                      'scope'=>$response->scope,
                      'user_id'=>$response->user->id,
                      'user_username'=>$response->user->username,
                      'user_email'=>$response->user->email,
                      'context'=>$response->context);
        $error = $connection->getLastError();             
        if(!empty($error)){
            print_r($error);
        }else{
            //print_r($data);
            //error_log(json_encode(array('code'=>$_GET['code'],'scope'=>$_GET['scope'],'context'=>$_GET['context'])));
            $payload = null;
            if($payload=$this->customerdao->contextExist(stripslashes($_GET['context']))){
                //error_log(json_encode(array('id'=>$payload->user_id,'email'=>$payload->user_email,'context'=>$payload->context)));
                //$this->clientValidateToPanel($user,$payload);
                $this->contextExist = true;//BOOLEAN CONTEXT EXIST
                $this->customerdao->updateToken($data,$payload);
            }else{
                $this->customerdao->insertToken($data);
            }
            
            $userdata = array(
                      'id'         => $data['user_id'],
                      'email'      => $data['user_email'],
                      'context'    => $data['context'],
                      'store_hash' => '',
                      'timestamp'  => ''
            );
            $user1 = $this->customerdao->validateUserToken($userdata);
            //get store information: domain, store name
            $storeInfo = $this->getStoreInformation(array('access_token'=>$data['access_token'],'context'=>$data['context']));
            //var_dump($storeInfo);
            $data_to_add  = array(
            'user_token_id' => $user1->user_token_id,
            'username'      => $user1->user_username,
            'password'      => $user1->access_token,
            'email'         => $user1->user_email,
            'context'       => $user1->context,
            'store'         => !empty($storeInfo['name'])?$storeInfo['name']:'',
            'store_url'     => !empty($storeInfo['domain'])?$storeInfo['domain']:''
            );
            //add user do table
            $this->add_user2($user,$data_to_add,$payload);
        }
    }
    public function add_user2($user,$user_data,$payload){//into panel bigcommerce
            $user_data1 = array('name'=>$user_data['username'],
                          'user_token_id'=>$user_data['user_token_id'],
                          'password'=>$user_data['password'],
                          'store'=>$user_data['store'],
                          'store_url'=>$user_data['store_url'],
                          'email'=>$user_data['email'],
                          'BIGCOMM_API_TOKEN'=>'',
                          'BIGCOMM_PATH'=>'',
                          'BIGCOMM_USERNAME'=>''
                          );
            $admin = new admin();
            if(!$this->contextExist){//BOOLEAN CONTEXT EXIST
                $user_login_id = $admin->admin_dao->setNewUser($user_data1);
                //create a webhook
                $this->createWebhook(array('access_token'=>$user_data['password'],
                                           'scope'=>'store/product/updated',
                                           'context'=>$user_data['context'],
                                           'destination'=>WEBHOOK_URL.'-'.$user_login_id,
                                           'user_login_id'=>$user_login_id
                                           ));
            }else{
                $user_login_id = $admin->admin_dao->updateUser($user_data1,$payload->user_login_id);
                /*$this->updateWebhook(array('access_token'=>$user_data['password'],
                                           'scope'=>'store/product/updated',
                                           'context'=>$user_data['context'],
                                           'destination'=>WEBHOOK_URL.'-'.$user_login_id,
                                           'user_login_id'=>$user_login_id
                                           ));*/
            }
            $user_data1['id'] = $user_login_id;
            $user_session_data = (object)$user_data1;
            $user->set_session_panel($user_session_data);
            //mailchimp subscribe
            $super = $admin->admin_dao->getSuperAdmin($this->superadmin_id);
            if(!empty($super->mailchimp_apikey) && !empty($super->mailchimp_web_id) && !empty($super->mailchimp_list_id)){
                $mailchimp = new \model\mailchimp($super->mailchimp_apikey);
                $mresp = $mailchimp->subscribeToList(array(
                    'id'                => $super->mailchimp_list_id,
                    'email'             => array('email'=>$user_data1['email'],'leid'=>$super->mailchimp_web_id),
                    'merge_vars'        => array('FNAME'=>$user_data1['username'], 'LNAME'=>''),
                    'double_optin'      => false,
                    'update_existing'   => true,
                    'replace_interests' => false,
                    'send_welcome'      => false
                ));
                if(!empty($mresp)){error_log(json_encode(array('user_login_id'=>$user_data1['id'],'mailchimp'=>$mresp)));}
            }
            //var_dump($user_session_data);
            $admin->view_admin(array('admin','install'));
    }
    public function clientUninstall(){
        $payload = Bigcommerce\Api\Client::verify($_GET['signed_payload'],CLIENT_SECRET);
        $user = array('id'        => $payload['user']['id'],
                      'email'     => $payload['user']['email'],
                      'store_hash'=> $payload['store_hash']
                      );
        if(!empty($payload) && isset($payload['user']['id'])){
            $this->customerdao->clientUninstall($user);
        }else{
            exit('payload out');
        }
    }
    public function insert(){
        //Array ( [email] => test@test.com [first_name] => miglio [last_name] => esaud [product_id] => 74 [product_stok] => 0 [subscribe] => Subscribe ) {"response":"insertado"}
        $bool = false;
        try{
            $user_login_id = $this->getUserId();//get id from user
            if($user_login_id){
                $bool = true;
            }
            if(!$bool){ throw new Exception('none to insert'); }
            //
            $customer = array();
            $product = array();
            $customer['first_name']   = isset($_POST['first_name'])?$_POST['first_name']:$_GET['first_name'];
            $customer['last_name']    = isset($_POST['last_name'])?$_POST['last_name']:$_GET['last_name'];
            $customer['email']        = isset($_POST['email'])?$_POST['email']:$_GET['email'];
            $product['product_id']    = isset($_POST['product_id'])?$_POST['product_id']:$_GET['product_id'];
            $product['product_stock'] = isset($_POST['product_stock'])?$_POST['product_stock']:$_GET['product_stock'];
            $product['product_title'] = isset($_POST['product_title'])?$_POST['product_title']:$_GET['product_title'];
            $product['option_sku']    = isset($_POST['option_sku'])?$_POST['option_sku']:(isset($_GET['option_sku'])&&$_GET['option_sku']!='undefined')?$_GET['option_sku']:'';
            $customer['date'] = 'NOW()';//DATE
            $val_customer = $this->customerdao->validateCustomer($customer,$user_login_id);
            if(!$val_customer){
                $customer_id = $this->customerdao->insertCustomer($customer,$user_login_id);
                $data = array('product_title'=>$product['product_title'],
                              'customer_id'=>$customer_id,
                              'product_id'=>$product['product_id'],
                              'option_sku'=>$product['option_sku'],
                              'sent'=>'n',
                              'date'=>'NOW()'//DATE
                              );
                $product['customer_id']=$customer_id;
                if(!$this->customerdao->validateProduct($product,$user_login_id)){
                    $this->customerdao->insertProduct($data,$user_login_id);
                }else{
                    $this->customerdao->updateProduct($data,$user_login_id);
                }
                $msg = 'We will email you when this item is back in stock';
                //include 'view/customer_popup.php';
            }else{
                $customer_id = $this->customerdao->getCustomerIdByEmail($customer,$user_login_id);
                $this->customerdao->updateCustomer($customer,$user_login_id);
                $data = array('product_title'=>$product['product_title'],
                              'customer_id'=>$customer_id,
                              'product_id'=>$product['product_id'],
                              'option_sku'=>$product['option_sku'],
                              'sent'=>'n',
                              'date'=>'NOW()'//DATE
                              );
                $product['customer_id']=$customer_id;
                if(!$this->customerdao->validateProduct($product,$user_login_id)){
                    $this->customerdao->insertProduct($data,$user_login_id);
                    //echo ' -22';
                }else{
                    $this->customerdao->updateProduct($data,$user_login_id);
                    //echo '33';
                }
                $msg = 'We will email you when this item is back in stock';
                //include 'view/customer_popup.php';
            }
        }catch(Exception $e){
            //none
            $msg = 'none to insert';
        }
        $json = 'jsonp_callback(';
        $json .= json_encode(array('bool'=>$bool,'msg'=>$msg, 'usid'=>$user_login_id));
        $json .= ');';
        echo $json;
        //print_r($_POST);
    }
    private function getUserId(){
        $search    = array('http://','https://','www.');
        $store_url = (!empty($_GET['store_url']))?str_replace($search,'',$_GET['store_url']):'';
        $data      = array('store_url'=>$store_url);
        $user_id   = $this->customerdao->getUserId($data);
        /**
        $json = 'jsonp_callback(';
        $json .= json_encode(array('bool'=>$bool,'uri'=>$store_url,'user_id'=>$user_id));
        $json .= ');';
        echo $json;
        **/
        return ($user_id)?$user_id:false;
    }
    private function createWebhook($user_data = null){
        $resource = '/v2/hooks';
        $tokenUrl = "https://api.bigcommerce.com/".$user_data['context'].$resource;
        $connection = null;
        $connection = new Bigcommerce\Api\Connection();      
        $connection->setCipher('rsa_rc4_128_sha');//rsa_rc4_128_sha | 'RC4-SHA'
        $connection->verifyPeer(false);
        $connection->addHeader('X-Auth-Client', CLIENT_ID);
        $connection->addHeader('X-Auth-Token', $user_data['access_token']); 
        $response = $connection->post($tokenUrl, array(
            "scope" => $user_data['scope'],
            "destination" => $user_data['destination']
        ));
        //add to table
        $webhook_data = array('user_login_id'=>$user_data['user_login_id'],
                              'webhook_id'=>$response->id,
                              'scope'=>$response->scope,
                              'destination'=>$response->destination,
                              'is_active'=>$response->is_active
                              );
        $this->customerdao->webhookInsert($webhook_data);
    }
    
    private function updateWebhook($user_data){
        $webhook = $this->customerdao->getWebhookData($user_data['user_login_id']);
        
        $resource = '/v2/hooks/'.$webhook->webhook_id;
        $tokenUrl = "https://api.bigcommerce.com/".$user_data['context'].$resource;
        $connection = null;
        $connection = new Bigcommerce\Api\Connection();      
        $connection->setCipher('rsa_rc4_128_sha');//rsa_rc4_128_sha | 'RC4-SHA'
        $connection->verifyPeer(false);
        $connection->addHeader('X-Auth-Client', CLIENT_ID);
        $connection->addHeader('X-Auth-Token', $user_data['access_token']); 
        $response = $connection->put($tokenUrl, array(
            "scope" => $user_data['scope'],
            "destination" => $user_data['destination']
        ));
        //add to table
        $webhook_data = array('user_login_id'=>$user_data['user_login_id'],
                              'webhook_id'=>$response->id,
                              'scope'=>$response->scope,
                              'destination'=>$response->destination,
                              'is_active'=>$response->is_active
                              );
        $this->customerdao->webhookUpdate($webhook_data);
    }
    private function deleteWebhook($id=null){
        $user_data = array('access_token'=>'g3brig44hchx27pnrcfjirl3c0o1vkm',
                           'scope'=>'store/product/updated',
                           'context'=>'stores/g1wmq',
                           'destination'=>'https://apolomultimedia.us/bigcomm_app/cronjob-webhook',
                           'hook_id' => $id
                           );
        $resource = '/v2/hooks';
        $tokenUrl = "https://api.bigcommerce.com/".$user_data['context'].$resource.'/'.$user_data['hook_id'];
        $connection = new Bigcommerce\Api\Connection();
        $connection->setCipher('rsa_rc4_128_sha');
        $connection->verifyPeer(false);
        $connection->addHeader('X-Auth-Client', CLIENT_ID);
        $connection->addHeader('X-Auth-Token', $user_data['access_token']); 
        //$connection->addHeader('X-Custom-Auth-Header', $user_data['access_token']);
        $response = $connection->delete($tokenUrl);
        var_dump($response);
    }
    private function getWebhooks(){//working
        $user_data = array('access_token'=>'g3brig44hchx27pnrcfjirl3c0o1vkm',
                           'context'=>'stores/g1wmq'
                           );
        $resource = '/v2/hooks';
        $tokenUrl = "https://api.bigcommerce.com/".$user_data['context'].$resource;
        $connection = new Bigcommerce\Api\Connection();
        $connection->setCipher('rsa_rc4_128_sha');
        $connection->verifyPeer(false);
        $connection->addHeader('X-Auth-Client', CLIENT_ID);
        $connection->addHeader('X-Auth-Token', $user_data['access_token']); 
        $response = $connection->get($tokenUrl);
        //$error = $connection->getLastError();
        //var_dump($error);
        echo CLIENT_ID;
        print_r($response);
    }
    private function getStoreInformation($user_data = null){
        /*$user_data = array('access_token'=>'quxgli39a11sgbkjiujfyr7vckepwiy',
                           'context'=>'stores/qq6db7r'
                           );*/
        $resource = '/v2/store';
        $tokenUrl = "https://api.bigcommerce.com/".$user_data['context'].$resource;
        $connection = null;
        $connection = new Bigcommerce\Api\Connection();
        $connection->setCipher('rsa_rc4_128_sha');
        $connection->verifyPeer(false);
        $connection->addHeader('X-Auth-Client', CLIENT_ID);
        $connection->addHeader('X-Auth-Token', $user_data['access_token']); 
        $response = $connection->get($tokenUrl);
        //var_dump($response);
        //return $response;
        //echo '<br /><br />';
        return array('name'=>$response->name,'domain'=>$response->domain);
    }
    private function checkContext($n = 1){
        $bool = false;
        switch($n){
            case 1:
                if(empty($_GET['code']) || empty($_GET['scope']) || empty($_GET['context'])){
                    $bool = true;
                }
            break;
            default:
            break;
        }
        if($bool){
            include 'view/logo.php';
            exit();
        }
    }
}
?>
<?php
use Bigcommerce\Api\Client;
use model\mailchimp;
use model\template;
class cronjob{
    private $orders = null;
    private $con=null;
    private $cronjob_dao;
    const MAILER_DEFAULT = 'custom_mail';//mailchimp:1, default:0
    const MAILER_MAILCHIMP = 'mailchimp';//mailchimp:1, default:0
    private $chooseMailer = null;
    private $mailchimp_dao = null;
    private $mailchimp = null;
    private $productSku = array();
    const LIMIT = 200;
    const INVENTORY_TRACK = 'sku';
    const MAX_COUNT_OPTIONS = 2;
    const LIMIT_TIME_TO_MAILER = '01:00:00';
    const CRONJOB_TABLE = 'cronjob';
    const CIPHER = 'rsa_rc4_128_sha';
    public function __construct(){
        $this->con = Connection::cnx();
        $this->cronjob_dao = new cronjob_dao();
        $this->mailchimp_dao = new mailchimp_dao();
    }
    public function view_cronjob($arr){
        $a = !empty($arr[1])?$arr[1]:'';
        switch($a){
            case 'sendmail':
                $this->cronjob_sendMails();
            break;
            case 'product':
                header("HTTP/1.1 200");
                if(!empty($arr[2]) && !empty($arr[4])){
                    $user = $this->cronjob_dao->getUserInfo($arr[4]);
                    $this->validateStockInBigCommercePublic($arr[2],$user);
                }else{
                    echo 'any is empty';
                }
            break;
            case 'testmail':
                $this->sendMail(null);
            break;
            case 'webhook':
                //$user_login_id = !empty($arr[2])?$arr[2]:false;
                $this->webhook();
            break;
            case 'webhooks':
                $user_id = $arr[2];
                if(empty($user_id))exit('no user id');
                $user = $this->cronjob_dao->getUserInfo($user_id);
                $this->getWebhooks($user);
            break;
            case 'wdelete':
                $user_id = $arr[2];
                $webhook_id = $arr[3];
                if(empty($user_id))exit('no user id');
                $user = $this->cronjob_dao->getUserInfo($user_id);
                $this->webhookDelete($webhook_id,$user);
            break;
            case 'test':
                $product_id = 75;
                $option_sku = 'SKU-BBF7F509';
                $user_data = (object)array('context'=>'stores/qq6db7r','access_token'=>'435exjbeuwxdtx05fhijdb4ywxwdop8');
                $product = $this->bigcommerceCnx('get', '/v2/products/'.$product_id.'/skus?sku='.$option_sku, $user_data);
                echo 'inventory: '.$product[0]->inventory_level;
                //var_dump($product);
            break;
            default:
                echo 'error default';
            break;
        }
    }
    //from bigcommerce webhook
    private function webhook(){
            $this->cronjob_sendMails();
    }
    private function client_config($user){//Client class is only for private
        Client::configure(array(
			'store_url' => $user->BIGCOMM_PATH,
			'username' => $user->BIGCOMM_USERNAME,
			'api_key' => $user->BIGCOMM_API_TOKEN,
		));
        Client::setCipher('rsa_rc4_128_sha');//rsa_rc4_128_sha, RC4-SHA, RSA_RC4_128_SHA
        Client::verifyPeer(false);
    }
    public function cronjob_sendMails(){
        header("HTTP/1.1 200");
        $this->chooseMailer = self::MAILER_DEFAULT;
        if(!$this->cronjob_dao->checkToFollow()){//check to continue
            exit(' -no more mails to send- ');
        }
        //$idToBegin = $this->productIdToBegin();
        $prod_hook = $this->getContents();
        $idToBegin = 0;
        if(empty($prod_hook->producer)){
            return true;
        }
        $user_login_id = $this->cronjob_dao->getIdByContext($prod_hook->producer);
        if(!$user_login_id or $user_login_id==0){
            return true;
        }
        
        if($user_login_id !=  false && is_numeric($user_login_id)){
            if(!$this->checkPaypal($user_login_id)){
                exit($user_login_id.' account expired');
            }
            
            $products = $this->cronjob_dao->getProducts($idToBegin,$user_login_id,$prod_hook->data->id);
        }else{
            return true;
            //$products = $this->cronjob_dao->getProducts($idToBegin, false,false);
        }
        //$LastProductId = $this->cronjob_dao->getLastProductId();//not used
        if($this->chooseMailer == self::MAILER_DEFAULT && $products->num_rows > 0){//custom_mail
            $count = 1;
            while($resp = $products->fetch_object()){
                $this->verifyCounter();//verify
                $product_id = $resp->product_id;
                $option_sku = $resp->option_sku;
                $table_id   = $resp->id;//id from table nmae
                $user_id    = $resp->user_login_id;
                $user       = $this->cronjob_dao->getUserInfo($user_id);
                $this->mailchimp_dao->setUserId($user_id);
                //$this->client_config($user);
                echo '<br />--------------------------------';
                $product  = $this->validateStockInBigCommercePublic($product_id,$option_sku,$user);
                //var_dump($user);
                if($product){
                    $array = array('id'=>$resp->customer_id,'first_name'=>ucfirst($resp->first_name),'last_name'=>ucfirst($resp->last_name),'email'=>$resp->email,'product_table_id'=>$table_id,'product'=>$product,'user'=>$user,'option_sku'=>$option_sku);
                    //print_r($array);exit;
                    $resp_cus = $this->customSendMail($array);//SEND MAIL TO SUBSCRIBERS
                    //echo '<br />'.$product_id. ' '.$product->name;
                    //set counter ++
                    if($resp_cus){
                        $this->cronjob_dao->setCounter(array('table_product_id'=>$table_id));
                    }
                    $count++;
                }else{
                    echo '<br />no sent '.$table_id,' p.id: '.$product_id;
                    //$this->noCompleted($table_id,1);
                }
            }
        }
    }
    private function verifyCounter(){
        //verify counter
        $COUNTER = $this->cronjob_dao->getCounter();
        //var_dump('counter:'.$COUNTER);
        if($COUNTER >= self::LIMIT){
            if($this->cronjob_dao->limitCounterTime(self::LIMIT_TIME_TO_MAILER)){
                echo 'reach time limit, erase table';
                $this->cronjob_dao->truncate_tables(self::CRONJOB_TABLE);
            }else{
                //echo 'not reach time limit';
                exit('<br />not yet reached time limit, limit of send mail reached, wait next cronjob');
            }
        }
    }
    public function validateStockInBigCommercePublic($product_id,$option_sku,$user_data){
        $bool = false;
        try{
            if(!empty($option_sku) && $option_sku != 'undefined'){
                $product = $this->productInventorySku($bool,$user_data,$product_id,$option_sku);
            }else{
                $product = $this->productInventory($bool,$user_data,$product_id);
            }
        }catch(Exception $ex){
            //echo $ex->getMessage();
            $bool = false;
        }
        return ($bool)?$product:$bool;//CAMBIAR A $bool
    }
    private function productInventory(&$bool,$user_data,$product_id){
        $product = $this->bigcommerceCnx('get', '/v2/products/'.$product_id, $user_data);
        //print_r($product);
        if($product){
            /*if($product->inventory_tracking == self::INVENTORY_TRACK){
                $bool = false;
                //echo '<br />track by '.self::INVENTORY_TRACK;
            }else */
            if($product->inventory_level > 0){
                $bool = true;
                //echo '<br />in stock '.$product->inventory_level.' p.id: '.$product_id;
            }else{
                //echo '<br />no stock'.$product->inventory_level.' p.id: '.$product_id;
                $bool = false;
            }
            return $product;
        }else{
            echo 'product doesn\'t exist';
        }
    }
    private function productInventorySku(&$bool, $user_data, $product_id, $option_sku){
        //error_log('pid: '.$product_id.' sku: '.$option_sku);
        $product = false;
        $productSku = $this->bigcommerceCnx('get', '/v2/products/'.$product_id.'/skus?sku='.$option_sku, $user_data);
        $productSku = $productSku[0];
        if($productSku){
            /*if($product->inventory_tracking == self::INVENTORY_TRACK){
                $bool = false;
                //echo '<br />track by '.self::INVENTORY_TRACK;
            }else */
            if($productSku->inventory_level > 0){
                $bool = true;
                //error_log(json_encode(array('sku'=>$option_sku,'options'=>$productSku->options)));
                $this->optionValues($productSku->options,$product_id,$option_sku,$user_data);
                $product = $this->bigcommerceCnx('get', '/v2/products/'.$product_id, $user_data);
                $options = (empty($this->productSku['options']))?'':'<br />'.$this->productSku['options'];//include optios if it have
                $product->options = $options;//set options
            }else{
                $bool = false;
            }
            return $product;
        }else{
            echo 'product doesn\'t exist';
        }
    }
    
    private function optionValues($options,$product_id,$option_sku,$user_data){
        $this->productSku['product_id'] = $product_id;
        $this->productSku['option_sku'] = $option_sku;
        $this->productSku['options']    = '';
        for($i = 0 ; $i < count($options); $i++){  
            if($i >= self::MAX_COUNT_OPTIONS){
                return false;
            }
            $option = $this->bigcommerceCnx('get', '/v2/products/'.$product_id.'/options/'.$options[$i]->product_option_id, $user_data);//option
            //$option->display_name;
            //$source = '/v2/products/'.$data['product_id'].'/options/'.$data['option_id'];
            $values = $this->bigcommerceCnx('get', '/v2/options/'.$option->option_id.'/values', $user_data);//option values
            //$source = '/v2/options/'.$data['option_id'].'/values';
            foreach($values as $k=>$v){
                if((int)$v->id == (int)$options[$i]->option_value_id){
                    $this->productSku['options'] .= '<p>'.$option->display_name.': '.$v->label.'</p>';
                }
            }
        }
    }
    
    public function validateStockInBigCommerce($product_id){//for private
        $bool = false;
        try{
            $product = Client::getProduct($product_id);
            if($product){
                if($product->inventory_level > 0){
                    $bool = true;
                    echo '<br />in stock '.$product->inventory_level.' p.id: '.$product_id;
                }else{
                    echo '<br />no stock'.$product->inventory_level.' p.id: '.$product_id;
                    $bool = false;
                }
                //var_dump($product);
            }else{
                echo 'product doesn\'t exist';
            }
        }catch(Exception $ex){
            //echo $ex->getMessage();
            $bool = false;
        }
        return ($bool)?$product:$bool;//CAMBIAR A $bool
    }
    public function getProducts(){
         $product = Client::getProducts();
        print_r($product);
        exit();
        $products_counter = count($products);
        //echo 'quantity: '.$size_products;
        var_dump($products);
        //var_dump($products);
        //echo '--------'.$products[0]->name;
        for($i = 0; $i < $products_counter; $i++){
            echo '<br />'.$products[$i]->name;
        }
        /*foreach($products as $product) {
            echo '<br />'.$product->id;
            echo '<br />'.$product->name;
            echo '<br />'.$product->price;
        }*/
    }
    private function sendMail($customer){
        //print_r($customer);exit();
        $mail = new mail();
        $user    = $customer['user'];
        $product = $customer['product'];
        //preapare mail to send
        $subject = $product->name.' inventory have been updated';
        $body  = 'Name: '        .$product->name."<br />\n";
        $body .= 'Quantity: '    .$product->inventory_level."<br />\n";
        $body .= 'Price: '       .round($product->price,2)."<br />\n";
        $body .= 'Url: <a href="'.BIGCOMM_PATH.$product->custom_url.'" target="blank">'.BIGCOMM_PATH.$product->custom_url.'</a>'."<br />\n";
        $body .= '';
        //mig1098@hotmail.com
        try{
            $mail->sendMail(array(  
                                    'From'      => $user->email,
                                    'FromName'  => $user->store,
                                    'AddAddress'=> array($customer['email'],'<'.$customer['email'].'>'),
                                    'AddReplyTo'=> array($user->store,$user->email),
                                    'Subject'   => $subject,
                                    'Body'      => $body
                                  ));
            $resp = $this->cronjob_dao->updateSent($customer['product_table_id'],$customer['option_sku'],'y');
        }catch(Exception $ex){
            echo $ex->getMessage().'-'.$ex->getFile().' [on line:'.$ex->getLine().']';//$ex->getMessage().'-'.$ex->getLine().'-'.$ex->getFile()
            return false;
            //exit('-- stopped process --');
        }
        return true;
    }
    private function customSendMail($customer){
        //print_r($customer);exit();
        $mail = new mail();
        //preapare mail to send
        $getData = $this->mailchimp_dao->getCustomMail();
        $subject = $getData->subject;
        $body  = $getData->body;
        //mig1098@hotmail.com
        $this->processVariables($customer,$subject,$body);
        $template['custom_mail'] = array('from_email'=> $getData->from_email,
                                     'from_name' => $getData->from_name,
                                     'subject'   => $subject,
                                     'body'      => $body,
                                     'header_image' => $getData->header_image,
                                     'header_bg' => $getData->header_bg,
                                     'footer'    => $getData->footer,
                                     'footer_bg' => $getData->footer_bg
                                     );
        $bodyTemplate = new template();
        $bodyT = $bodyTemplate->getTemplate($template);
        $arraySend = array(  
                            'From'      => $getData->from_email,
                            'FromName'  => $getData->from_name,
                            'AddAddress'=> array($customer['email'],'<'.$customer['email'].'>'),
                            'AddReplyTo'=> array($getData->from_name,$getData->from_email),
                            'Subject'   => $subject,
                            'Body'      => $bodyT
                           );
        try{
            $mail->sendMail($arraySend);
            $resp = $this->cronjob_dao->updateSent($customer['product_table_id'],$customer['option_sku'],'y');
        }catch(Exception $ex){
            echo $ex->getMessage().'-'.$ex->getFile().' [on line:'.$ex->getLine().']';//$ex->getMessage().'-'.$ex->getLine().'-'.$ex->getFile()
            return false;
            //exit('-- stopped process --');
        }
        return true;
    }
    
    private function getWebhooks($user_data){//working
        $response = $this->bigcommerceCnx('get','/v2/hooks',$user_data);
        print_r($response);
    }
    
    private function webhookUpdate(){
        
    }
    
    private function webhookDelete($webhook_id,$user_data){
        $response = $this->bigcommerceCnx('delete','/v2/hooks/'.$webhook_id,$user_data);
        print_r($response);
    }
    
    private function bigcommerceCnx($method,$resource,$user_data){
        $tokenUrl = "https://api.bigcommerce.com/".$user_data->context.$resource;
        $connection = new Bigcommerce\Api\Connection();
        $connection->setCipher(self::CIPHER);
        $connection->verifyPeer(false);
        $connection->addHeader('X-Auth-Client', CLIENT_ID);
        $connection->addHeader('X-Auth-Token', $user_data->access_token); 
        if($method == 'get'){
            return $connection->get($tokenUrl);
        }else if($method == 'post'){
            //
        }else if($method == 'put'){
            //
        }else if($method == 'delete'){
            return $connection->delete($tokenUrl);
        }
        
    }
    /**
         * 
         * 
         * 
         * 
         * 
         * Build process by mailchimp api
         * 
         * 
         * 
         * 
         * 
         * 
         */
    public function sendMailFromMailChimp($customer){
        $this->mailchimp = new mailchimp();
        print_r($this->mailchimp->listCreate(array('id'=>'product1_id','group_name'=>'product1')));
        //print_r($this->mailchimp->getLists());
    }
    private function processVariables($customer,&$subject,&$body){//by reference
        $this->mailchimp = new mailchimp();
        $this->mailchimp->setBIGCOMM_PATH($customer['user']->store_url);
        $this->mailchimp->processVariables($customer,$subject,$body);
    }
    private function checkPaypal($user_login_id){
        /*$data = array();
        $userInfo = $this->cronjob_dao->getUserInfo2($user_login_id);
        $paypal = $this->cronjob_dao->getPaypal();
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
                //$subs = '';
                $data['message'] = 'Your subscription has expired';
            }else{
                //echo 'follow';
                //$data['message'] = 'Your subscription is about to expire, renew today!';
            }
        }*/
        return true;
    }
    public function noCompleted($table_product_id,$n){
        $msg = '';
        $flag = 1;
        switch($n){
            case 1:
                $msg = 'id table order inserted(failed): ';
            break;
            case 2:
                $msg = 'id table order inserted(LIMIT): ';
            break;
        }
        $Sql="INSERT INTO cronjob(table_product_id,flag,date) values('".$table_product_id."','1',NOW())";
        mysqli_query($this->con, $Sql);
        echo $msg.$table_product_id;
        exit();
    }
    public function productIdToBegin(){
        $Sql = "SELECT table_product_id FROM cronjob ORDER BY id DESC LIMIT 1";
        $Sql = mysqli_query($this->con, $Sql);
        $Sql = $Sql->fetch_object();
        if($Sql){
            $id = $Sql->table_product_id;
        }else{
            $id = 0;
        }
        return $id;
    }
    
    private function getContents(){
        $webhookContent = "";
        $webhookContent = file_get_contents("php://input");
        if($webhookContent){
            error_log($webhookContent);
            $data = json_decode($webhookContent);
            return $data;
        }
        return false;
    }
    
    /**
     * 
     * 
     * @note funciones no work 
     * 
     * 
     */
    public function getLasIdTableOrders(){
        $Sql="SELECT id FROM orders ORDER BY id DESC LIMIT 1";
        $ultimo_sku = mysqli_query($this->con,$Sql)or die(mysqli_error($this->con));
        $ultimo_sku = $ultimo_sku->fetch_object();
        if(!$ultimo_sku){
            $resp=0;
        }else{
            $resp=$ultimo_sku->id;
        }  
        return $resp; 
    }
}

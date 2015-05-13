<?php
class customers extends ShopifyClient{
    public $LIMIT_ID=250;
    
    public function __construct($shop_domain, $token, $api_key, $secret){
        parent::__construct($shop_domain, $token, $api_key, $secret);
    }
    
    //COLLECTION
    public function getAllCustomers(){
        return parent::call('GET', '/admin/customers.json');
    }
    
    public function getCustomerById($id){
        return parent::call('GET', '/admin/customers/'.$id.'.json');
    }
    
    public function createCustomer($arrCustomer){
        return parent::call('POST', '/admin/customers.json',$arrCustomer);
    }
    
    public function editCustomer($arrCustomer){
        return parent::call('GET', '/admin/customers/'.$arrCustomer['customer']['id'].'.json',$arrCustomer);
    }
    
    public function getLastCustomerCreated(){
        return parent::call('GET', '/admin/customers.json?limit=1');//array('published_status'=>'published','limit'=>'200')
    }
    
    public function updateCustomerCode($arrCustomer){
        return parent::call('PUT', '/admin/customers/'.$arrCustomer['customer']['id'].'.json',$arrCustomer);
    }

}

/*****SHOPIFY SDK******/
/*
contact: https://app.shopify.com/services/partners/auth/login 
user : contact@apolomultimedia.com 
pass : 123456

define('SHOPIFY_API_KEY','bbfc3d9afb34c06f4ce30079ac77f64f');
define('SHOPIFY_SECRET','a05e3be0138e4e9d7ce99d44c97dac9b');
define('SHOPIFY_CODE','d1a3cce34ec7ad091b4a0d4273d12ed1');
define('SHOP','prueba2-11.myshopify.com');
define('SHOPIFY_TOKEN','6bfeb95088836fcbeb8c138222c85834');

callback url
http://localhost/shopify

shared secret
7dc00089d55f1df871a7fb8d57cb56d3


http://aphroditefantasies.com/ 
sales1@apolomultimedia.com 
123456

subir productos 
500 unidades -> 15 minutos


//////otro/////
http://ws.honeysplace.com/ws/api.php
http://www.sextoydistributing.com/
*/

?>
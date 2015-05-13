<?php
class products extends ShopifyClient{
    public $LIMIT_ID=250;
    //para una app privada solo se necesita el shop domain
    public function __construct($shop_domain, $token, $api_key, $secret){
        parent::__construct($shop_domain, $token, $api_key, $secret);
    }
    public function getAllProducts(){
        return parent::call('GET', '/admin/products.json', array('published_status'=>'published','limit'=>'200'));//
    }
    public function getAllProductsSinceId($id){
        return parent::call('GET', '/admin/products.json?since_id='.$id, array('published_status'=>'published','limit'=>'250'));//
    }
    public function getAllProductsId($page){
        return parent::call('GET', '/admin/products.json?fields=id,variants,title',array('published_status'=>'any','page'=>$page,'limit'=>$this->LIMIT_ID));//, array('published_status'=>'any','limit'=>self::LIMIT_ID)
    }
    public function getAllProductsIdToDelete($page){
        return parent::call('GET', '/admin/products.json?fields=id,title',array('published_status'=>'any','page'=>$page,'limit'=>$this->LIMIT_ID));//, array('published_status'=>'any','limit'=>self::LIMIT_ID)
    }
    public function getAllCountProducts(){
        return parent::call('GET', '/admin/products/count.json');//
    }
    //PRODUCT
    public function getProductById($id){
        return parent::call('GET', '/admin/products/'.$id.'.json');//
    }
    public function searchProductBySku($sku){
        return parent::call('GET', '/admin/products/search.json?query=sku:'.$sku);//
    }
    public function createNewProduct($arrProduct){
        //array("product"=>array("title"=>"Burton Custom Freestlye 151","body_html"=>"qwer","vendor"=>"ddqwer2d","product_type"=>"Snowboard"))
        return parent::call('POST', '/admin/products.json',$arrProduct);
    }
    public function deleteProduct($id){
        return parent::call('DELETE ', '/admin/products/'.$id.'.json');
    }
    public function updateProduct($arrProduct){
        return parent::call('PUT', '/admin/products/'.$arrProduct["product"]["id"].'.json',$arrProduct);
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
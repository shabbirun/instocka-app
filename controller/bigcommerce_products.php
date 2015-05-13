<?php
use Bigcommerce\Api\Client;

class bigcommerce_products{
    private $products = null;
    public function __construct(){
        
    }
    
    public function view_products($arr){
        $a = (!empty($arr[1]))?$arr[1]:'';
        switch($a){
            case 'all':
                $this->getAllProducts();
            break;
            
            case 'insert':
                $this->createProducts();
            break;
            
            case 'test':
                echo 'hi test';
            break;
            
            case 'categories':
                $this->categories();
            break;
            
            default:
                $this->getAllProducts();
            break;
        }
    }
    
    public function getAllProducts(){
        /*echo '<div style="margin:auto;width:500px;">';
        echo 'APOLOMULTIMEDIA: '.BASE_URL.'<br />';
        echo 'BIGCOMM_API_TOKEN: '.BIGCOMM_API_TOKEN.'<br />';
        echo 'BIGCOMM_PATH: '.BIGCOMM_PATH.'<br />';
        echo 'DB_DATABASE: '.DB_DATABASE.'<br />';
        echo 'DB_SERVER_USERNAME: '.DB_SERVER_USERNAME.'<br />';
        echo 'DB_SERVER_PASSWORD: '.DB_SERVER_PASSWORD.'<br /><hr />';
        echo 'PRODUCTS STORE: <br /><hr />';
        echo '</div>';*/
        $this->testApiPathConfiguration();
    }
    
    public function createProduct(){
        
    }
    
    public function updateProduct(){
        
    }
    
    public function getProductById($id){
        
    }
    
    public function apiconfiguration(){
        Client::configure(array(
			'store_url' => BIGCOMM_PATH,
			'username' => BIGCOMM_USERNAME,
			'api_key' => BIGCOMM_API_TOKEN,
		));
        
        Client::setCipher('RC4-SHA');//rsa_rc4_128_sha, RC4-SHA, RSA_RC4_128_SHA
        Client::verifyPeer(false);
    }
    
    
    
    public function testApiPathConfiguration()
	{
	    try{
    		Client::configure(array(
    			'store_url' => BIGCOMM_PATH,
    			'username' => BIGCOMM_USERNAME,
    			'api_key' => BIGCOMM_API_TOKEN,
    		));
            
            Client::setCipher('RC4-SHA');//rsa_rc4_128_sha, RC4-SHA, RSA_RC4_128_SHA
            Client::verifyPeer(false);
        
        
    		//$this->assertEquals(BIGCOMM_PATH.'/api/v2', Client::$api_path);
            $ping = Client::getTime();
            if ($ping) echo $ping->format('H:i:s');
            
            $count = Client::getProductsCount();
    
            echo 'total products: '.$count;
            
            $products = Client::getProducts();       
            var_dump($products);
        
        }catch(NetworkError $ex){
            echo $ex;
            //echo ' NetworkError';
	    }catch(Exception $ex1){
	        echo $ex1;
            //echo ' Exception';
	    }
        /*foreach($products as $product) {
            echo $product->name;
            echo $product->price;
        }*/
                
	}
    
    public function categories(){
        Client::configure(array(
    			'store_url' => BIGCOMM_PATH,
    			'username' => BIGCOMM_USERNAME,
    			'api_key' => BIGCOMM_API_TOKEN,
    		));
            
            Client::setCipher('RC4-SHA');//rsa_rc4_128_sha, RC4-SHA, RSA_RC4_128_SHA
            Client::verifyPeer(false);
            $cat = Client::getCategories();
            var_dump($cat);
            $count = Client::getCategoriesCount();
            echo '<br />count:<br />';
            var_dump($count);
    }
    
    
    
}
?>
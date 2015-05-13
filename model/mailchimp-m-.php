<?php
namespace model;
 
use Drewm\MailChimp as ApiMailchimp;

class mailchimp{
    private $BIGCOMM_PATH = null;
    
    public $ApiMailchimp = null;
    
    public function __construct($api_key = null){
            $this->ApiMailchimp = new ApiMailchimp($api_key);        
    }   
    
    public function setBIGCOMM_PATH($value){
        $this->BIGCOMM_PATH = $value;
    }
    
    public function listCreate($groupAdd){
        return $this->ApiMailchimp->call('/lists/interest-group-add',$groupAdd);
    }
     
    public function getLists(){
        return $this->ApiMailchimp->call('lists/list');
    }
    
    public function getListClientsByListId($list_id){
        return $this->ApiMailchimp->call('lists/clients',array('id'=>$list_id));
    }
    
    public function getListClientsByListMembers($list_id){
        return $this->ApiMailchimp->call('lists/members',array('id'=>$list_id));
    }
    
    public function subscribeToList($subscriber){
        return $this->ApiMailchimp->call('lists/subscribe',$subscriber);
    }
    
    public function getCamapigns(){
        return $this->ApiMailchimp->call('campaigns/list');
    }
    
    public function getTemplates(){
        //solo se muestran los templates que crea uno mismo (opcion en mailchimp: code your own))
        return $this->ApiMailchimp->call('templates/list');
    }
    
    public function getTemplatesOption($option){
        return $this->ApiMailchimp->call('templates/list',$option);
    }
    
    /**
     * Data format
     **/
    public function getListArrayFormat(){//for options select
        $lists = $this->getLists();
        $array = array();
        for($i = 0; $i < count($lists['data']); $i++){
            $array[] = array('id'=>$lists['data'][$i]['id'],'web_id'=>$lists['data'][$i]['web_id'],'name'=>$lists['data'][$i]['name']);
        }
        return $array;
    }
    
    public function processVariables($customer,&$subject,&$body){//by reference

        $user    = $customer['user'];//user info - not used
        $product = $customer['product'];
        
        $vars        = array('{{product_name}}',
                             '{{product_inventory_level}}',
                             '{{product_price}}',
                             '{{product_url}}',
                             '{{subscriber_first_name}}',
                             '{{subscriber_last_name}}',
                             '{{subscriber_email}}'
                             );
        $var_replace = array($product->name,
                             $product->inventory_level,
                             round($product->price,2),
                             '<a href="'.$this->BIGCOMM_PATH.$product->custom_url.'" target="blank">'.$this->BIGCOMM_PATH.$product->custom_url.'</a>',
                             $customer['first_name'],
                             $customer['last_name'],
                             $customer['email']
                             );
        $subject = str_replace($vars,$var_replace,$subject);
        $body    = (str_replace($vars,$var_replace,$body));
    }
}

?>
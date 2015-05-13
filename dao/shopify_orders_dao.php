<?php
class shopify_orders_dao{
    private $con=null;
    public function __construct(){
        $this->con = Connection::cnx();
    }
    
    public function insert($shopify_order){
        //discount_codes -> hay que validar con un if
        $Sql="INSERT INTO orders(
                                 customer_first_name,
                                 customer_last_name,
                                 customer_email,
                                 browser_ip,
                                 created_at,
                                 discount_codes,
                                 email,
                                 financial_status,
                                 note,
                                 gateway,
                                 referring_site,
                                 subtotal_price,
                                 tags,
                                 total_tax,
                                 total_price,
                                 total_discounts,
                                 total_weight,
                                 billing_first_name,
                                 billing_last_name,
                                 billing_company,
                                 billing_address1,
                                 billing_phone,
                                 billing_city,
                                 billing_province,
                                 billing_country,
                                 billing_zip,
                                 shipping_first_name,
                                 shipping_last_name,
                                 shipping_address1,
                                 shipping_phone,
                                 shipping_city,
                                 shipping_province,
                                 shipping_country,
                                 shipping_zip
                                 ) values(
                                 '".$shopify_order['customer']['first_name']."',
                                 '".$shopify_order['customer']['last_name']."',
                                 '".$shopify_order['customer']['email']."',
                                 '".$shopify_order['browser_ip']."',
                                 '".$shopify_order['created_at']."',
                                 '".$shopify_order['discount_codes']."',
                                 '".$shopify_order['email']."',
                                 '".$shopify_order['financial_status']."',
                                 '".$shopify_order['note']."',
                                 '".$shopify_order['gateway']."',
                                 '".$shopify_order['referring_site']."',
                                 '".$shopify_order['subtotal_price']."',
                                 '".$shopify_order['tags']."',
                                 '".$shopify_order['total_tax']."',
                                 '".$shopify_order['total_price']."',
                                 '".$shopify_order['total_discounts']."',
                                 '".$shopify_order['total_weight']."',
                                 '".$shopify_order['billing_address']['first_name']."',
                                 '".$shopify_order['billing_address']['last_name']."',
                                 '".$shopify_order['billing_address']['company']."',
                                 '".$shopify_order['billing_address']['address1']."',
                                 '".$shopify_order['billing_address']['phone']."',
                                 '".$shopify_order['billing_address']['city']."',
                                 '".$shopify_order['billing_address']['province']."',
                                 '".$shopify_order['billing_address']['country']."',
                                 '".$shopify_order['billing_address']['zip']."',
                                 '".$shopify_order['shipping_address']['first_name']."',
                                 '".$shopify_order['shipping_address']['last_name']."',
                                 '".$shopify_order['shipping_address']['address1']."',
                                 '".$shopify_order['shipping_address']['phone']."',
                                 '".$shopify_order['shipping_address']['city']."',
                                 '".$shopify_order['shipping_address']['province']."',
                                 '".$shopify_order['shipping_address']['country']."',
                                 '".$shopify_order['shipping_address']['zip']."'
                                 ) ";
        
        mysqli_query($this->con,$Sql)or die(mysqli_error($this->con));
        $id = mysqli_insert_id($this->con);
        //echo 'id order: '.$id.'<br />';
        
        if(isset($shopify_order['fulfillments'])){
            $this->insertFulfillments($id,$shopify_order['fulfillments']);
        }
        if(isset($shopify_order['note_attributes'])){
            $this->insertNoteAttribute($id,$shopify_order['note_attributes']);
        }
        if(isset($shopify_order['shipping_lines'])){
            $this->insertShipping_lines($id,$shopify_order['shipping_lines']);
        }
        if(isset($shopify_order['line_items'])){
            $this->insertLine_items($id,$shopify_order['line_items']);
        }
        
        
        
        //var_dump($shopify_order);
    }
    public function insertFulfillments($id,$fulfillments){
        //echo 'fulfillments:';
        //var_dump($fulfillments);
        for($i = 0; $i < count($fulfillments['tracking_numbers']); $i++){
            $Sql="INSERT INTO orders_fulfillments(order_id,tracking_number)VALUES('".$id."','".$fulfillments['tracking_numbers'][$i]."')";
            mysqli_query($this->con, $Sql);
        }
        
    }
    public function insertNoteAttribute($id,$note_attributes){
        //echo 'note_attributes:';
        //var_dump($note_attributes);
        for($i = 0; $i < count($note_attributes); $i++){
            $Sql="INSERT INTO orders_note_attributes(order_id,name,value)VALUES('".$id."','".$note_attributes[$i]['name']."','".$note_attributes[$i]['value']."')";
            mysqli_query($this->con, $Sql);
        }
        
    }
    public function insertShipping_lines($id,$shipping_lines){
        //echo 'shipping_lines:';
        //var_dump($shipping_lines);
        for($i = 0; $i < count($shipping_lines); $i++){
            $Sql="INSERT INTO orders_shipping_lines(order_id,code,price,title)VALUES('".$id."','".$shipping_lines[$i]['code']."','".$shipping_lines[$i]['price']."','".$shipping_lines[$i]['title']."')";
            mysqli_query($this->con, $Sql);
        }
        
    }
    public function insertLine_items($id,$line_items){
        //echo 'line_items:';
        //var_dump($line_items);
        for($i = 0; $i < count($line_items); $i++){
            $Sql="INSERT INTO orders_line_items(order_id,title,price,quantity,grams,variant_title)VALUES('".$id."','".$line_items[$i]['title']."','".$line_items[$i]['price']."','".$line_items[$i]['quantity']."','".$line_items[$i]['grams']."','".$line_items[$i]['variant_title']."')";
            mysqli_query($this->con, $Sql);
        }
        
    }
    
    public function getFulfillments($order_id){
        $Sql="SELECT order_id,tracking_number FROM orders_fulfillments WHERE order_id='".$order_id."'";
        $resp = mysqli_query($this->con,$Sql);
        return $resp;
    }
    public function getNoteAttribute($order_id){
        $Sql="SELECT order_id,name,value FROM orders_note_attributes WHERE order_id='".$order_id."'";
        $resp = mysqli_query($this->con,$Sql);
        return $resp;
    }
    public function getShipping_lines($order_id){
        $Sql="SELECT order_id,code,price,title FROM orders_shipping_lines WHERE order_id='".$order_id."'";
        $resp = mysqli_query($this->con,$Sql);
        return $resp;
    }
    public function getLine_items($order_id){
        $Sql="SELECT order_id,title,price,quantity,grams,variant_title FROM orders_line_items WHERE order_id='".$order_id."'";
        $resp = mysqli_query($this->con,$Sql);
        return $resp;
    }
    public function getOrders(){
        $Sql="SELECT             id,
                                 customer_first_name,
                                 customer_last_name,
                                 customer_email,
                                 browser_ip,
                                 created_at,
                                 discount_codes,
                                 email,
                                 financial_status,
                                 note,
                                 gateway,
                                 referring_site,
                                 subtotal_price,
                                 tags,
                                 total_tax,
                                 total_price,
                                 total_discounts,
                                 total_weight,
                                 billing_first_name,
                                 billing_last_name,
                                 billing_company,
                                 billing_address1,
                                 billing_phone,
                                 billing_city,
                                 billing_province,
                                 billing_country,
                                 billing_zip,
                                 shipping_first_name,
                                 shipping_last_name,
                                 shipping_address1,
                                 shipping_phone,
                                 shipping_city,
                                 shipping_province,
                                 shipping_country,
                                 shipping_zip FROM orders";
        $resp = mysqli_query($this->con, $Sql);
        
        return $resp;
    }
    
    public function getOrdersLimit($begin){
        $Sql="SELECT             id,
                                 customer_first_name,
                                 customer_last_name,
                                 customer_email,
                                 browser_ip,
                                 created_at,
                                 discount_codes,
                                 email,
                                 financial_status,
                                 note,
                                 gateway,
                                 referring_site,
                                 subtotal_price,
                                 tags,
                                 total_tax,
                                 total_price,
                                 total_discounts,
                                 total_weight,
                                 billing_first_name,
                                 billing_last_name,
                                 billing_company,
                                 billing_address1,
                                 billing_phone,
                                 billing_city,
                                 billing_province,
                                 billing_country,
                                 billing_zip,
                                 shipping_first_name,
                                 shipping_last_name,
                                 shipping_address1,
                                 shipping_phone,
                                 shipping_city,
                                 shipping_province,
                                 shipping_country,
                                 shipping_zip FROM orders
                                 WHERE id >= '".$begin."'";
        $resp = mysqli_query($this->con, $Sql);
        
        return $resp;
    }
    public function truncate_tables($table){
        if(is_array($table)){
            foreach($table as $value){
                mysqli_query($this->con,"TRUNCATE TABLE ".$value);
            }
        }else if(is_string($table)){
            mysqli_query($this->con,"TRUNCATE TABLE ".$table);
        }
        
    }
}

?>
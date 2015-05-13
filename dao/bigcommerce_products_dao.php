<?php
class bigcommerce_products_dao{
    
    public function __construct(){
        
    }
    
    public function getCustomers(){
        $Sql = "SELECT id, first_name, last_name, email FROM customer";
        $Sql = mysqli_query($this->con, $Sql);
        return $Sql;
    }
    
    public function getProducts($customer_id){
        $Sql = "SELECT id, customer_id,product_id FROM product WHERE cistomer_id='".$customer_id."'";
        $Sql = mysqli_query($this->con, $Sql);
        $Sql = $Sql->fetch_object();
        return $Sql;
    }
}

?>
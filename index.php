<?php
include 'includes.php';

$segments = getSegmentUri();
if(isset($_POST['page'])){
    $a = $_POST['page'];
    
}else if(isset($_GET['page'])){
    $a = $_GET['page'];
    
}else{
    $a = $segments[0];
}

$object = null;
$user = new user();

switch($a){    
    
    case 'login':
        $object = new login();
        $object->view_login($segments);
    break;
    
    case 'login_val':
        $object = new login();
        $object->view_login_validate($segments);
    break;
    
    case 'logout':
        $object = new login();
        $object->logout();
    break;
    
    case 'admin':
        validate($user);
        $object = new admin();
        $object->view_admin($segments);
    break;
    
    case 'newuser':
        $object = new admin();
        $object->new_user();
    break;
    case 'adduser':
        $object = new admin();
        $object->add_user();
    break;
    
    case 'products':
        //validate($user);
        $object = new bigcommerce_products();
        $object->view_products($segments);
    break;
    
    case 'client':
        $object = new customer();
        $object->view_customer($segments);
        //print_r($_POST);
        //echo '{"response":"insertado"}';
    break;
    
    case 'cronjob':
        $object = new cronjob();
        $object->view_cronjob($segments);
    break;
    
    case 'popup':
        $object = new \controller\popup();
        $object->view_popup($segments);
    break;
    
    case 'testmail':
        $object = new mail();
        $object->sendMail();
    break;
    
    case 'test2':
        $object = new mail();
        $object->testMail();
    break;
    
    case 'custom_mail':
    //This class is for customize email
        $object = new mailchimpC();
        $object->view_mailchimp($segments);
    break;
    
    case 'contact':
        $object = new Contact();
        $object->view_contact($segments);
    break;
    
    case 'manager';
        $object = new Manager();
        $object->view_manager($segments);
    break;
    
    case 'test':
        header("Content-Type: application/json");
        //echo json_encode($collections);
        $json = 'jsonp_callback(';
        $json .= json_encode(array('title'=>'is working'));
        $json .= ');';
        echo $json;
    break;
    
    default:
        //$object = new xml();
        //$object->view_xml($segments);
        $object = new login();
        $object->view_login($segments);
    break;
}

?>
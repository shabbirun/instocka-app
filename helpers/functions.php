<?php
function conn(){
    $connect = mysqli_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD,DB_DATABASE);
    /* check connection */
    if (!$connect) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    return $connect;
}
function validate($user){
    //chech session
    if(!$user->check_session()){
        include 'view/login.php';
        exit();
    }
}

//database
function truncate_table($conn,$table){
    mysqli_query($conn,"TRUNCATE TABLE ".$table);
}
//url
function getSegmentUri(){
    $_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $segments = explode('/', $_SERVER['REQUEST_URI_PATH']);  
    $current = count($segments)-1; 
    $segments = explode('-', $segments[$current]);
    for($i=1; $i < count($segments); $i++){
        $segments[$i] = (!empty($segments[$i]))?$segments[$i]:'none';
    }
    //$segments[1] = (isset($segments[1]))?$segments[1]:'none';
    //$segments[2] = (isset($segments[2]))?$segments[2]:'none';
    //$segments[3] = (isset($segments[3]))?$segments[3]:'none';
    return $segments;
}

function mig_test(){
    echo 'test de funcion';
}
?>
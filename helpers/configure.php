<?php
/**

 * @Type MERCHANT DATA

 */
define('BIGCOMM_API_TOKEN','cc53a1c5137309b249a69456ef890fe070e1e66c');//FOR PRIVATE APP
define('BIGCOMM_PATH','https://store-g1wmq.mybigcommerce.com');//FOR PRIVATE APP   https://store-g1wmq.mybigcommerce.com
define('BIGCOMM_USERNAME','apolo1');//FOR PRIVATE APP

/**

 * @Type CLIENT PUBLIC APP DATA

 */

define('CLIENT_ID','appmue20kczim149h569n46nvu38g6j');//FROM YOUR PUBLIC APP
define('CLIENT_SECRET','j9hsdplcp7770llc6czpsdul7u9lcat');//FROM YOUR PUBLIC APP
define('REDIRECR_URI','https://instockalerts.co/instocka_app/client-auth');//FROM YOUR PUBLIC APP

/**

  * @superadmin

  */

define('SUPER_ADMIN_EMAIL','shabbirun@gmail.com');//shabbirun@gmail.com



/** 

 * @Webhook

 * */

define('WEBHOOK_URL','https://instockalerts.co/instocka_app/cronjob-webhook');

/** 

 * @constants

 * */

define('APP_PRIVATE','private');
define('APP_PUBLIC','public');
define('APP_TYPE','public');//private || public
define('IS_PUBLIC', true);


if (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'){

    $scheme = 'https://';

}

else{

    $scheme = 'http://';

}
define('FOLDER','instocka_app');
define('BASE_URL', $scheme.$_SERVER['HTTP_HOST'].'/'.FOLDER.'/');
//define('BASE_URL', 'http://apolomultimedia.us/directbathrooms/');
define('BASE_URL_WEB','https://instockalerts.co/'.FOLDER.'/');
define('FOLDER_IMAGE','assets/images/headers/');//nedded

define('URLTO_CSS','resource/css/');//nedded

/** 

 * @Server

 * */
// define our database connection

  define('DB_SERVER', 'localhost'); // eg, localhost - should not be empty for productive servers

  define('DB_SERVER_USERNAME', 'instocka_alert');

  define('DB_SERVER_PASSWORD', 'Abc78652');//Abc78652

  define('DB_DATABASE', 'instocka_alert_app');

  define('USE_PCONNECT', 'false'); // use persisstent connections?

  define('STORE_SESSIONS', 'mysql'); // leave empty '' for default handler or set to 'mysql'
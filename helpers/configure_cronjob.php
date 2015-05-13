<?php
define('BIGCOMM_API_TOKEN','920df502e1bf8d27ffcc0b5856e2e6f7b6015628');//OBTENIDO AL CREAR APP DE SHOPIFY  (requerido para un private_app)

define('BIGCOMM_PATH','https://store-71ac6ea.mybigcommerce.com');//ruta del dev shop de shopify (requerido para un private_app)

define('BIGCOMM_USERNAME','programmer1');//PRIVATE APP

define('CLIENT_ID','appmue20kczim149h569n46nvu38g6j');//FROM YOUR PUBLIC APP
define('CLIENT_SECRET','j9hsdplcp7770llc6czpsdul7u9lcat');//FROM YOUR PUBLIC APP
define('REDIRECR_URI','https://instockalerts.co/instocka_app/client-auth');//FROM YOUR PUBLIC APP

define('FOLDER','instocka_app');

define('BASE_URL', '/home3/instocka/public_html/'.FOLDER.'/');// /home3/instocka/public_html/instocka_app

define('BASE_URL_WEB', "https://instockalerts.co".'/'.FOLDER.'/');

//define('BASE_URL', 'http://apolomultimedia.us/directbathrooms/');
define('FOLDER_IMAGE','assets/images/headers/');

define('MAILCHIMP_APY_KEY','1b94b2ff840fd842000dabfee39d5d7a-us8');

// define our database connection



  define('DB_SERVER', 'localhost'); // eg, localhost - should not be empty for productive servers

  define('DB_SERVER_USERNAME', 'apolousa_bigcomm');//afhost_afhost

  define('DB_SERVER_PASSWORD', '>5dTzgd8nmMy');//>5dTzgd8nmMy

  define('DB_DATABASE', 'apolousa_bigcomm');

  define('USE_PCONNECT', 'false'); // use persisstent connections?

  define('STORE_SESSIONS', 'mysql'); // leave empty '' for default handler or set to 'mysql'
?>
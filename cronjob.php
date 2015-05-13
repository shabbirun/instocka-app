<?php

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
ini_set('memory_limit', '1024M');
ini_set("display_errors", "1");
error_reporting(E_ALL);
date_default_timezone_set('America/New_York');
$directoriocorrescript = "/";  
//  /home/rabbit13/public_html/rabbitairpurifier.com/rabbitairpurifier_app/ 
//  /home/apolousa/public_html/bigcomm_app/
require $directoriocorrescript.'helpers/configure_cronjob.php';
require $directoriocorrescript.'helpers/functions.php';
require $directoriocorrescript.'dao/connection.php';
require $directoriocorrescript.'library/smtp.php';
require $directoriocorrescript.'library/phpmailer.php';

require_once $directoriocorrescript.'library/Api/Connection.php';
require_once $directoriocorrescript.'library/Api/Error.php';
require_once $directoriocorrescript.'library/Api/ClientError.php';
require_once $directoriocorrescript.'library/Api/ServerError.php';
require_once $directoriocorrescript.'library/Api/NetworkError.php';
require_once $directoriocorrescript.'library/Api/Client.php';
require_once $directoriocorrescript.'library/Api/Filter.php';
require_once $directoriocorrescript.'library/Api/Resource.php';
require_once $directoriocorrescript.'library/Api/Resources/Address.php';
require_once $directoriocorrescript.'library/Api/Resources/Brand.php';
require_once $directoriocorrescript.'library/Api/Resources/Category.php';
require_once $directoriocorrescript.'library/Api/Resources/Coupon.php';
require_once $directoriocorrescript.'library/Api/Resources/Customer.php';
require_once $directoriocorrescript.'library/Api/Resources/DiscountRule.php';
require_once $directoriocorrescript.'library/Api/Resources/Option.php';
require_once $directoriocorrescript.'library/Api/Resources/OptionSet.php';
require_once $directoriocorrescript.'library/Api/Resources/OptionSetOption.php';
require_once $directoriocorrescript.'library/Api/Resources/OptionValue.php';
require_once $directoriocorrescript.'library/Api/Resources/Order.php';
require_once $directoriocorrescript.'library/Api/Resources/OrderProduct.php';
require_once $directoriocorrescript.'library/Api/Resources/OrderStatus.php';
require_once $directoriocorrescript.'library/Api/Resources/Product.php';
require_once $directoriocorrescript.'library/Api/Resources/ProductConfigurableField.php';
require_once $directoriocorrescript.'library/Api/Resources/ProductCustomField.php';
require_once $directoriocorrescript.'library/Api/Resources/ProductImage.php';
require_once $directoriocorrescript.'library/Api/Resources/ProductOption.php';
require_once $directoriocorrescript.'library/Api/Resources/ProductVideo.php';
require_once $directoriocorrescript.'library/Api/Resources/RequestLog.php';
require_once $directoriocorrescript.'library/Api/Resources/Rule.php';
require_once $directoriocorrescript.'library/Api/Resources/RuleCondition.php';
require_once $directoriocorrescript.'library/Api/Resources/Shipment.php';
require_once $directoriocorrescript.'library/Api/Resources/Sku.php';
require_once $directoriocorrescript.'library/Api/Resources/SkuOption.php';
require_once $directoriocorrescript.'library/Drewm/MailChimp.php';

require $directoriocorrescript.'model/user.php';
require $directoriocorrescript.'dao/admin_dao.php';
require $directoriocorrescript.'dao/cronjob_dao.php';
require $directoriocorrescript.'dao/mailchimp_dao.php';
require $directoriocorrescript.'dao/customerdao.php';
require $directoriocorrescript.'model/mail.php';
require $directoriocorrescript.'model/mailchimp.php';
require $directoriocorrescript.'model/template.php';

require $directoriocorrescript.'controller/bigcommerce_products.php';
require $directoriocorrescript.'controller/customer.php';
require $directoriocorrescript.'controller/cronjob.php';
require $directoriocorrescript.'controller/admin.php';

$cronjob = new cronjob();
$cronjob->cronjob_sendMails();


/**
 * cronjob
 * /usr/local/bin/php -f /home/apolousa/public_html/bigcomm_app/cronjob.php
 * 
 * */
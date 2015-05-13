<!DOCTYPE HTML>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <?php include 'view/scripts2.php'; ?>
    <style type="text/css">

    .text-fix{
        line-height: 30px;
    padding-right: 0;
    text-align: right;
    }
    .btn-fix{
        padding: 4px 10px;
    }
    .col-md-2-fix{
        padding-left: 5px;
        padding-right: 5px;
    }
    .col-md-3-fix{
        padding-left: 0;
    }
    .table-striped > tbody > tr:nth-child(n) > td{
        background-color: #F9F9F9;
    }
    .table-striped th{
        background: #82D5D8;
    }
    .table-striped > tbody > tr:nth-child(2n+1) > th {
        background-color: #82D5D8;
        color: #F4F4F4;
    }
    .panel-body-fix{
        margin-top: 0;
        padding-top: 1px;
    }
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        border-top: 1px solid #ddd;
        line-height: 1.42857;
        padding: 8px 8px 0;
        vertical-align: top;
    }
    .panel-fix{
        padding: 5px;
        border-bottom: 1px solid #DDD;
        border-radius: 2px;
    }
    </style>

</head>
<?php
$customers = (!empty($customers))?$customers:null;
?>
<body>
<div id="wrapper">
    <div class="wrapper">
    
    <?php include 'view/panel_head.php';?>

        <div class="panel panel-default panel-fix">
        <!--<div class="panel-heading text-center"><strong>Plans</strong></div>-->
        <div class="panel-body panel-body-fix">
        <div class="col-lg-12">
        <h4 class="pad-left">INFORMATION</h4>
        <div>
        <div id="billing_company">
            <strong>Name:</strong> <?php echo $data['name']; ?><br/>
            <strong>Email:</strong> <?php echo $data['email']; ?><br/><br/>
        </div>
        <div id="billing_subscription">
            <b>Subscription:</b> <?php echo $data['subscription']; ?><br>
            <b>Expires:</b> <?php echo $data['expire']; ?>
        </div>
            <div class="clear"></div>
        </div>
        <p></p>
        <p><b><?php echo $data['message']; ?></b></p>
        </div>
        <div class="col-lg-12">
 <!----> 
        
    <?php
    //VARIABLES
    $filas = array('001','Instockalerts App Monthly Subscription','1');
    $account = $data['account_super'];
    //$account = 'accounting-facilitator@apolomultimedia.com';//sandbox  
    $email = $data['email'];
    $url = array('https://www.sandbox.paypal.com/cgi-bin/webscr','https://www.paypal.com/cgi-bin/webscr');//test 0, real 1
    $user_login_id = $data['user_login_id'];
    ?>
    <form action="<?php echo $url[1]; ?>" method="post" target="_top">
    <p><b>Monthly: $15.00 USD/month</b></p>
    <input type="hidden" name="cmd" value="_xclick-subscriptions" />
    <input type="hidden" name="business" value="<?php echo $account; ?>" />
    <input type="hidden" name="item_name" value="<?php echo $filas[1]?>"/>
    <input type="hidden" name="item_number" value="<?php echo $filas[0]?>" />
    <!--<input type="hidden" name="amount" value="<?php //echo $filas[2]?>" />-->
    <input type="hidden" name="currency_code" value="USD" />
    <input type="hidden" name="return" value="<?php echo BASE_URL?>manager-ipnreturncancel?var=1" />
    <input type="hidden" name="cancel_return" value="<?php echo BASE_URL?>manager-ipnreturncancel?var=2" />
    <input type="hidden" name="undefined_quantity" value="0" />
    <input type="hidden" name="receiver_email" value="<?php echo $email; ?>"/>
    
    <!---->
    <input type="hidden" name="lc" value="US">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="no_shipping" value="1">
    <input type="hidden" name="a1" value="0.00">
    <input type="hidden" name="p1" value="15">
    <input type="hidden" name="t1" value="D">
    <input type="hidden" name="src" value="1">
    <input type="hidden" name="a3" value="15.00">
    <input type="hidden" name="p3" value="1">
    <input type="hidden" name="t3" value="M">
    <input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHosted">
    <!---->
    
    <input type="hidden" name="on0" value="paid_on"/>
    <input type="hidden" name="os0" maxlength="200" value="<?php echo date('Y-m-d')?>"/>
    <input type="hidden" name="on1" value="id_user"/>
	<input type="hidden" name="os1" maxlength="200" value="<?php echo $user_login_id; ?>"/>
    <input name="notify_url"    type="hidden" value="<?php echo BASE_URL?>manager-ipn">
    <input name="rm"            type="hidden" value="2"/>
    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal, la forma más segura y rápida de pagar en línea.">
    <img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
</form>

<!--
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_xclick-subscriptions">
<input type="hidden" name="business" value="shabbir@instockalerts.co">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="Instockalerts App Monthly Subscription">
<input type="hidden" name="item_number" value="0001">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="a1" value="0.00">
<input type="hidden" name="p1" value="15">
<input type="hidden" name="t1" value="D">
<input type="hidden" name="src" value="1">
<input type="hidden" name="a3" value="15.00">
<input type="hidden" name="p3" value="1">
<input type="hidden" name="t3" value="M">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="usr_manage" value="1">
<input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHosted">
<input type="hidden" name="notify_url" value="http://www.instockalerts.co/instocka_app/manager-ipn">
<input type="image" src="https://www.paypalobjects.com/es_XC/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal, la forma más segura y rápida de pagar en línea.">
<img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
</form>
-->
        
        
        
        
<!---->
        </div>
        <div class="col-lg-12" style="display: none;"><!--from shabbir-->
            <form action="<?php echo $url[1]; ?>" method="post" target="_top">
                <p><b>Monthly: $15.00 USD/month</b></p>
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="ZRAHQVCA84N9G">
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
        </div><!--from shabbir-->
        <div class="col-md-8">
            <h4>INVOICE SUMARY</h4>
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <td class="text-center">Invoice</td>
                        <td class="text-center">Amount</td>
                        <td class="text-center">Invoice date</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($data['paypal'] as $key=>$value){
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $value['txn_id']; ?></td>
                        <td class="text-center"><?php echo $value['amount']; ?></td>
                        <td class="text-center"><?php echo $value['option_selection1']; ?></td>
                    </tr>
                    <?
                    }
                    ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>

</body>
</html>
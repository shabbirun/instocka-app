<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="GallerySoft.info" />
	<title>bigcommerce app</title>
    <?php include 'scripts.php'; ?>   
</head>

<body>

<div class="container2">
<?php
//echo __FILE__;
//echo '<br />'.__DIR__;
//echo '<br />'.getcwd();
?>
<section id="cont-mg">
<div style="display: block;overflow: hidden;text-align: center;width: 100%;">
 <div><a href="#" id="user-logout">log out</a></div>
</div>
<div>
    <ul>
        <li>
            <div class="mg-tittle"><span>Upload File</span></div>
            <div class="cont-mg-li">
                <!--<form action="<?php //echo BASE_URL; ?>" method="post" enctype="multipart/form-data">
                <table>
                <tr>
                <td>
                    <input type="file"  name="archivo" class="" /><br /><br />
                    <input name="enviar" type="submit" value="Submit" class=""  />
                    <div class="msg-system"><?php //echo $msg; ?></div>
                </td>
                </tr>
                </table>
                <input name="action" type="hidden" value="subir" /> 
                <input name="page" type="hidden" value="upload_file_xml" />
                </form>-->
            </div>
        </li>
        <li>
            <div class="mg-tittle"><span>Store List</span></div>
            <div class="cont-mg-li">
                <div style="text-align: center;">
                    <input type="button" id="view-products" class="btn-style" value="View Products from Bigcommerce" />
                    <a href="<?php //echo BASE_URL; ?>products" style="display: none;" id="view-products-launch">View xml orders</a>
                </div>
                <!--<div style="text-align: center;">
                    <input type="button" id="view-orders" class="btn-style" value="View raw orders from shopify" />
                    <a href="<?php //echo BASE_URL; ?>orders" style="display: none;" id="view-orders-launch">View xml orders</a>
                </div>
                <div style="text-align: center;">
                    <input type="button" id="view-addresses" class="btn-style" value="View xml orders" />
                    <a href="<?php //echo BASE_URL; ?>?page=read_xml" style="display: none;" id="view-addresses-launch">View xml orders</a>
                </div>
                <div>
                <p style="border-bottom: 1px solid #FFFFFF;margin:15px 0 0 0;">Last File</p>
                <?php //isset($file)?$file:''; echo $file; ?>
                </div>-->
            </div>
        </li>
    </ul>
</div>
</section>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#view-products').click(function(){
        window.location = $('a#view-products-launch').attr('href');
    }); 
    $('#view-orders').click(function(){
        window.location = $('a#view-orders-launch').attr('href');
    });  
    $('#insert-orders').click(function(){
        window.location = $('a#insert-orders-launch').attr('href');
    });  
    
})
</script>
</body>
</html>
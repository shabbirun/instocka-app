<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="GallerySoft.info" />

	<title>Orders from shopify</title>
    <?php include 'scripts.php'; ?>  
</head>

<body>
<div style="clear: both;">
 <p style="float: left;"><a href="<?php echo BASE_URL; ?>">return</a></p>
 <p style="float: right;"><a href="#" id="user-logout">log out</a></p>
</div>
<div style="clear: both;">
<?php
print_r($orders);
?>
</div>



</body>
</html>
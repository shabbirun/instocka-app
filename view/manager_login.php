<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="GallerySoft.info" />

	<title>Login</title>
    <?php include 'scripts.php'; ?>   
</head>

<body>
<div class="container-login">

    <form id="signup" action="<?php echo BASE_URL; ?>manager-panel" method="post">

        <div class="header">
        
            <h2>User Manager</h2>
            
            <!--<p>You want to fill out this form</p>-->
            
        </div>
        
        <div class="sep"></div>

        <div class="inputs">
            <input type="text" name="user" placeholder="user" autofocus />
            <input type="password" name="password" placeholder="Password" />
            <input type="hidden" name="action" value="login" />
            <div class="checkboxy">
                <input name="cecky" id="checky" value="1" type="checkbox" /><label class="terms">I accept the terms of use</label>
            </div>
            <input id="submit" type="submit" value="login" />
        
        </div>

    </form>

</div>

</body>
</html>
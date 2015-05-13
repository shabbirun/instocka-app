<!DOCTYPE HTML>
<html lang="en">
<head>
    <?php include 'view/scripts2.php'; ?>
    <style type="text/css">
        .pad-fix{
            padding:10px 20px 0;
        }
    </style>
</head>
<?php


?>
<body>
<div id="wrapper">
    <div class="wrapper">
    
    <?php include 'view/panel_head.php';?>
        <div class="panel panel-default panel-fix">
        <div class="panel-heading text-center"><strong>Contact Us</strong></div>
        <div class="panel-body panel-body-fix">
            <div class="pad-fix">
            <form name="" method="POST" action="<?php echo BASE_URL; ?>contact-send" role="form" >
                <div class="form-group">
                <?php echo (!empty($data['msg']))?$data['msg']:''; ?>
                </div>
                
                <div class="form-group">
                    <label for="name" >Name: </label>
                        <input type="text" class="form-control" id="name" name="name" value="" />
                </div>
                <div class="form-group">
                    <label for="password" >Email: </label>
                        <input type="text" class="form-control" id="email" name="email" value="" />
                </div>
                <div class="form-group">
                    <label for="store" >Store URL: </label>
                        <input type="text" class="form-control" id="storeurl" name="storeurl" placeholder="" value="" />
                </div>
                <div class="form-group">
                    <label for="store_url" >Message: </label>
                        <textarea name="message" id="message" class="form-control"></textarea>
                </div>
                
                <div class="form-group">
                <input type="hidden" name="sender" value="1" />
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
            </div>
        </div>
        <br />
        </div>  
    </div>
    <div>
    
    </div>
</div>
</body>
</html>
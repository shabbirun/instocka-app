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
$notified = (!empty($notified))?$notified:null;
if(!empty($_POST) && $_POST['password']){
    $data = array();
    foreach($_POST as $key => $value){
        $data[$key] = $value;
    }
    $data['msg']='Any fields are empty...';
}
?>
<body>
<div id="wrapper">
    <div class="wrapper">
    
    <?php $msg = empty($data['msg'])?'':$data['msg'];?>
        <div class="panel panel-default panel-fix">
        <div class="panel-heading text-center"><strong>New user register</strong></div>
        <div class="panel-body panel-body-fix">
            <div class="pad-fix">
            <form name="" method="POST" action="<?php echo BASE_URL; ?>adduser" role="form" >
                <div class="form-group">
                <?php echo $msg; ?>
                </div>
                
                <div class="form-group" <?php echo (!empty($data['name']) && !empty($data['password']))?'style="display:none;"':'';?>>
                    <label for="name" >Username: </label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $data['name']?>" />
                </div>
                <div class="form-group" <?php echo (!empty($data['name']) && !empty($data['password']))?'style="display:none;"':'';?>>
                    <label for="password" >Password: </label>
                        <input type="password" class="form-control" id="password" name="password" value="<?php echo $data['password']?>" />
                </div>
                <div class="form-group">
                    <label for="store" >Store name: </label>
                        <input type="text" class="form-control" id="store" name="store" placeholder="Store" value="" />
                </div>
                <div class="form-group">
                    <label for="store_url" >Store url: </label>
                        <input type="text" class="form-control" id="store_url" name="store_url" placeholder="http://mytest.mybigcommerce.com" value="" />
                </div>
                <div class="form-group" <?php echo (!empty($data['name']) && !empty($data['email']))?'style="display:none;"':'';?>>
                    <label for="email" >Email: </label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="email" value="<?php echo $data['email']?>" />
                </div>
                <div class="form-group">
                    <label for="BIGCOMM_USERNAME" >Username: </label>
                        <input type="text" class="form-control" id="BIGCOMM_USERNAME" name="BIGCOMM_USERNAME" placeholder="Api Username" value="" />
                </div>
                <div class="form-group">
                    <label for="BIGCOMM_PATH" >API Path: </label>
                        <input type="text" class="form-control" id="BIGCOMM_PATH" name="BIGCOMM_PATH" placeholder="https://test.mybigcommerce.com/api/v2/" value="" />
                </div>
                <div class="form-group">
                    <label for="BIGCOMM_API_TOKEN" >API Token: </label>
                        <input type="text" class="form-control" id="BIGCOMM_API_TOKEN" name="BIGCOMM_API_TOKEN" placeholder="Api token" value="" />
                </div>
                
                <div class="form-group">
                <input type="hidden" name="user_token_id" value="<?php echo (!empty($data['user_token_id']))?$data['user_token_id']:'';?>" />
                <button type="submit" class="btn btn-primary">Register App Access</button>
            </div>
            </form>
            </div>
        </div>
        </div>  
    </div>
    <div>
    
    </div>
</div>
</body>
</html>
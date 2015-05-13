<!DOCTYPE HTML>
<html lang="en">
<head>
    <?php include 'view/scripts2.php'; ?>
    <style>
    .page-header {
        padding: 0 0 15px;
    }
    </style>
</head>
<?php


?>
<body>
<div id="wrapper">
<div class="wrapper">
    
    <div class="page-header" style="position: relative;">
        <h3>User Manager</h3>
        <div>
            <a class="btn btn-primary" href="<?php echo BASE_URL?>manager">panel</a>
            <a class="btn btn-primary" href="<?php echo BASE_URL?>manager-settings">settings</a>
            <a class="btn btn-primary" href="<?php echo BASE_URL?>manager-logout" style="float: right;">logout</a>
        </div>
    </div>
    
    
    <div class="panel panel-default panel-fix">
        <div class="panel-heading text-center"><strong>Settings</strong></div>
        <div class = "panel-body panel-body-fix">
            <div class="col-md-6">
            <form class="" method="post" action="<?php echo BASE_URL?>manager-settings" role="form">
                <div class="form-group">
                    <label>User name</label>
                    <input type="text" class="form-control" name="user" id="user" value="<?php echo !empty($data['login'])?$data['login']:'';?>" />
                </div>
                <div class="form-group">
                <label>User login</label>
                    <input type="text" class="form-control" name="password" id="password" value="<?php echo !empty($data['password'])?$data['password']:'';?>" />
                </div>
                <div class="form-group">
                <label>Mailchimp Api Key</label>
                    <input type="text" class="form-control" name="mailchimp_apikey" id="mailchimp_apikey" value="<?php echo !empty($data['mailchimp_apikey'])?$data['mailchimp_apikey']:'';?>" />
                </div>
                <div class="form-group">
                    <label>Mailchimp List</label>
                    <?php
                    if(empty($data['mailchimp_apikey'])){
                        echo '<p>mailchimp api key is empty</p>';
                    }else{
                    ?>
                    <select name="mlists" id="mlists" class="form-control">
                    <option web_id="" value="">--select--</option>
                    <?php
                        foreach($data['mailchimp_list'] as $list){
                    ?>
                        <option visibility="<?php echo $list['visibility'];?>" web_id="<?php echo $list['web_id'];?>" value="<?php echo $list['id'];?>" <?php echo (!empty($data['mailchimp_list_id']) && $list['id']==$data['mailchimp_list_id'])?'selected="selected"':'';?>><?php echo $list['name'];?></option>
                    <?php        
                        }}
                    ?>
                    </select>
                </div>
                <div class="form-group">
                <label>Mailchimp List Id</label>
                <p id="mch-id"><?php echo !empty($data['mailchimp_list_id'])?$data['mailchimp_list_id']:'';?></p>
                    <input type="hidden" class="form-control" name="mailchimp_list_id" id="mailchimp_list_id" value="<?php echo !empty($data['mailchimp_list_id'])?$data['mailchimp_list_id']:'';?>" />
                </div>
                <div class="form-group">
                <label>Mailchimp Web Id</label>
                <p id="mch-web-id"><?php echo !empty($data['mailchimp_web_id'])?$data['mailchimp_web_id']:'';?></p>
                    <input type="hidden" class="form-control" name="mailchimp_web_id" id="mailchimp_web_id" value="<?php echo !empty($data['mailchimp_web_id'])?$data['mailchimp_web_id']:'';?>" />
                </div>
                
                    <input type="hidden" name="action" value="update" />
                    <input type="submit" class="btn btn-primary" value="Submit"  />
                    <br />
                    <br />
            </form>
            </div>
            
        </div>
    </div>

</div>
</body>
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('change','#mlists',function(){
        var obj = $(this);
        var mid = obj.val();
        console.log(obj);
        var mweb_id = obj.find('option:selected').attr('web_id');
        $('#mailchimp_list_id').val(mid);
        $('#mailchimp_web_id').val(mweb_id);
        $('#mch-id').text(mid);
        $('#mch-web-id').text(mweb_id);
    });
})
</script>
</html>
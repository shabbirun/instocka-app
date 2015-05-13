<!DOCTYPE HTML>
<html lang="en">
<head>
    <?php include 'view/scripts2.php'; ?>
    <script src="<?php echo BASE_URL; ?>assets/js/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/boostrap_file_input.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/ckeditor/config.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/js/ckeditor/skins/moono/editor_gecko.css" />
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/ckeditor/styles.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        //$('input[type=file]').bootstrapFileInput();
        $('#file').bootstrapFileInput();
    })
    
    </script>
</head>
<?php
$data['option_mail'] = (!empty($data['option_mail']))?$data['option_mail']:'custom_mail';
?>
<body>
<div id="wrapper">
    <div class="wrapper">
    
    <?php include 'view/panel_head.php';?>
    <form name="mailchimp-form" action="<?php echo BASE_URL; ?>custom_mail-set" method="POST" role="form" enctype="multipart/form-data"><!--name="mail-setup"-->
            <div class="row">
            <?php //print_r($data); ?>
            </div>
            <!--custom mail-->
            <div class="custom-mail">
            <div class="row">
                <div class="form-group">
                    <div class="radio">
                        <label>
                            <h3><input type="radio" name="check" id="check" value="custom_mail" <?php echo (!empty($data['option_mail']) && $data['option_mail'] =='custom_mail')?'checked':'';?> />Custom E-Mail</h3>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="from_email" >"from" Email: </label>
                        <input type="text" class="form-control" id="custom_from_email" name="custom_from_email" placeholder="from email" value="<?php echo (!empty($data['custom_mail']['from_email']))?$data['custom_mail']['from_email']:''; ?>" />
                </div>
                <div class="form-group">
                    <label for="from_name" >"from" Name: </label>
                        <input type="text" class="form-control" id="custom_from_name" name="custom_from_name" placeholder="from name" value="<?php echo (!empty($data['custom_mail']['from_name']))?$data['custom_mail']['from_name']:''; ?>" />
                </div>
                <div class="form-group">
                    <label for="subject" >Subject: </label>
                        <input type="text" class="form-control" id="custom_subject" name="custom_subject" placeholder="Subject" value="<?php echo (!empty($data['custom_mail']['subject']))?$data['custom_mail']['subject']:''; ?>" />
                </div>
                <div class="form-group">
                <h3 class="text-left">Body</h3><!--BODY-->
                </div>
                
                <div class="form-group">
                    <label for="upload_file" >Header: <small>(width:600 x height:150)</small></label><br /><!--IMAGE SELECT FILE-->
                    <input type="file" class="btn btn-primary" name="file" id="file" title="Select image for header" />
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">Header background color</span>
                    <input type="text" class="form-control" name="header_bg" value="<?php echo (!empty($data['custom_mail']['header_bg']))?$data['custom_mail']['header_bg']:''; ?>" />
                </div>
                </div>
                
                <div class="form-group">
                    <label for="subject" >Content: </label>
                        <textarea class="ckeditor" id="custom_body" name="custom_body" placeholder="body" rows="20" ><?php echo (!empty($data['custom_mail']['body']))?$data['custom_mail']['body']:''; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="footer" >footer: </label>
                        <input type="text" class="form-control" id="footer" name="footer" value="<?php echo (!empty($data['custom_mail']['footer']))?$data['custom_mail']['footer']:''; ?>" />
                </div>
                <div class="form-group">
                    <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">Footer background color</span>
                    <input type="text" class="form-control" name="footer_bg" placeholder="" value="<?php echo (!empty($data['custom_mail']['footer_bg']))?$data['custom_mail']['footer_bg']:''; ?>" />
                </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save template</button>
                <a href="<?php echo BASE_URL; ?>custom_mail-template" class="btn btn-primary" target="_blank">preview template</a>
            </div>
            <div class="form-group line2"></div>
            <div class="row">
            <h5>Variables to use: <small>(only Subject and Body)</small></h5>
            <small>
                {{product_name}} , {{product_inventory_level}} , {{product_price}} , {{product_url}}, {{subscriber_first_name}}, {{subscriber_last_name}}, {{subscriber_email}}
            </small>
            </div>
            </div>
    </form>
    <br />
    </div>
</div>
</body>
</html>
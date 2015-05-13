<!DOCTYPE HTML>
<html lang="en">
<head>
    <?php include 'view/scripts2.php'; ?>
    <style type="text/css">
        .pad-fix{
            padding:10px 20px 0;
        }
    </style>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/boostrap_file_input.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        //$('input[type=file]').bootstrapFileInput();
        $('#file').bootstrapFileInput();
    })
    
    </script>
</head>
<?php


?>
<body>
<div id="wrapper">
    <div class="wrapper">
    
    <?php include 'view/panel_head.php';?>
        <div class="panel panel-default panel-fix">
        <div class="panel-heading text-center"><strong>Pop-up css</strong></div>
        <div class="panel-body panel-body-fix">
            <div class="pad-fix">
            <form name="" method="POST" action="<?php echo BASE_URL; ?>popup-write" role="form" enctype="multipart/form-data" >
                    <div class="form-group" style="display: none;">
                        <label for="upload_file" >sizes: <small>(width:510 x height:308)</small></label><br /><!--IMAGE SELECT FILE-->
                        <input type="file" class="btn btn-primary" name="file" id="file" title="Select background popup" />
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3">Pop-up style url</label>
                        <div class="alert alert-info" role="alert">
                            <strong><?php echo $data['url_css']; ?></strong>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3">Pop-up style</label>
                          <textarea class="form-control" name="write_data" rows="30"><?php echo $data['css_data']; ?></textarea>
                    </div>
                    <div class="form-group">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="css_default" value="1" /> Restore to default css
                            </label>
                          </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="user_login_id" value="" />
                        <input type="hidden" name="write" value="write" />
                        <button type="submit" class="btn btn-primary">Save</button>
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
<!DOCTYPE HTML>
<html lang="en">
<head>
    <?php include 'view/scripts2.php'; ?>
    <link href="<?php echo BASE_URL?>assets/js/datepicker/css/smoothness/jquery-ui-1.9.2.custom.css" rel="stylesheet" />
    <script src="<?php echo BASE_URL?>assets/js/datepicker/js/jquery-ui-1.9.2.custom.js"></script>
    <style type="text/css">
    .panel-fix {
        margin-bottom: 5px;
        margin-top: 5px;
    }
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
    </style>
    <script type="text/javascript">
    $(document).ready(function(){
        $( "#date_begin" ).datepicker();
        $( "#date_end" ).datepicker();
    })
    
    </script>
</head>
<?php
$notified = (!empty($notified))?$notified:null;
?>
<body>
<div id="wrapper">
    <div class="wrapper">
    
    <?php include 'view/panel_head.php';?>
        <!--DATE PICKER-->
        <div class="row" style="margin-top: 5px;">
            <form method="post" action="<?php echo BASE_URL?>admin-notified">
            <div class="col-md-7 text-fix">Search by date:</div>
            <div class="col-md-2 col-md-2-fix"><input type="text" class="form-control" id="date_begin" name="date_begin" placeholder="Begin" value="<?php echo (!empty($data['date_begin']))?$data['date_begin']:'';?>" /></div>
            <div class="col-md-2 col-md-2-fix"><input type="text" class="form-control" id="date_end" name="date_end" placeholder="End" value="<?php echo (!empty($data['date_end']))?$data['date_end']:'';?>"/></div>
            <div class="col-md-1 col-md-2-fix"><input type="submit" class="btn btn-primary btn-fix" id="search" value="submit" /></div>
            </form>
        </div>
        <!--DATE PICKER END-->
        <div class="panel panel-default panel-fix">
        <div class="panel-heading text-center"><strong>Emails notified</strong></div>
        <div class="panel-body panel-body-fix">
        <div class="table-responsive">
            <table class="table table-striped table-fix">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Product Name</th>
                    <th>Date</th>
                </tr>
                <?php
                try{
                    if(empty($notified)){ throw new Exception('Error');}
                    $c = 0;
                    while($resp = $notified->fetch_object()){
                    $c++;    
                    ?>
                    <tr>
                        <td><?php echo ucwords($resp->first_name).' '.ucwords($resp->last_name); ?></td>
                        <td><?php echo $resp->email; ?></td>
                        <td><?php echo (empty($resp->option_sku))?$resp->product_title:$resp->product_title.' <small>['.$resp->option_sku.']</small>'; ?></td>
                        <td><?php echo $resp->created_at; ?></td>
                    </tr>
                    <?php
                    }
                    if($c == 0){ echo '<p class="text-center">No notifications</p>';}
                }catch(Exception $ex){
                    echo $ex->getMessage().' - '.$ex->getFile().' - on line'.$ex->getLine();
                }
                ?>
            </table>
        </div>
        </div>
        </div>  
        <?php $paginate->show();?>
    </div>
    <div>
    
    </div>
</div>
</body>
</html>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <?php include 'view/scripts2.php'; ?>
</head>
<?php
$data = (!empty($data))?$data:null;
?>
<body>
<div id="wrapper">
    <div class="wrapper">
    
    <?php include 'view/panel_head.php';?>
        <div class="panel panel-default panel-fix">
        <div class="panel-heading text-center"><strong>Products stats</strong></div>
        <div class="panel-body panel-body-fix">
        <div class="table-responsive">
            <table class="table table-striped table-fix">
                <tr>
                    <th>*</th>
                    <th>Title</th>
                    <th class="text-center">Pending</th>
                    <th class="text-center">Notified</th>
                </tr>
                <?php
                try{
                    if(empty($data)){ throw new Exception('Error');}
                    $c = 1;
                    foreach($data as $resp){
                    ?>
                    <tr>
                        <td><?php echo $c; ?></td>
                        <td><?php echo $resp['title']; ?></td>
                        <td class="text-center"><?php echo $resp['pending'];  ?></td>
                        <td class="text-center"><?php echo $resp['notified'];  ?></td>
                    </tr>
                    <?php
                    $c++;
                    }
                }catch(Exception $ex){
                    //echo $ex->getMessage().' - '.$ex->getFile().' - on line'.$ex->getLine();
                }
                ?>
            </table>
        </div>
        </div>
        </div>  
    </div>
    <div>
    
    </div>
</div>
</body>
</html>
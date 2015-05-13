<!DOCTYPE HTML>
<html lang="en">
<head>
    <?php include 'view/scripts2.php'; ?>
    <style>
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        border-top: 1px solid #ddd;
        line-height: 1.42857;
        padding: 1px;
        font-size: 12px;
        border-right: 1px solid #ddd;
    }
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
        <div class="panel-heading text-center"><strong>Users</strong></div>
        <div class = "panel-body panel-body-fix">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <td><strong>Name</strong></td>
                        <td><strong>Email</strong></td>
                        <td><strong>Store</strong></td>
                        <td><strong>Created at</strong></td>
                        <td><strong>begin</strong></td>
                        <td><strong>expire</strong></td>
                        <td><strong>Paid</strong></td>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach($data['users'] as $key=>$user){
                ?>
                <tr>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['store_url']; ?></td>
                    <td><?php echo $user['date']; ?></td>
                    <td><?php echo $user['pay_begin']; ?></td>
                    <td><?php echo $user['pay_expire']; ?></td>
                    <td><?php echo $user['paid']; ?></td>
                </tr>
                <?php    
                }
                ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>

</div>
</body>
</html>
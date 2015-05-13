<?php
$active = (!empty($active))?$active:'';
?>
<div class="page-header" style="position: relative;">
    <img src="<?php echo BASE_URL?>assets/img/logo.jpg" />
    <div class="btn-help">
        <div class="btn-group">
            <button class="btn btn-info btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
            help<span class="caret"></span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo BASE_URL; ?>contact">Contact Us</a></li>
          </ul>
        </div>
    </div>
    <div style="position: absolute; right: 0; bottom:10px;">
                <span class="bg-info"><?php echo EXPIRE; ?> </span><a class="btn btn-warning" href="<?php echo BASE_URL; ?>admin-billing">
				    <span class="shortcut-label">Billing</span>
				</a>
    </div>
</div>
<script type="text/javascript">

</script>
<!--</a><h3 class="text-center page-header">DASHBOARD</h3>-->
    
        <div class="widget-content line1">
            <div class="shortcuts">
                <a class="shortcut <?php echo ($active=='pending')?'btn active':$active;?>" href="<?php echo BASE_URL; ?>admin-pending">
                    <!--<i class="glyphicon glyphicon-bookmark"></i><br />-->
                    <span class="shortcut-label">Pending Notification</span>								
                </a>
                <a class="shortcut <?php echo ($active=='notified')?'btn active':$active;?>" href="<?php echo BASE_URL; ?>admin-notified">
                    <!--<i class="glyphicon glyphicon-ok"></i><br />-->
                    <span class="shortcut-label">Notified Products</span>								
                </a>
                <a class="shortcut <?php echo ($active=='products')?'btn active':$active;?>" href="<?php echo BASE_URL; ?>admin-products">
					<!--<i class="glyphicon glyphicon-stats"></i><br />-->
				    <span class="shortcut-label">Products Stats</span>
				</a>
                <a class="shortcut <?php echo ($active=='subscribed')?'btn active':$active;?>" href="<?php echo BASE_URL; ?>admin-subscribed">
					<!--<i class="glyphicon glyphicon-user"></i><br />-->
				    <span class="shortcut-label">Subscriber List</span>
				</a>
                <a class="shortcut <?php echo ($active=='mailchimp')?'btn active':$active;?>" href="<?php echo BASE_URL; ?>admin-mail">
					<!--<i class="glyphicon glyphicon-envelope"></i><br />-->
				    <span class="shortcut-label">Customize Email</span>
				</a>
                <a class="shortcut <?php echo ($active=='popup')?'btn active':$active;?>" href="<?php echo BASE_URL; ?>admin-popup">
					<!--<i class="glyphicon glyphicon-folder-close"></i><br />-->
				    <span class="shortcut-label">Edit Button CSS</span>
				</a>
                <a class="shortcut <?php echo ($active=='install')?'btn active':$active;?>" href="<?php echo BASE_URL; ?>admin-install">
					<!--<i class="glyphicon glyphicon-wrench"></i><br />-->
				    <span class="shortcut-label">Installation Instructions</span>
				</a>
                <?php if (IS_PUBLIC == false){?>
                <a class="shortcut" href="<?php echo BASE_URL; ?>logout">
                    <!--<i class="glyphicon glyphicon-log-out"></i><br />-->
                    <span class="shortcut-label">Log out</span>								
                </a>
                <?php }?>
            </div>
            
        </div>
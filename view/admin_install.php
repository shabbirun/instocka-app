<!DOCTYPE HTML>
<html lang="en">
<head>
    <?php include 'view/scripts2.php'; ?>
    
</head>
<?php


?>
<body>
<div id="wrapper">
    <div class="wrapper">
    
    <?php include 'view/panel_head.php';?>
        <div class="panel panel-default panel-fix">
        <div class="panel-heading text-center"><strong>Installation Instructions</strong></div>
<div class = "panel-body panel-body-fix">
<iframe width="420" height="315" src="https://www.youtube.com/embed/8VkNXjRwha0" frameborder="0" allowfullscreen></iframe>
   <p>Thanks for signing up for InStockAlerts! To get everything working properly, you'll need to copy a few files into your store and copy/paste a little bit of code. If you'd like us to handle the technical stuff for you, please <a href="<?php echo BASE_URL; ?>contact">contact us</a> and we'll take care of it for you ASAP!</p><p>To do it yourself, you'll need to download <a href="<?php echo BASE_URL; ?>resource/files/files.zip" target="_blank">these files</a> and upload them to your store's directory using WebDAV. To learn how to use WebDAV, <a href ="https://support.bigcommerce.com/questions/1513/How+do+I+connect+to+WebDAV%3F" target="_blank">check out this tutorial</a>.</p><p>Then follow the instructions below and you are all set!</p> </div>
        <div class="panel-body panel-body-fix">
        <div class="texts">
            <h3>Step 1</h3>
<p>In your Bigcommerce store, head over to the link in the top right that says "Design".</p>
<img src ="<?php echo BASE_URL; ?>assets/_shared/img/design.png">
<h3>Step 2</h3>
<p>Next, click the large button that says "WebDAV", and download the CyberDuck connection file. If you already have CyberDuck installed, by running the file you just downloaded, you will automatically connect to your store's file directories.</p>
<img src ="<?php echo BASE_URL; ?>assets/_shared/img/webdav.png" width="860">
<img src ="<?php echo BASE_URL; ?>assets/_shared/img/cyberduck.png">
<h3>Step 3</h3>
<p>From the files.zip file you downloaded, copy the ProductInStockAlerts.html file to the "Panels" folder in your store, and three files magnific-popup.css, jquery.magnific-popup.min.js and ajax-loader.gif to the "Styles" folder.</p>
<img src = "<?php echo BASE_URL; ?>assets/_shared/img/copiedfiles.png">
<h3>Step 4</h3>
<p>Now head back to the design area of your store, and click the large button that says "Edit HTML/CSS." A new window will open up, and you'll see your store's files and code. Hit Ctrl-F(or command-F on a Mac) and type "HTMLhead" - you'll see that file highlighted. Click it, and in the file, right around line 60 where the batch of code ends, paste the following code:</p>
<pre>&lt;link rel="stylesheet" type="text/css" href="/template/Styles/magnific-popup.css"&gt;
            &lt;script src="/template/Styles/jquery.magnific-popup.min.js"&gt;&lt;/script&gt;</pre>
<img src = "<?php echo BASE_URL; ?>assets/_shared/img/htmlcss.png" width="860">
<img src = "<?php echo BASE_URL; ?>assets/_shared/img/htmlone.png" width="860">
<p>Click save, and thats it for this step.</p>
<h3>Step 5</h3>
<p>Next, hit Ctrl-F(or Command-F) again and search for "ProductAddToCart.html". Once you have that open, scroll all the way to the bottom, and paste this code after all of the existing code:</p>
<pre>&lt;!--NOTIFY ME--&gt;
         &lt;div id=&quot;instock-notify-box&quot;&gt;
            &lt;div class=&quot;instock-form&quot;&gt;
                &lt;ul&gt;
                     &lt;li&gt;
                      Enter your email address to be notified&lt;br/&gt;
                      when this item is back in stock
                     &lt;/li&gt;
                      &lt;li&gt;
                        &lt;input type=&quot;email&quot; value=&quot;&quot; placeholder=&quot;Email Address&quot; name=&quot;EMAIL&quot; id=&quot;mail&quot; class=&quot;nwsletter&quot; /&gt;
                      &lt;/li&gt;
                      &lt;li style=&quot;display: none;&quot;&gt;
                        &lt;input type=&quot;text&quot; placeholder=&quot;First Name&quot; name=&quot;FNAME&quot; id=&quot;FNAME&quot; class=&quot;nwsletter&quot; value=&quot;&quot; /&gt;
                      &lt;/li&gt;
                      &lt;li style=&quot;display: none;&quot;&gt;
                        &lt;input type=&quot;text&quot; placeholder=&quot;Last Name&quot; name=&quot;LNAME&quot; id=&quot;LNAME&quot; class=&quot;nwsletter&quot; value=&quot;&quot; /&gt;
                      &lt;/li&gt;
                      &lt;li&gt;
                        &lt;input type=&quot;hidden&quot; name=&quot;product_id&quot; id=&quot;product_id&quot; value=&quot;%%GLOBAL_ProductId%%&quot; /&gt;
                        &lt;input type=&quot;hidden&quot; name=&quot;product_stock&quot; id=&quot;product_stock&quot; value=&quot;0&quot; /&gt;
                        &lt;input type=&quot;hidden&quot; name=&quot;product_title&quot; id=&quot;product_title&quot; value=&quot;%%GLOBAL_ProductName%%&quot; /&gt;
                        &lt;input type=&quot;hidden&quot; name=&quot;store_url&quot; id=&quot;store_url&quot; value=&quot;%%GLOBAL_ShopPath%%&quot; /&gt;
                        &lt;input type=&quot;hidden&quot; name=&quot;&quot; id=&quot;admin_email&quot; value=&quot;%%GLOBAL_AdminEmail%%&quot; /&gt;
                        &lt;input type=&quot;hidden&quot; name=&quot;product_sku&quot; id=&quot;product_sku&quot; value=&quot;&quot; /&gt;
                        &lt;input type=&quot;button&quot; class=&quot;btn newsletter&quot; value=&quot;NOTIFY ME&quot; name=&quot;subscribe&quot; id=&quot;instock-subscribe&quot; /&gt;
                      &lt;/li&gt;
                      &lt;li&gt;
                        &lt;div class=&quot;msg-inst&quot;&gt;
                          &lt;div class=&quot;form-popup-msg&quot;&gt;
                            &lt;div class=&quot;msg-content&quot; &gt;
                              &lt;div class=&quot;msg&quot;&gt;&lt;img src=&quot;/template/Styles/ajax-loader.gif&quot; /&gt;&lt;/div&gt;
                            &lt;/div&gt;  
                          &lt;/div&gt;
                        &lt;/div&gt;
                      &lt;/li&gt;
                &lt;/ul&gt;
                &lt;/div&gt;
         &lt;/div&gt;
         &lt;!--NOTIFY ME END--&gt;
%%Panel.ProductInStockAlerts%%</pre>
<p>You are good to go! Time to recover some lost sales!</p>
        </div>
        <br />
        </div>  
    </div>
    <div>
    
    </div>
</div>
</body>
</html>
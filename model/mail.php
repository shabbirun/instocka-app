<?php

class mail{
    
    public function __construct(){
        
    }
    
    public function view_mail(){
        
    }
    
    public function sendMail($data){
        $cont = 0;
        /**
         * 
          $data = array('From'=>'programmer1@apolomultimedia.com',
                        'FromName'=>'bigcommerce store',
                        'AddAddress'=>array('<mig1098@hotmail.com>','mig1098@hotmail.com'),
                        'AddReplyTo'=>array('programmer1@apolomultimedia.com','Webmaster'),
                        'Subject'=>,
                        'Body'=>
                        );
          
         * 
         * */
    		$mail = new PHPMailer();
            //$mail->SMTPSecure = 'ssl'; 
    		//$mail->IsSMTP();                                      // set mailer to use SMTP
    		//$mail->Host = "smtp.gmail.com";  // specify main and backup server //192.168.200.246
    		//$mail->SMTPAuth = true;     // turn on SMTP authentication
    		//$mail->Port = 587;//25
    		//$mail->Username = "mig1098@gmail.com";//website@etna.com.pe
    		//$mail->Password = "TDA2004lm350klm";//Etna1234sa
    		$mail->From = $data['From'];//"programmer1@apolomultimedia.com";//website@etna.com.pe
    		$mail->FromName = $data['FromName'];//"bigcommerce store";//ETNA website
    		$mail->AddAddress($data['AddAddress'][0],$data['AddAddress'][1]);//("<mig1098@hotmail.com>", "mig1098@hotmail.com");
    		if($cont==0){
                //$mail->AddAddress("aplicaciones@etna.com.pe");
            }
    		$mail->AddReplyTo($data['AddReplyTo'][0],$data['AddReplyTo'][1]);//("programmer1@apolomultimedia.com","Webmaster" );
    		$mail->WordWrap = 300;                                 // set word wrap to 50 characters
    		//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
    		//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional namea2
    		$mail->IsHTML(true);                                  // set email format to HTML
    		$mail->Subject = $data['Subject'];//CONTACTFORM;
            $mail->Body = $data['Body'];
    		//$mail->AltBody = "esta es una prueba mauricio, si te llego solo responde.. ok confirmado..";
            $headers = 'From: '.$data['FromName'].' '.$data['From'] . "\r\n" ;
            $headers .='Reply-To: '. $data['AddReplyTo'][1] . "\r\n" ;
            $headers .='X-Mailer: PHP/' . phpversion();
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/plain\r\n";   
            //$mail->AddCustomHeader($headers);
    		if(!$mail->Send())
    		{
    		   //echo "<p>El mensaje no fue enviado, volver a intentar. </p>";
    		   //echo "Mailer Error: " . $mail->ErrorInfo;
               throw new \Exception("Mailer Error: " . $mail->ErrorInfo);
    		   //exit;
    		}else{
    		  echo '<br >message sent';
              return true;
    		}
    }
    
    public function simpleSend($data){
        $cont = 0;
    		$mail = new PHPMailer();
    		$mail->From = $data['From'];//"programmer1@apolomultimedia.com";//website@etna.com.pe
    		$mail->FromName = $data['FromName'];//"bigcommerce store";//ETNA website
    		$mail->AddAddress($data['AddAddress'][0],$data['AddAddress'][1]);//("<mig1098@hotmail.com>", "mig1098@hotmail.com");
    		if($cont==0){
                //$mail->AddAddress("aplicaciones@etna.com.pe");
            }
    		$mail->AddReplyTo($data['AddReplyTo'][0],$data['AddReplyTo'][1]);//("programmer1@apolomultimedia.com","Webmaster" );
    		$mail->WordWrap = 300;                                 // set word wrap to 50 characters
    		//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
    		//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional namea2
    		$mail->IsHTML(true);                                  // set email format to HTML
    		$mail->Subject = $data['Subject'];//CONTACTFORM;
            $mail->Body = $data['Body'];
    		//$mail->AltBody = "esta es una prueba mauricio, si te llego solo responde.. ok confirmado..";
            $headers = 'From: '.$data['FromName'].' '.$data['From'] . "\r\n" ;
            $headers .='Reply-To: '. $data['AddReplyTo'][1] . "\r\n" ;
            $headers .='X-Mailer: PHP/' . phpversion();
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/plain\r\n";   
            //$mail->AddCustomHeader($headers);
    		if(!$mail->Send())
    		{
               throw new \Exception("Mailer Error: " . $mail->ErrorInfo);
    		}else{
    		  //echo '<br >message sent';
              return true;
    		}
    }
    
    public function testMail(){
        $mail=new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true; // enable SMTP authentication
        //$mail->SMTPSecure = "ssl"; // sets the prefix to the servier
        //$mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
        $mail->Host = "192.168.200.246";
        //$mail->Port = 465; // set the SMTP port 
        $mail->Port = 25;
        $mail->Username = "website@etna.com.pe"; // GMAIL username
        $mail->Password = "Etna1234sa"; // GMAIL password
        
        $mail->From = "website@etna.com.pe";
        $mail->FromName = "Webmaster";
        $mail->Subject = "This is the subject";
        $mail->Body = "Hi,<br>This is the HTML BODY<br>"; //HTML Body
        $mail->AltBody = "This is the body when user views in plain text format"; //Text Body
        
        $mail->WordWrap = 50; // set word wrap
        
        $mail->AddAddress("mig1098@hotmail.com","First Last");
        $mail->AddReplyTo("mig1098@gmail.com","Webmaster" );
        //$mail->AddAttachment("/path/to/file.zip"); // attachment
        //$mail->AddAttachment("/path/to/image.jpg", "new.jpg"); // attachment
        
        $mail->IsHTML(true); // send as HTML
        
        if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
        echo "Message has been sent";
        }
    }
}

?>
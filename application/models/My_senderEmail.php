<?php 

require_once './vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
require_once './config_mail.php';
	Class My_senderEmail extends CI_Model{


		public function send($exp, $dest,$adress_id, $nom, $sujet, $message, $fichier, $type){
		
			$mail = new PHPMailer;
			
			
			//$mail->SMTPDebug = 3;                               // Enable verbose debug output

			$mail->isSMTP();  
                       		// Set mailer to use SMTP
			$mail->Host = SMTP_HOST;  								// Specify main and backup SMTP servers
			$mail->SMTPAuth = SMTP_AUTH;
			$mail->Port = SMTP_PORT;
			$mail->Username = SMTP_USERNAME;  // SMTP username
			$mail->Password = SMTP_PASSWORD; // SMTP password                               // Enable SMTP authentication
		                         								 	// Enable TLS encryption, `ssl` also accepted
		                         								 	 // TCP port to connect to
			$mail->CharSet = 'UTF-8';
			$mail->setFrom($exp);
			$mail->addAddress($dest);     
			$mail->addReplyTo($exp);


			if(!empty($fichier)){
				foreach ($fichier as $fich) {
					
					$mail->addAttachment("./public/uploads/pieces_jointes/".$fich->fichier_uri, $fich->original_name);  
				}
			}

			                                // Set email format to HTML

			$mail->Subject = $sujet;
			$mail->Body    = $message;
			$mail->Body    .="<p style='font-size : 11px; color:grey; text-align : center;'>pour vous désabonner <a href=".base_url().'disable/abo/'.$adress_id.">cliquer ici</a></p><input type='hidden' value='$dest' name='email'/>";
			$mail->AltBody =  strip_tags($message);
			
			if($type === "html"){
				
				$mail->isHTML(true);  
			}
			if($type === "text"){
				$mail->ContentType = 'text/plain'; 
    			$mail->isHTML(false);

			}

			if(!$mail->send()) {
			    
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
			    
			}
		}
	}
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>EnvoiMail 1.0.4</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="<?php echo base_url('public/css/style.css') ?>">
    </head>
    <body>
    	<div class="home">
	    	<div class="wrapper">
	    		<header class="main-header" data-token ="<?php if(!empty($token)) echo "$token"; ?>">
	    			<div class="wrapper">
			        	<a href="<?php echo base_url('/home') ?>"><h1 id="title">Envoi<span class="blue">Mail@</span></h1></a>
					</div>
					<a class="admin-board" href="<?php echo base_url('dashboard') ?>">Panneau de configuration</a>
				<?php 
				
				if(isset($_SESSION['mail_sended']) && $_SESSION['mail_sended'] === true ){
					echo "<div class=\"alert \" role=\"alert\">
						  <p>Les messages ont bien été envoyés ! <a href=\".send-renderer\" class=\"alert-link js-scrollTo\">Cliquez ici pour voir le nombre de messages envoyés</a></p>
						</div>";
					unset($_SESSION['mail_sended']);
				}
					
				 ?>
				
		        </header>
		        <form class="indexForm" method='post' enctype='multipart/form-data' action='<?php echo base_url("dashboard/adress/$token/delete/upload") ?>' >
			        <section class="dest">
			        	<div class="wrapper">
				        	<h2 class="title-form">Destinataires</h2><div class="container">
				        		<label for="dest">listes des destinataires</label>		        		
								<select name="dest" class="field">
									<?php  
					        			if(!empty($dest_list) || isset($dest_list)){
					        				
					        				foreach ($dest_list as $dest) {
					        					if(!empty( $dest_mail_base) || isset($dest_mail_base)){
					        						if($dest->libelle === $dest_mail_base){

					        						echo "<option  value=\"$dest->libelle\" selected = 'selected' >$dest->libelle </option>";

						        					}
						        					else{
						        						echo "<option value=\"$dest->libelle\">$dest->libelle</option>";
						        					}
					        					}
					        					else{
					        						echo "<option value=\"$dest->libelle\">$dest->libelle</option>";
					        					}
									}
					        			}
					        			else {
					        				echo "pas de destinataire enregistré";
					        			}
									?>
									
								</select></div>
				        	<a href="#" class="add_receive_button">+</a>

				        </div>	
			        </section>			  
			        <section class="header">
				        <div class="wrapper">
				        	<h2 class="title-form">En tête</h2><div class="container">
				        	<label for="subject">sujet de l'email</label>
							<input type="text" class="field" id="subject" name="subject" placeholder="ex: Demande de mission" <?php if(!empty($mail_subject)) echo "value=\" $mail_subject\"" ?>required >
							<label for="expediant">Nom de l'expediteur</label>
							<input type="text" class="field" id="expediant" name="expediant" placeholder="ex: Mr John Doe" <?php if(!empty($mail_sender)) echo "value=\" $mail_sender\"" ?>required>
							<label for="email-expediant">Email de l'expediteur</label>
							<input type="text" class="field" id="email-expediant" name="email-expediant" placeholder="ex: johndoe@test.com"<?php if(!empty($mail_sender_email)) echo "value=\" $mail_sender_email\"" ?>required></div>
						</div>
			        </section>
			        <section class="mail-type">
			        	<div class="wrapper">
				        	<h2 class="title-form">Type de mail</h2><div class="container">
				        	<label for="mail_type" class="hidden">importer ou écrire un mail</label>
				        	<?php 
				        		if(!empty($mail_type) && isset($mail_type)){
				        			
				        			if($mail_type === "text"){
				        				echo " 
						        			<input type=\"radio\" value=\"html\" name=\"mail_type\" class=\"type\" > type html
											<input type=\"radio\" value=\"text\" name=\"mail_type\" class=\"type\" checked > type text 
											";
				        			}
				        			else if($mail_type === "html"){
				        				echo " 
						        			<input type=\"radio\" value=\"html\" name=\"mail_type\" class=\"type\" checked > type html
											<input type=\"radio\" value=\"text\" name=\"mail_type\" class=\"type\" > type text 
											";
				        			}
				        			
				        		}
				        		else{
				        			
				        			echo " 
					        			<input type=\"radio\" value=\"html\" name=\"mail_type\" class=\"type\" checked > type html
										<input type=\"radio\" value=\"text\" name=\"mail_type\" class=\"type\" > type text 
										";
				        		}


				        	 ?>
						</div>
			        </section>
			        <section class="mail">
			        	<div class="wrapper">
				        	<h2 class="title-form">Mail</h2><div class="container">
				        	<label for="file">Pièces Jointes</label>

							<input type="file" class="file" name=" pieces[]" multiple>

							<?php 

								if(!empty($upload_file['type'][0]) || isset($upload_file)){
								
										
									foreach ($upload_file as $file_name) {
										
										echo "<div class=\"atach\"><img width=\"25px\" height=\"25px\"src=".base_url('public/css/attach.png')." alt=\"image en apreçu des pièces jointes\"><p>".$file_name->original_name ."</p></div>";
									
									}
									echo " <button class=\"btn btn-default\" type=\"submit\" data-token=\" $token\" data-type=\"upload\">X</button>";
								}
							 ?>

							</div>
							<textarea name='editor1' class='editor1' required><?php if(!empty($mail_text)||isset($mail_text)) echo $mail_text; 
								if(!empty($signature)){
									echo"<br><img src=".base_url()."public/uploads/pieces_jointes/".$signature." alt='signature du membre connecter'>";
								}

							?></textarea>
							<button type="submit" class="validate sav_mail">valider</button>
						</div>
			        </section>
			        
			        <section class="send">
			        	<div class="wrapper">
				        	<h2 class="title-form">Envoi</h2><div class="container">
				        	<p>Etat du mail <span class="under">
				        				<?php  if(!empty($mail_status) || isset($mail_status)){
					        					if($mail_status == "0"){
					        						echo "Attention ce mail n'a pas encore été testé";
					        					}
					        					if($mail_status == "1"){
					        						echo "Ce mail à été testé";
					        					}
				        					} 
				        					else{
				        						echo"Valider votre mail avant de l'envoyé";
				        					}
				        				?>
				        			</span> 
				        	</p>
				        	<button type="submit" class="send-button">Envoyer</button></div>
				        </div>
			        </section>
			        <section class="send-renderer">
			        	<div class="wrapper">
				        	<h2 class="title-form">Compte rendu d'envoi</h2><div class="container">
				        	<?php 
				        	if(!empty($logs)){
				        	
				        			echo 
				        					"<p>".count($logs)." envoyés</p>";
				        					// <p>$logs->error error</p></div>";
				        		
				        	}

				        	 ?>
				        	
				        </div>
				    </section>
				</form>
			</div>
		</div>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <script src="<?php echo base_url('public/js/jquery-1.11.2.min.js')?>"></script>
        <script src="<?php echo base_url('public/js/plugin/ckeditor/ckeditor.js')?>"></script>
        <script src="<?php echo base_url('public/js/main.js')?>"></script>
        <script type="text/javascript">
        	
        	$(document).ready(function(){
        		CKEDITOR.replace( 'editor1' );
        	});
        </script>
    </body>
</html>

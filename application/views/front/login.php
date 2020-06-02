<!DOCTYPE html>
<html>
<head>
	<title>login</title>
	<link href="<?php echo base_url('vendor/twbs/bootstrap/dist/css/bootstrap.min.css'); ?>" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url('public/css/style.css') ?>">
</head>
<body>
	
		<div class="login">
			<header class="main-header" >
	    			<div class="wrapper">
			        		<h1 class="title">EnvoiMail 1.0.4</span></h1>
				</div>
		        </header>
			<?php echo validation_errors(); ?>
			<?php echo form_open('checkLogController'); ?>
				
				<div class="wrapper">
					<label for="identifiant">IDENTIFIANT</label>
					<input type="text" id="identifant" name= "identifiant" class="form-control"></input>
					<label for="mdp">MOT DE PASSE</label>
					<input type="password" id="mdp" name= "mdp" class="form-control"></input>
					<button type="submit" class="btn btn-default">connection</button>
				</div>

			</form>
		</div>
	</div>
</body>
</html>
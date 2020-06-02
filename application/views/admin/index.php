<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>EnvoiMail 1.0.4</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url('vendor/twbs/bootstrap/dist/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('public/css/style.css') ?>">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

  	
  		  <?php include('./application/views/partials/partial.header-admin.php'); ?>
        
        <div class="dashboard wrapper">
        <?php include('./application/views/partials/partial.nav.php'); ?>
        <form class="adminForm" method='post' enctype='multipart/form-data' action='' >
        			<div class="row">
        				<div class="col-xs-1 center-block title">type</div>
        				<div class="col-xs-2 center-block title">sujet</div>
        				<div class="col-xs-2 center-block title">date d'envoi</div>
        				<div class="col-xs-1 center-block title">status</div>
        				<div class="col-xs-3 center-block title">email</div>
        				<div class="col-xs-2 center-block title">nom</div>
                <div class="col-xs-1 center-block title">option</div>
        				
              </div>
            <?php

                foreach ($mail as $m) {

                    if ( $m->status == 1 ){
                      $m->status = "testé";

                    }
                    elseif($m->status == 0){
                      $m->status = "pas testé";
                    }
                  echo " <a href=\"saved_mail/$m->token\"><div class=\"row row\" >
                          <div class=\"col-xs-1 center-block rowData\">$m->type</div>
                          <div class=\"col-xs-2 center-block rowData\">$m->sujet</div>
                          <div class=\"col-xs-2 center-block rowData\">$m->date_envoi</div>
                          <div class=\"col-xs-1 center-block rowData rowStatus\" data-test=\"$m->status\">$m->status</div>
                          <div class=\"col-xs-3 center-block rowData\">$m->email</div>
                          <div class=\"col-xs-2 center-block rowData\">$m->nom</div>
                          <div class=\"col-xs-1 center-block rowData\"><button class=\" btn btn-default delete\" data-token=\"$m->token\" data-type=\"mail\">supprimer</button></div>
                        </div></a>";
                }
             ?>
        </form>
 
		
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url('public/js/jquery-1.11.2.min.js');?>"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('vendor/twbs/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>

     
    <script src="<?php echo base_url('public/js/plugin/ckeditor/ckeditor.js')?>"></script>
    <script src="<?php echo base_url('public/js/main.js')?>"></script>
  </body>
</html>
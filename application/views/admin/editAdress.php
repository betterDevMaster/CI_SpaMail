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
        <div class="dashboardList wrapper">
        <?php include('./application/views/partials/partial.nav.php'); ?>
        <p> editer <?php echo $adress[0]->nom; ?></p>
        <form class="editFormAdress" method='post' enctype='multipart/form-data' action='<?php echo base_url('dashboard/edit_list').'/'.$adress[0]->id.'/saveAdress' ?>' >
        			<div class="row">

        				<div class="col-xs-4 center-block title">email</div>
                <div class="col-xs-4 center-block title">nom</div>
                <div class="col-xs-4 center-block title">prenom</div> 

        				
              </div>
            <?php
                foreach ($adress as $ad) {
                         
                            echo "<div class=\"row\">
                                    <div class=\"col-xs-4 center-block editable rowData\">
                                        $ad->email
                                        <input type=\"hidden\" value=\"$ad->email\" name= \"email\"></input>

                                    </div>
                                    <div class=\"col-xs-4 center-block editable rowData \">
                                      $ad->nom
                                      <input type=\"hidden\" value=\"$ad->nom\" name= \"nom\"></input>

                                    </div>
                                    <div class=\"col-xs-4 center-block editable rowData \">

                                      $ad->prenom
                                      <input type=\"hidden\" value=\"$ad->prenom\" name= \"prenom\"></input>

                                    </div>
                                    
                                </div>
                                
                                
                               
                                ";
                      }
             ?>
        </form>

        <a class=" back-page" href="<?php echo base_url( 'dashboard/adress/')?>"> <- retour </a>

		
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url('public/js/jquery-1.11.2.min.js');?>"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('vendor/twbs/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>

     
    <script src="<?php echo base_url('public/js/plugin/ckeditor/ckeditor.js')?>"></script>
    <script src="<?php echo base_url('public/js/main.js')?>"></script>
  </body>
</html>
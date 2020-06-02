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

        <form class="adminForm" method='post' enctype='multipart/form-data' action="<?php if(!empty($list)) echo base_url('dashboard/adress').'/' ?>"  >
              <label for="dest">listes des destinataires</label>
              <p class="warning">choisir une liste pour voir les details</p>
        			<select name="libelle" class="field form-control" onchange="this.form.submit()">
               
                  <?php  
                        if(!empty($list_select) || isset($list_select)){
                          echo "<option value=\"$list_select\" selected>$list_select</option>";
                        }
                        else{
                          echo "<option> selectionner une liste .... </option>";
                        }
                        if(!empty($list) || isset($list)){
                          
                          foreach ($list as $l ){
                        
                            echo "<option value=\"$l->libelle\">$l->libelle</option>";
                      
                          }
                        }
                        else {
                          echo "pas de destinataire enregistré";
                        }
                  ?>
                  
                </select>
                <?php 
                  if(!empty($list_select) || isset($list_select)){

                           echo " <button class=\"btn btn-default deleteAd\" data-token=\"$list_select\" data-type=\"list\">supprimer</button>";
                        
                  }
                ?>
                
                <?php 
                  if(!empty($adress) || isset($adress)){
                      echo "<p>contacts pour $list_select <a style =\"color:blue; text-decoration : underline;\" href =\".back-page\" class=\"js-scrollTo down\"> aller en bas</a></p>
                            <div class=\"row\">
                              <div class=\"col-xs-3 center-block title\">email</div>
                              <div class=\"col-xs-3 center-block title\">nom</div>
                              <div class=\"col-xs-2 center-block title\">prenom</div>
                              <div class=\"col-xs-2 center-block title\">abonné</div> 
                              <div class=\"col-xs-2 center-block title\">options</div>      
                            </div>";
                            $i = 0;
                      foreach ($adress as $ad) {
                         $i++;
                            if($ad->abonnee == 1){
                              $ad->abonnee = 'oui';
                            }
                            else{
                              $ad->abonnee = 'non';
                            }
                            echo "<a href=\"edit_list/$ad->id\" class='hide-adress'><div class=\"row row".$i."\">
                                    <div class=\"col-xs-3 center-block rowData\">$ad->email</div>
                                    <div class=\"col-xs-3 center-block rowData \">$ad->nom</div>
                                    <div class=\"col-xs-2 center-block rowData \">$ad->prenom</div>
                                    <div class=\"col-xs-2 center-block rowData \">$ad->abonnee</div>
                                    <div class=\"col-xs-2 center-block rowData \"><button class=\"btn btn-default deleteAd\" data-token=\"$ad->id\" data-type=\"adress\">supprimer</button></div>        
                                </div></a>";
                      }
                  }

                 ?>
                  <div class="row">
                          <div class="col-xs-3 center-block email_input rowData">                                                       
                          </div>

                          
                          <div class="col-xs-3 center-block nom_input  rowData ">
                          </div>
                          <div class="col-xs-2 center-block prenom_input rowData ">
                            
                            
                          </div>
                          <div class="col-xs-2 center-block abonnee_input rowData ">
                            
                            
                          </div>
                          
                          <div class="col-xs-2 center-block option_input rowData">
                           
                            
                          </div>
                    </div>

                    <button class="btn btn-default add_adress_button" type="submit">+</button>
        </form>
        <a class="back-page btn btn-default" href="<?php echo base_url('dashboard/list/pannel') ?>"> ajouter une liste de destinataire </a>
 
		
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url('public/js/jquery-1.11.2.min.js');?>"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('vendor/twbs/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>

     
    <script src="<?php echo base_url('public/js/plugin/ckeditor/ckeditor.js')?>"></script>
    <script src="<?php echo base_url('public/js/main.js')?>"></script>
  </body>
</html>
'use strict'; // use strict mode of js
$(document).ready(function(){

	
	switchForm('.indexForm','.add_receive_button','add_receive.php');//form, button, url
	switchForm('.indexForm','.sav_mail','saved_mail');

	
	

	checkDelete('.delete');
	checkDelete('.deleteAd');
	

	editAdress();
	addListPannel('.add_list_button');
	addListPannel('.add_adress_button',true);
	sendMessage();
	canSend();
	hideAdress();
	$('.js-scrollTo').on('click', function() { // Au clic sur un élément
			$('.row').css('display','block');
			var self =$(this);
			window.setTimeout(function(){
				var page = self.attr('href'); // Page cible
				var speed = 750; // Durée de l'animation (en ms)
				$('html, body').animate( { scrollTop: $(page).offset().top }, speed ); // Go
				$('.alert').css('display','none');

			},500);
			return false;
			

		
		

	});

	
	
});
function sendMessage(){
	$('.send-button').on('click',function(evt){
		evt.preventDefault();
		var $form = $('.indexForm')
		var $token = $('.main-header').attr('data-token');

		if($token != undefined && $token !=null ){
			$form.attr('action','send_test/'+$token);
			$form.submit();
		}
		
	})
}
//change action form, button, url
function switchForm(form, button, newUrl){
	var url = window.location.href;
	var part = url.split("/");
	var edit_mode = false;
	var $token = $('.main-header').attr('data-token');
	
	var $form = $(form);
	var $button = $(button);
	

	if(part[part.length-1] === $token ){
		edit_mode = true;
	}
	$button.on('click',function(){//when we click on  button we change action url form
		if(edit_mode === false){
			$form.attr('action',newUrl);
			
		}
		else{
			$form.attr('action', window.location.href + '/edit');
		}
	});
}
function checkDelete(idButton){
	var $button = $(idButton);
	var confirmMsg = '<p>êtes vous sur de vouloir supprimer cet élément</p>';
	var choice = '<button class="btn btn-default" id="deleteYes" type="submit">oui</button><button class="btn btn-default" id="deleteNo" >non</button>';
	var $msg = '<div id="confirmMsg">'+confirmMsg+choice+'</div>';
	var $id =null;
	var $url = null;


	$button.on('click', function(evt){
		evt.preventDefault();
		
		var $id_html = $(this).attr('class').split(' ');
		$id = $(this).attr('data-token');
		var $type = $(this).attr('data-type');

		if($msg !=undefined && $msg!= null && $msg!=""){

			$(this).css('display','none')
			$(this).after($msg);
			var $confirmMsg = $('#confirmMsg');
			var $yes = $('#deleteYes');
			var $no = $('#deleteNo');

			$no.on('click',function(evt){
				
				evt.preventDefault();
				$confirmMsg.remove();
				$button.css('display','block')
			});
			$yes.on('click', function(evt){
				evt.preventDefault();
				if( $id_html[$id_html.length-1] ==='delete'){
					$url = 'dashboard/adress/'+$id+'/delete/'+$type;
					
					// $('.adminForm').attr('action','dashboard/'+$id+'/delete/'+$type);
				}
				if( $id_html[$id_html.length-1] === 'deleteAd'){

					$url = $id+'/delete/'+$type;
					
					

					// $('.adminForm').attr('action', $id+'/delete/'+$type);
				}

				$.ajax({
					url: $url,
					type:'POST',
					data: $('.adminForm').serialize(),
					success: function(msg)
					{
						if($type ==='mail'){
							window.location = window.location.href;
						}
						if($type === 'list'){
							window.location = window.location.href;
						}
						if($type === 'adress'){
							$yes.parent().parent().parent().remove();
						}
						
					},
					error : function(msg) {
						console.log(msg);
					}
    				});
			});
			
		}
		else{
			alert('script error');
		}
	})
}
function hideAdress(){
	var $count_row = $('.row');
	var slicy = 20;
	var $row_visible = [];
	if($count_row.length>20){

		for (var i =0; i<$count_row.length; i++){
			$row_visible +=$count_row[i];
			if(i>20){

				$count_row[i].style='display : none';
			}
		}

	}
	$(window).scroll(function() {
		
		
		var $count_row = $('.row')

		
		if($(window).scrollTop() + $(window).height() == $(document).height()) {
			
			var $count_row = $count_row.slice(slicy);
			for(var i = 0; i<$count_row.length;i++){
				if(i<20){
					$count_row[i].style="display:block";
					
					
				}
			}
			slicy +=20;
		}
	});

}
function editAdress(){

	var $elem = $('.editable');
	var check = false;

	$elem.on('click',function(){
		var newVal = null;
		newVal = prompt('entrer votre nouvelle valeur');

		if(newVal !== null && newVal !== "" && newVal !== " "){
			$(this).find('input').val(newVal);
			check = true;

			
		}


		if(check === true){
			$('.editFormAdress').submit();
		}
		else{
			//message de non coformité de formulaire ici..
		}
	
		
	});
}
function addListPannel(button, submit_mode){
	var $button = $(button);
	var $prenomContainer = $('.prenom_input');
	var $nomContainer = $('.nom_input');
	var $emailContainer = $('.email_input');
	var i = 0; 
	
	if(submit_mode === true){
		var $optionContainer = $('.option_input');
		$button.on('click',function(evt){
			evt.preventDefault();
			

			var prenomInput =  "<input  name=\"prenom["+i+"]\" type=\"text\" class=\" form-control prenom\"placeholder=\"jhon\"></input>"
			var nomInput =  "<input name=\"nom["+i+"]\" type=\"text\" class=\" form-control nom\"placeholder=\"Do\"></input>"
			var emailInput =  "<input name=\"email["+i+"]\" type=\"email\" class=\" form-control email\"placeholder=\"jhondo@hotmail.fr\"required></input>"
			var optionInput =  "<button type=\"submit\" class=\"add-new-adress btn btn-default\">ajouter à la liste</burron>"
			$emailContainer.append(emailInput);
			$nomContainer.append(nomInput);
			$prenomContainer.append(prenomInput);
			$optionContainer.append(optionInput);
			$button.attr('disabled','disabled');

			$('.add-new-adress').on('click',function(evt){

				evt.preventDefault();
				if($('.email').val() == '' || !isValidEmailAddress($('.email').val())){

					alert('veuillez rentrez une email valide');
					return;
				}
				/*var adressContainer = "<a href=\"edit_list/$ad->id\" class='hide-adress'><div class=\"row row".$i."\"><div class=\"col-xs-3 center-block rowData\">$ad->email</div><div class=\"col-xs-3 center-block rowData \">$ad->nom</div><div class=\"col-xs-2 center-block rowData \">$ad->prenom</div><div class=\"col-xs-2 center-block rowData \">$ad->abonnee</div><div class=\"col-xs-2 center-block rowData \"><button class=\"btn btn-default deleteAd\" data-token=\"$ad->id\" data-type=\"adress\">supprimer</button></div></div></a>";*/
			
				$.ajax({

					url: 'add/index',
					type:'POST',
					data: $('.adminForm').serialize(),
					success: function(msg)
					{
						/*$('.row').last().prepend("<a href=\"edit_list/$ad->id\" class='hide-adress'><div class=\"row row\"><div class=\"col-xs-3 center-block rowData\">"+$('.email').val()+"</div><div class=\"col-xs-3 center-block rowData \">"+$('.nom').val()+"</div><div class=\"col-xs-2 center-block rowData \">"+$('.prenom').val()+"</div><div class=\"col-xs-2 center-block rowData \">oui</div><div class=\"col-xs-2 center-block rowData \"><button class=\"btn btn-default deleteAd\" data-token=\"$ad->id\" data-type=\"adress\">supprimer</button></div></div></a>");*/

				
						$('.email').val("");
						$('.nom').val("");
						$('.prenom').val("");
						

						$('form').submit();

					},
					error : function(msg) {
						console.log(msg);
					}
    			});
			});
		i++;	
		})

	}
	else{
		$button.on('click',function(evt){
			evt.preventDefault();
			i++;
			var prenomInput =  "<input name=\"prenom["+i+"]\" type=\"text\" class=\"form-control prenom\"placeholder=\"jhon\"></input>"
			var nomInput =  "<input name=\"nom["+i+"]\" type=\"text\" class=\"form-control nom\"placeholder=\"Do\"></input>"
			var emailInput =  "<input name=\"email["+i+"]\" type=\"email\" class=\"form-control email\"placeholder=\"jhondo@hotmail.com\"required></input>"
			
			
			 $prenomContainer.append(prenomInput);
			 $nomContainer.append(nomInput);
			 $emailContainer.append(emailInput);
		})
	}	
}

function canSend(){
	var $btn = $('.send-button');
	var url = window.location.href;
	var part = url.split("/");
	
	if( part[part.length-1]=== 'home'){
		$btn.attr('disabled','disabled');
		$btn.css('background-color','lightgrey');
	}
	
	

	
}

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
    // alert( pattern.test(emailAddress) );
    return pattern.test(emailAddress);
};

















/*--------------- obsolete been -----------------------*/

// function addFileInput(){
// 	var $button = $('.add_file_button');
// 	var $input = $('.file');

// 	$button.on('click',function(evt){
		
		
// 		$input.after($input.clone());
// 	})
// };

// var chooseTypeMail = {
// 	'html_mode':false,
// 	'editor_mode':false,
// 	'$listener' : $('.type'),

// 	'$alert_msg':[$('.warning')],
// 	'$editor' : null,
// 	switchHtml : function(){
// 		console.log('showWarning activated')
// 		if(this.html_mode === true){
// 			this.$alert_msg[0].css({
// 				'transition':'opacity, 1s',
// 				'opacity':'1'
// 			});

// 		}
// 		else{
// 			this.$alert_msg[0].css({
// 				'transition':'opacity, 1s',
// 				'opacity':'0'
// 			});
// 		}

// 	},
// 	switchEditor  : function(){

// 		if(this.editor_mode === true){
// 			this.$editor = CKEDITOR.replace( 'editor1' );
// 			this.$editor.id = '#cke_editor1';
			
// 		}
// 		else{
// 			console.log('delete');
// 			if(this.$editor !=null || this.$edior != undefined){

// 				this.$editor.destroy();
// 			}
			
// 		}
// 	},
// 	init : function(){
// 		var self = this;
// 		this.$listener.on('click',function(evt){
		
// 			var type = $(this).val();

// 			console.log(type);
// 			if(type === 'html'){
// 				self.editor_mode = false;
// 				self.html_mode = true;
// 				$('.import').css({
// 					'transition':'opacity, 1s',
// 					'opacity':'1'
// 				})

				
// 			}
// 			if(type === 'text'){
// 				self.html_mode = false;
// 				self.editor_mode = true;
// 				$('.import').css({
// 					'transition':'opacity, 1s',
// 					'opacity':'0'
// 				})
				
// 			}
// 				self.switchHtml();
// 				self.switchEditor();
			
// 		})
// 	}
// }





/*-------------------------been--------------------------*/

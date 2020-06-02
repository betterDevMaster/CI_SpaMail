<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class CheckLogController extends CI_Controller {
 
 public function __construct()
 {
   parent::__construct();
   $this->load->model('My_userAuth','',TRUE);
 }
 
 public function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
  
   $this->form_validation->set_rules('identifiant', 'identifiant', 'trim|required');
   $this->form_validation->set_rules('mdp', 'mot de passe', 'trim|required|callback_check_database');
  
   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.  User redirected to login page
     $this->load->view('front/login');
   }
   else
   {
     //Go to private area
     redirect('home', 'refresh');
   }
 
 }
 
 public function check_database($mdp)
 {
   //Field validation succeeded.  Validate against database
   $identifiant = $this->input->post('identifiant');
 
   //query the database
   $result = $this->My_userAuth->login($identifiant, $mdp);
 
   if($result)
   {
     $sess_array = array();
     foreach($result as $row)
     {
       $sess_array = array(
         'id' => $row->id,
         'identifiant' => $row->identifiant,
         'signature'=>$row->signature
       );

       $this->session->set_userdata('logged_in', $sess_array);
       
     }
     return TRUE;
   }
   else
   {
     $this->form_validation->set_message('check_database', ' identifiant ou mot de passe invalide');
     return false;
   }
 }
  public function logout()
 {
   $this->session->unset_userdata('logged_in');
   session_destroy();
   redirect('home', 'refresh');
 }
}
?>
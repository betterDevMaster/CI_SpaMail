<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('My_multUpload');
	}
 


	public function index()
	{
		if($this->session->userdata('logged_in'))
	   {

			$session_data = $this->session->userdata('logged_in');

			$data['identifiant'] = $session_data['identifiant'];
			
			$data['signature'] = $session_data['signature'];
			$dest_list = $this -> db -> select('*')->from('liste_destinataire');
			$data['dest_list'] = $dest_list->get()->result();

			$this->load->view('front/index', $data );
	   }
	   else
	   {
	     //If no session, redirect to login page
	     redirect('/', 'refresh');
	   }
	}

	public function save(){
		
		

		if($this->session->userdata('logged_in')){
			 

			$dest_list = $this -> db -> select('*')->from('liste_destinataire');
			$data['dest_list'] = $dest_list->get()->result();
			$data['dest_mail'] = $this->input->post('dest');
			$data['mail_subject'] = $this->input->post('subject');
			$data['mail_sender'] = $this->input->post('expediant');
			$data['mail_sender_email'] = $this->input->post('email-expediant');
			
			
			$data['mail_text'] = $this->input->post('editor1');
			$data['mail_type'] = $this->input->post('mail_type');
			
			$token = "";

			$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
			$max = count($characters) - 1;
			for ($i = 0; $i < 15; $i++) {
				$rand = mt_rand(0, $max);
				$token .= $characters[$rand];
			}
			
			$dataDB = array(
			   'type' => $data['mail_type'],
			   'sujet' => $data['mail_subject'],
			   'status' => 0,
			   'email' =>$data['mail_sender_email'],
			   'nom' =>$data['mail_sender'],
			   'token'=> $token,
			   'corps_mail' => $data['mail_text']

			);
			$data['token'] = $token;
			$this->session->set_userdata($data);
			
			$this->db->insert('mail', $dataDB); 
			$mail = $this->db->select('*')->from('mail')->where('token',$token)->get();
			$mail = $mail->result();

			$data['upload_file'] = $this->My_multUpload->do_upload('./public/uploads/pieces_jointes','pieces');
			$i=0;
			if(!empty($data['upload_file']['uploaded'])){
				foreach ($data['upload_file']['uploaded']['name'] as $file) {
					$dataDB = array(
				   		'fichier_uri' => $file,
				   		'mail_id' => $mail[0]->id,
				   		'original_name'=>$data['upload_file']['original_name'][$i]
					);
					$i++;
					$this->db->insert('fichier', $dataDB); 
					
				}
				
			}
			redirect('saved_mail/'.$token);

		}
		else
	   	{
	     //If no session, redirect to login page
	     redirect('/', 'refresh');
	   	}

	}
	public function rdyToSend($token){
		if($this->session->userdata('logged_in')){

			$data['token'] = $token;
			$mail = $this -> db -> select('*')->from('mail')->where('token',$token)->get();
			$mail = $mail->result();
			$data['logs'] = $this->db->select('*')->from('log_envoi')->where('mail_id',$mail[0]->id)->get();
			$data['logs'] = $data['logs']->result(); 
			$dest_list = $this -> db -> select('*')->from('liste_destinataire');
			$data['dest_list'] = $dest_list->get()->result();

			$data['dest_mail'] = $this->input->post('dest');
			$data['dest_mail_base'] = $this->session->userdata('dest_mail');
			$data['mail_subject'] = $mail[0]->sujet;
			$data['mail_sender'] = $mail[0]->nom;
			$data['mail_sender_email'] = $mail[0]->email;
			$data['mail_status'] = $mail[0]->status;
			$data['mail_text']= $mail[0]->corps_mail;
			
			$data['mail_type'] = $mail[0]->type;
			
			$data['upload_file']= $this->db->select('*')->from('fichier')->where('mail_id',$mail[0]->id)->get();
			$data['upload_file'] = $data['upload_file']->result();
			$this->load->view('front/index', $data );

		}
		else
	   	{
	     //If no session, redirect to login page
	     redirect('/', 'refresh');
	   	}
	}
	public function edit($token){

		if($this->session->userdata('logged_in')){
			
			
			$data['token'] = $token;
			$data['dest_mail'] = trim($this->input->post('dest'));
			$data['mail_subject'] = trim($this->input->post('subject'));
			$data['mail_sender'] = trim($this->input->post('expediant'));
			$data['mail_sender_email'] = trim($this->input->post('email-expediant'));
			
			
			$data['mail_text'] = $this->input->post('editor1');
			$data['mail_type'] = $this->input->post('mail_type');
			
			
			$mail = $this->db->select('*')->from('mail')->where('token',$token)->get();
			$mail = $mail->result();
			$data['upload_file'] = $this->My_multUpload->do_upload('./public/uploads/pieces_jointes','pieces');

			$data['logs'] = $this->db->select('*')->from('log_envoi')->where('mail_id',$mail[0]->id)->get();
			$data['logs'] = $data['logs']->result();
			$i=0;
			if(!empty($data['upload_file']['uploaded'])){
				foreach ($data['upload_file']['uploaded']['name'] as $file) {
					
				
					
					$dataDB = array(
				   		'fichier_uri' => $file,
				   		'mail_id' => $mail[0]->id,
				   		'original_name'=>$data['upload_file']['original_name'][$i]
					);
					$i++;
					$this->db->insert('fichier', $dataDB); 

					
				}
				
			}
			$dataDB2= array(
						'enregistrement'=> $i++
						);
			$this->db->insert('log_envoi', $dataDB2); 
		
			$this->session->set_userdata($data);



			$dataDB = array(
			   'type' => $data['mail_type'],
			   'sujet' => $data['mail_subject'],
			   'email' =>$data['mail_sender_email'],
			   'nom' =>$data['mail_sender'],
			   'corps_mail' => $data['mail_text'],
			   'status'=>0

			);

			$this->db->where('token', $token);
			$this->db->update('mail', $dataDB);

		
			redirect('saved_mail/'.$data['token']);

		}
		else
	   	{
	     //If no session, redirect to login page
	     redirect('/', 'refresh');
	   	}
	}
}

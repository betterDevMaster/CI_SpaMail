<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {

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
	public function __construct(){
		parent::__construct();
		$this->load->model('My_exelExtract');
	}

	public function index()
	{
		if($this->session->userdata('logged_in')){
			$mail = $this -> db -> select('*')->from('mail')->get();
			$mail = $mail->result();
			$dataDash['mail'] = $mail;
			
	   		$this->load->view('admin/index',$dataDash);
	   	}
	   	else
	   	{
	     //If no session, redirect to login page
	     redirect('/', 'refresh');
	   	}
	}
	public function delete($token, $type)
	{
		if($this->session->userdata('logged_in')){
			
			if($type === "mail"){
				$this->db->where('token',$token);
				$this->db->delete('mail');
				

			}
			if($type === "adress"){
				$this->db->where('id',$token);
				$this->db->delete('adresse');
		
			}
			if($type === "list"){

				$this->db->where('libelle', urldecode($token));
				$this->db->delete('liste_destinataire');
		
			}
			if($type === "upload"){
				$mail = $this->db->select('*')->from('mail')->where('token', $token)->get();
				$mail = $mail->result();
				$this->db->where('mail_id', $mail[0]->id);
				$this->db->delete('fichier');
				redirect('saved_mail/'.$token);
			}	
   		}
   		else
	   	{
	     //If no session, redirect to login page
	     redirect('/', 'refresh');
	   	}
	}

	public function indexList(){
		if($this->session->userdata('logged_in')){
			$list = $this -> db -> select('*')->from('liste_destinataire')->get();
			$list = $list->result();
			$dataDash['list'] = $list;
			
	   		$this->load->view('admin/indexList',$dataDash);

	   	}
	   	else
	   	{
	     //If no session, redirect to login page
	     redirect('/', 'refresh');
	   	}
	}

	public function showList(){

		if($this->session->userdata('logged_in')){
			

			$dataDash['list_select'] = $this->input->post('libelle');
			if(empty($dataDash['list_select'])){
				$adresse = $this -> db -> select('*')->from('adresse')->where('liste_destinataire_id')->get();
				$adresse = $adresse->result();
			
				$list = $this -> db -> select('*')->from('liste_destinataire')->get();
				$list = $list->result();
				$dataDash['adress']= $adresse;
				$dataDash['list'] = $list;
				$this->load->view('admin/indexList',$dataDash);

				return;
			}
		

			$list = $this -> db -> select('*')->from('liste_destinataire')->where('libelle',$dataDash['list_select'])->get();
			$list = $list->result();
			
			if(!empty($list) && isset($list)){
				$adresse = $this -> db -> select('*')->from('adresse')->where('liste_destinataire_id',$list[0]->id)->get();
				$adresse = $adresse->result();

			}
			else{
				$adresse = null;
				
			}
			$list = $this -> db -> select('*')->from('liste_destinataire')->get();
			$list = $list->result();

			$dataDash['adress']= $adresse;
			
			
			$dataDash['list'] = $list;

			$this->load->view('admin/indexList',$dataDash);

		}
		else
	   {
	     //If no session, redirect to login page
	     redirect('/', 'refresh');
	   }
	}

	public function edit($id){
		if($this->session->userdata('logged_in')){

			$adress = $this -> db -> select('*')->from('adresse')->where('id',$id)->get();
			$adress = $adress->result();
			$dataDash['adress'] = $adress;
			$this->load->view('admin/editAdress',$dataDash);
		}
		else
	   {
	     //If no session, redirect to login page
	     redirect('/', 'refresh');
	   }
	}

	public function saveAdress($id){
		if($this->session->userdata('logged_in')){


			$dataDash['email'] = $this->input->post('email');
			$dataDash['name'] = $this->input->post('nom');
			$dataDash['firstname'] = $this->input->post('prenom');

			$dataDB = array(
			   
			   'email'=> $dataDash['email'],
			   'nom' => $dataDash['name'],
			   'prenom' => $dataDash['firstname'],
			   'abonnee'=>1


			);

			$this->db->where('id', $id);
			$this->db->update('adresse', $dataDB);

		
			redirect('dashboard/adress/edit_list/'.$id);

		}
		else
	   {
	     //If no session, redirect to login page
	     redirect('/', 'refresh');
	   }
	}

	public function listPannel(){
		if($this->session->userdata('logged_in')){

			
			$this->load->view('admin/listPannel');
		}
		else
	   {
	     //If no session, redirect to login page
	     redirect('/', 'refresh');
	   }
	}
	public function addList(){
		if($this->session->userdata('logged_in')){
			
			$dataDash['libelle'] = $this->input->post('libelle');
	   		$dataDash['prenom'] = $this->input->post('prenom');
	   		$dataDash['nom'] = $this->input->post('nom');
	   		$dataDash['email'] = $this->input->post('email');
	   		
	   		
			$list = $this->db->select('*')->from('liste_destinataire')->where('libelle',$dataDash['libelle'])->get();
			$list = $list->result();
			
			
			if(empty($list)){
				
				$dataDB_list = array(
			   		'libelle'=>$dataDash['libelle']
				);
				$this->db->insert('liste_destinataire', $dataDB_list);
				$list = $this->db->select('*')->from('liste_destinataire')->where('libelle',$dataDash['libelle'])->get();
				$newList = true;
				$list = $this->db->select('*')->from('liste_destinataire')->where('libelle',$dataDash['libelle'])->get();
				$list = $list->result();
			}
			
			
			
			
			// $list = $this->db->select('*')->from('liste_destinataire')->where('libelle',$dataDash['libelle'])->get();
			

			$dataDash['import_exel'] = $_FILES['exel_import'];
	   		if($dataDash['import_exel']['name'] !=''){
	   			
	   			$dataDash['import_exel'] = $this->My_exelExtract->extract($dataDash['import_exel']['tmp_name']);
	   			for($i=0; $i<count($dataDash['import_exel']); $i++){
					
					if(isset($dataDash['import_exel'][$i][0][1]) &&  !isset($dataDash['import_exel'][$i][0][2])){
						$dataDB_adress = array(
						   'email' => $dataDash['import_exel'][$i][0][0],
						   'liste_destinataire_id' => $list[0]->id,
						   'nom' =>$dataDash['import_exel'][$i][0][1],
						   'abonnee'=>1
						 
						);
						$this->db->insert('adresse', $dataDB_adress);
					}
					else if(isset($dataDash['import_exel'][$i][0][2]) && !isset($dataDash['import_exel'][$i][0][1])){
						$dataDB_adress = array(
						   'email' => $dataDash['import_exel'][$i][0][0],
						   'liste_destinataire_id' => $list[0]->id,
						   'prenom' =>$dataDash['import_exel'][$i][0][2],
						 
						);
						$this->db->insert('adresse', $dataDB_adress);
					}

					if(isset($dataDash['import_exel'][$i][0][1]) && isset($dataDash['import_exel'][$i][0][2]) ){
						
						$dataDB_adress = array(
						   'email' => $dataDash['import_exel'][$i][0][0],
						   'liste_destinataire_id' => $list[0]->id,
						   'prenom' =>$dataDash['import_exel'][$i][0][1],
						   'nom' =>$dataDash['import_exel'][$i][0][2],
						   'abonnee'=>1
						);
						$this->db->insert('adresse', $dataDB_adress);
					}
					else if(!isset($dataDash['import_exel'][$i][0][1]) && !isset($dataDash['import_exel'][$i][0][2])){
						$dataDB_adress = array(
						   'email' => $dataDash['import_exel'][$i][0][0],
						   'liste_destinataire_id' => $list[0]->id,
						   'abonnee'=>1
						
						);
						$this->db->insert('adresse', $dataDB_adress);
					}
					
				}
	   		}	
			if(!empty($dataDash['email'])){
				for($i=0; $i<count($dataDash['prenom']); $i++){
					$dataDB_adress = array(
					   'email' => $dataDash['email'][$i],
					   'liste_destinataire_id' => $list[0]->id,
					   'prenom' =>$dataDash['prenom'][$i],
					   'nom' =>$dataDash['nom'][$i],
					    'abonnee'=>1
					);
					$this->db->insert('adresse', $dataDB_adress);
				}
			}
			
			
			$adress = $this->db->select('*')->from('adresse')->where('liste_destinataire_id',$list[0]->id)->get();
			$adress = $adress->result();
			
			
			$dataDB = array(
					'adresse_id'=>$adress[0]->id,
					

				);
			
			$this->db->where('id', $adress[0]->liste_destinataire_id);
			$this->db->update('liste_destinataire', $dataDB);
			if(isset($newList)){
				redirect('dashboard/list');
			}	
		}
		else
	   {
	     //If no session, redirect to login page
	     redirect('/', 'refresh');
	   }
	}
}

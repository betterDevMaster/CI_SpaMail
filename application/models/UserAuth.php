<?php  
	Class UserAuth extends CI_Model
	{
	 function login($identifiant, $mdp)
	 {
	   $this -> db -> select('id, identifiant, mdp');
	   $this -> db -> from('utilisateur');
	   $this -> db -> where('identifiant', $identifiant);
	   $this -> db -> where('mdp', $mdp);
	   $this -> db -> limit(1);
	 
	   $query = $this -> db -> get();
	 
	   if($query -> num_rows() == 1)
	   {
	     return $query->result();
	   }
	   else
	   {
	     return false;
	   }
	 }
	}
?>

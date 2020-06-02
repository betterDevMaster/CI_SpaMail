<?php  
	Class My_userAuth extends CI_Model
	{
	 function login($identifiant, $mdp)
	 {
	   $this -> db -> select('id, identifiant, mdp, signature');
	   $this -> db -> from('utilisateur');
	   $this -> db -> where('identifiant', $identifiant);
	   $this -> db -> where('mdp', intval($mdp));

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

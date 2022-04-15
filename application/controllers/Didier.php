<?php

class Didier extends CI_Controller
{
	
	function __construct()
	{
		// code...
		parent::__construct();
	}
	public function index($value='')
	{
		// code...
		$this->load->view('Didier_View');

	}


	public function save($value='')
	{
		// code...
		$PRENOM=$this->input->post("PRENOM");
		$NOM=$this->input->post("NOM");
		$user=array('PRENOM'=>base64_encode($PRENOM),'NOM'=>base64_encode($NOM));
		$this->Model->create('user',$user);

		$table="<table class='table'><tr><th>NOM</th><th>PRENOM</th></tr>";
		$all=$this->Model->getRequete("SELECT * FROM user");
		foreach ($all as $key ) {
			// code...
			$table.="<tr><td>".base64_decode($key['NOM'])."</td><td>".base64_decode($key['PRENOM'])."</td></tr>";
		}
     echo $table."</table>";
	}
}

?>
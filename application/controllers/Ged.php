<?php

/**
 * @author jules
 */
class Ged extends CI_Controller
{
	
	function __construct()
	{
		// code...
		parent::__construct();
	}

	public function index($value='')
	{
		// code...

		$data_to_render=array();
		$this->load->view('Ged_View',$data_to_render);
	}

	public function create_folder($value='')
	{
		// code...
		$DESCRIPTION=$this->input->post('DESCRIPTION');
		$NOM_DOSSIER=$this->input->post('NOM_DOSSIER');
		$ged_dossier=array(
			               'nom_dossier'=>$NOM_DOSSIER,	
			               'description'=>$DESCRIPTION);

        $this->form_validation->set_rules(
        'NOM_DOSSIER', 'nom du dossier',
        'required|min_length[5]|max_length[12]|is_unique[ged_dossier.nom_dossier]',
        array(
                'required'      => 'Precisez le %s.',
                'is_unique'     => 'Ce %s existe deja.',
                'max_length'    => 'Le nom du dossier doit contenir 12 caractere'

        )
       );
        $this->form_validation->set_rules(
        'NOM_DOSSIER', 'description du dossier',
        'required|max_length[100]|is_unique[ged_dossier.description]',
        array(
                'required'      => 'Precisez le %s.',
                'is_unique'     => 'Cette %s existe deja.'
        )
        );

		if ($this->form_validation->run() === FALSE) {
			// code...
		 	echo validation_errors('<div class="text-danger">', '</div>');
		} else {
			// code...

		   $rep_doc =FCPATH.'ged/'.$NOM_DOSSIER.'/';
			if(!is_dir($rep_doc)) //create the folder if it does not already exists   
		      {
		        mkdir($rep_doc,0777,TRUE);
			   $this->Model->create('ged_dossier',$ged_dossier);
			   echo 1;

		      }else{
		      	echo 2;
		      } 
		}




	}

	public function afficherMesdossier($value='')
	{
		// code...
		$mes_doc=$this->Model->getRequete("SELECT * FROM `ged_dossier` WHERE is_archived=0");
                $doc="<br>";
		foreach ($mes_doc as $key) {
			// code...
		$doc.='<div class="col-md-4">
			      <div class="form-group">

			      <i class="fa fa-folder fa-5x text-danger" ondblclick="show_contenu('.$key['ID'].')"></i>
			      <span style="cursor: pointer;" ondblclick="show_contenu('.$key['ID'].')">'.$key['nom_dossier'].'</span>
			      </div>
	      
			    </div>';
		}

		echo $doc;

	}

	public function getSousDossier($value='')
	{
		// code...
		$id_dossier=$this->input->post('id_dossier');
		$id = $id_dossier;
		$sql = "SELECT * FROM `ged_dossier` WHERE `ID`=".$id;
                $sql_up = "UPDATE `ged_dossier` SET `nbre_visite`=`nbre_visite`+1 WHERE `ID`=".$id;
                $this->Model->allRequeteyesno($sql_up);

		$info_dossier=$this->Model->getRequeteOne($sql);

		$mes_sous_dossier='<legend>/'.$info_dossier['nom_dossier'].'<span class="badge badge-secondary">'.$info_dossier['nbre_visite'].' visite(s)</span><br><i>'.$info_dossier['description'].'</i> <i onclick="supprimer_dossier('.$id.',2)" class="fa fa-archive"></i> <i  onclick="supprimer_dossier('.$id.',1)" class="fa fa-trash" style="color:red;cursor:pointer;"  ></i></legend>
                           <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal1" data-whatever="@getbootstrap">Ajouter un fichier</button><input type="hidden" id="current_nom_dossier" value="'.$info_dossier['nom_dossier'].'"><input type="hidden" id="current_nom_dossier_id" value="'.$info_dossier['ID'].'">
                           <ul class="list-group list-group-flush">';

                $sql_file = "SELECT ged_file_dossier.`ID`,NBRE_TELECHARGEMA, `PATH_FICHIER`, `ID_DOSSIER`, `NOM_FICHIER`,ged_dossier.nom_dossier FROM `ged_file_dossier` JOIN ged_dossier ON ged_file_dossier.ID_DOSSIER=ged_dossier.ID WHERE `ID_DOSSIER`=".$id;
                //echo $sql_file;
                $info_dossier_file=$this->Model->getRequete($sql_file);

                foreach ($info_dossier_file as  $value) {
                	// code...
                	$mes_sous_dossier.='<li class="list-group-item"><a target="_blank" onclick="set_viewed('.$value['ID']. ')" href="'.base_url("ged/".$value['nom_dossier']."/".$value['PATH_FICHIER']).'" title="'.$value['NOM_FICHIER'].'" >'.$value['PATH_FICHIER'].'</a><span class="badge badge-secondary"><i style="color:red;cursor:pointer;" onclick="supprimer_fichier(\''.$value['PATH_FICHIER'].'\',\''.$value['nom_dossier'].'\','.$value['ID'].')" class="fa fa-trash"></span></i></li>';
                }


	        $mes_sous_dossier.="</ul>";

	        echo $mes_sous_dossier;
	}

	public function saveFile()
	   {
	   	
	   	$nom_fichier=$this->input->post('nom_fichier');
	   	$nom_champ='fichier';
		$nom_dossier=$this->input->post('current_nom_dossier');
		$current_nom_dossier_id=$this->input->post('current_nom_dossier_id');
		$target_dir = FCPATH.'ged/'.$nom_dossier.'/';
		$target_file = $target_dir . basename($_FILES[$nom_champ]["name"]);
		$uploadOk = 1;
		$fileFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		/*// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		  $check = getimagesize($_FILES[$nom_champ]["tmp_name"]);
		  if($check !== false) {
		    echo "File is an image - " . $check["mime"] . ".";
		    $uploadOk = 1;
		  } else {
		    echo "File is not an image.";
		    $uploadOk = 0;
		  }
		}*/

		// Check if file already exists
		if (file_exists($target_file)) {
		  echo "Sorry, file already exists.";
		  $uploadOk = 0;
		}

		// Check file size
		if ($_FILES[$nom_champ]["size"] > 500000) {
		  echo "Sorry, your file is too large.";
		  $uploadOk = 0;
		}
                //echo $fileFileType;die();
		// Allow certain file formats
		/*$array_yanj=array('doc','docx','xls','xlsx','htm','html','jpeg','png','png','mp3','pdf','ppt','txt');
		if(in_array(trim($fileFileType), $array_yanj,true)) {
		  echo "The files are allowed.";
		  $uploadOk = 0;
		}*/

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		  echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		  if (move_uploaded_file($_FILES[$nom_champ]["tmp_name"], $target_file)) {

		   $ged_file_dossier = array(
		   	                     'PATH_FICHIER' =>htmlspecialchars(basename( $_FILES[$nom_champ]["name"])) ,
		   	                     'ID_DOSSIER'=>$current_nom_dossier_id,
		   	                     'NOM_FICHIER'=> $nom_fichier); 

		    $this->Model->create('ged_file_dossier',$ged_file_dossier);
		///~~~~~progrmamme ~~~~~~~////
		$chemin_fichier=FCPATH."ged/".$current_nom_dossier_id."/".htmlspecialchars(basename( $_FILES[$nom_champ]["name"]));//adresse fichier origine se trouvant sur la racine de votre serveur
		$chaine_crypt="MUSCO93200";//n'importe kel chainecrypter
		$chemin1_fichier=FCPATH."ged/".$current_nom_dossier_id."/".htmlspecialchars(basename( $_FILES[$nom_champ]["name"]));
		$nom_fichier="fichier1.zip";//nom du fichier a afficher ldans la boite de telechargement fichier		    
		    $this->crypte_fichier($chemin_fichier,$chaine_crypt,$chemin1_fichier);

		    echo "The file ". htmlspecialchars(basename( $_FILES[$nom_champ]["name"])). " has been uploaded.";
		  } else {
		    echo "Sorry, there was an error uploading your file.";
		  }
		}

	  }
	public function set_viewed($value='')
	{
		// code...
		$id=$this->input->post('id_file');
		$sql = "UPDATE `ged_file_dossier` SET `NBRE_TELECHARGEMA`=`NBRE_TELECHARGEMA`+1 WHERE `ID`=".$id;
		$this->Model->allRequeteyesno($sql);

	}
	public function supprimer_dossier($value='')
	{
		# code...
		//RepEfface('chemin de votre répertoire');
		/*
			FCPATH   -> '/'
			BASEPATH -> '/system/'
			APPPATH  -> '/application/'

		*/
		$id=$this->input->post('id');
		$current_nom_dossier=$this->input->post('current_nom_dossier');
		$action=$this->input->post('action');
		if ($action==1) {
			// code...
			//suppression
			chmod(FCPATH."ged/".$current_nom_dossier,0777);

			$this->RepEfface(FCPATH."ged/".$current_nom_dossier);
			$sql = "DELETE FROM `ged_dossier` WHERE `ID`=".$id;
			$this->Model->allRequeteyesno($sql);
			echo "dossier supprimer";	
		}else{
			$sql = "UPDATE `ged_dossier` SET `is_archived`=1 WHERE `ID`=".$id;
			$this->Model->allRequeteyesno($sql);
			echo "dossier archive";		
		}

	}

	public function supprimer_fichier($value='')
	{
		# code...
		$nom_dossier=$this->input->post('nom_dossier');
		$NOM_FICHIER=$this->input->post('NOM_FICHIER');
		$id=$this->input->post('id');
		$dir=FCPATH."ged/".$nom_dossier."/".$NOM_FICHIER;
		chmod($dir,0777);
		//echo $dir;
		if (unlink($dir)) {
			// code...
			$sql = "DELETE FROM `ged_file_dossier` WHERE `ID`=".$id;
			$this->Model->allRequeteyesno($sql);

		}
		echo "fichier supprimer";
	}
	public function deleteTree($dir){
	    foreach(glob($dir . "/*") as $element){
	        if(is_dir($element)){
	            deleteTree($element); // On rappel la fonction deleteTree  

	            echo $element;         
	            rmdir($element); // Une fois le dossier courant vidé, on le supprime
	        } else { // Sinon c'est un fichier, on le supprime
	            unlink($element);
	        }
	        // On passe à l'élément suivant
	    }
	}


        public function RepEfface($dir)
        {
	    $handle = opendir($dir);
	    while($elem = readdir($handle)) 
	//ce while vide tous les repertoire et sous rep
	    {
	        if(is_dir($dir.'/'.$elem) && substr($elem, -2, 2) !== '..' && substr(
	$elem, -1, 1) !== '.') //si c'est un repertoire
	        {
	            RepEfface($dir.'/'.$elem);
	        }
	        else
	        {
	            if(substr($elem, -2, 2) !== '..' && substr($elem, -1, 1) !== '.')
	            {
	                unlink($dir.'/'.$elem);
	            }
	        }
	          
	    }
	    
	    $handle = opendir($dir);
	    while($elem = readdir($handle)) //ce while efface tous les dossiers
	    {
	        if(is_dir($dir.'/'.$elem) && substr($elem, -2, 2) !== '..' && substr(
	$elem, -1, 1) !== '.') //si c'est un repertoire
	        {
	            RepEfface($dir.'/'.$elem);
	            rmdir($dir.'/'.$elem);
	        }    
	    
	    }

	    rmdir($dir); //ce rmdir eface le repertoire principale
   }

//~~~~Crypte le fichier
function crypte_fichier($chemin_fichier,$chaine_crypt,$chemin1_fichier){
  $lignecripte="";
  $bytes = 65536;//nombre de bytes par ligne de cryptage
  //remplit une ligne de cryptage de longueur 65536 bites
  for ($i = 0; $i <= floor($bytes/strlen($chaine_crypt)); $i++) $lignecripte.= $chaine_crypt;
  //ouvre le fichier a crypter en lecture
  //cree le nouveau fichier
//echo  $chemin_fichier;die();
 if (file_exists($chemin_fichier)){//verifie presence du fichier
  chmod($chemin_fichier,0777);//attribue tous droits
  $ancien = fopen($chemin_fichier, "rb");
  $nouveau = fopen($chemin1_fichier, "wb");
  // crypt le fichier et ecrie dans le nouveau fichier par ligne de 65536 bites
  while($line = fread($ancien, $bytes)){
    $line2 = $line ^ $lignecripte;//effectue un OU EXCLUSIF (XOR) sur les bits 10011¨^ 10110=00101 
    fputs($nouveau, $line2);}
  // ferme les fichiers
  fclose($ancien);fclose($nouveau);
  unlink($chemin_fichier);//suprimme l'ancien fichier
}}   

//~~~~Decrypte le fichier~~~~//
//fonction a appler apres avoir declarer les header ouvrira une boite de telechargement
function decrypte_file($chemin1_fichier,$chaine_crypt){
	$bytes = 65536; //bite par ligne
	$lignecripte="";
	$chainecrypte=$chaine_crypt;
	//remplit une ligne de cryptage de longueur 65536 bites
	for ($i = 0; $i <= floor($bytes/strlen($chainecrypte)); $i++) $lignecripte.= $chainecrypte;
  	// ouvre le fichier
  	$file = fopen($chemin_fichier, "rb");
  	while($line = fread($file, $bytes)){
    	$line2 = $line ^ $lignecripte;//effectue un OU EXCLUSIF (XOR) sur les bits 10011¨^ 10110=00101 
    	// affichage du fichier
    	echo $line2;
  	}
}


}


?>
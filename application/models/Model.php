<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author jules😎
 */


class Model extends CI_Model{

   //insertion dans la base de donne
	function create($table, $data) {

        $query = $this->db->insert($table, $data);
        return ($query) ? true : false;

    }

 //mis a jour 
   function update($table, $criteres, $data) {
        $this->db->where($criteres);
        $query = $this->db->update($table, $data);
        return ($query) ? true : false;
    }

//inserer et retourner la derniere donne enregistrer
    function insert_last_id($table, $data) {

        $query = $this->db->insert($table, $data);
       
       if ($query) {
            return $this->db->insert_id();
        }

    }


//supprimer
   function delete($table,$criteres){
        $this->db->where($criteres);
        $query = $this->db->delete($table);
        return ($query) ? true : false;
    }

//retourner une tableau des donne selectionner
  function getRequete($requete){
      $query=$this->db->query($requete);
      if ($query) {
         return $query->result_array();
      }
    }


//retourner une ligne des donne selectionner
    function getRequeteOne($requete){
      $query=$this->db->query($requete);
      if ($query) {
         return $query->row_array();
      }
    }

//retourner une ligne des donne selectionner
    function allRequeteyesno($requete){
      $query=$this->db->query($requete);
      if ($query) {
         return 1;
      }
    } 
    
}
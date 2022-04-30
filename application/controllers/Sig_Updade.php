<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author jules😎
 */
class Sig_Updade extends CI_Controller
{
	
	function __construct()
	{
		// code...
		parent::__construct();
	}

	public function index($value='')
	{
		// code...

		$mes_polygon='';

		$polygone_saved=$this->Model->getRequete('SELECT * FROM `mes_polygone`');//recuperation de tous mes polygone pour les enregistrer 

		foreach ($polygone_saved as $key) {
			// code...
			$mes_polygon.=$key['POLYGONE'].",";
		}

       $provincesmap= $this->Model->getRequete('SELECT * FROM `provincesmap` WHERE 1');
       $i=1;
       $truc='NAME_2';
       $limites='';

		foreach ($provincesmap as $key_poly) {
			// code...

	 $colo=$key_poly['COLOR'];
	 $weght=1;
	 $i = $i+1;
     $polyg = trim($key_poly['POLY']);
     $polyg.= '#';
     $polyg =str_replace(",#","", $polyg);

     $limites.= 'var world'.$i.' = {
                  "type": "FeatureCollection",
                "name": "BI_20190915_WGS84_administrativeboundaries_polygons_adminlevel4_2",
                "crs": { "type": "name", "properties": { "'.$truc.'": "urn:ogc:def:crs:OGC:1.3:CRS84" } },
                "features": ['.$polyg.']
                }
                var styleState'.$i.' = {
                  color: "'.$colo.'",
                  weight: '.$weght.'
                  
                };
                  myLayer1 = L.geoJson(world'.$i.', {
                  onEachFeature: function(feature, layer) {
                    layer.bindPopup("Province de '.trim($key_poly['PROVINCE_NAME']).'");
                  },style: styleState'.$i.'
                }).addTo(map);

           L.marker(['.$key_poly['PROVINCE_LATITUDE'].', '.$key_poly['PROVINCE_LONGITUDE'].'], {
              icon: L.mapbox.marker.icon({
                "marker-color": "'.$colo.'",
                
              })
          }).addTo(map)            
            .bindPopup("<b>'.trim($key_poly['PROVINCE_NAME']).'</b>")
            .openPopup();


                ';



		}        


 // echo $provinces ;die();

		$mes_polygon=str_replace('"', "", $mes_polygon);//suppression des "" dans le tableau des coordonnees
		
		$data=array('mes_polygon'=>$mes_polygon,'limites'=>$limites); //envoi de mes coordonne sur la page d'affichage
		
		$this->load->view('Sig_Update_View',$data);
	}


    //recuperation et enregistrement dans la base des corrodonnes du polygone dessine
	public function enregistrer_polygone_dessiner($value='')
	{
		// code...
		$data_to_insert=array('POLYGONE'=>json_encode($this->input->post('mypolygone')));//construction du tableau pour sauvegarde
		$coor= str_replace("[[", "", $this->input->post('mypolygone')) ;
		$coor0=str_replace('{"lat":', "[", $coor);
    $coor1=str_replace('"lng":', "", $coor0);
    $coor2=str_replace('},', "],", $coor1);
    $coor3=str_replace('}', "]", $coor2);
    $data_to_insert= str_replace("]]]]", "]]", $coor3) ;

		$this->Model->create('mes_polygone',array('POLYGONE'=>$data_to_insert));//insertion
		
    echo  $data_to_insert;

		
	}
	public function traceRoute() {

		$data=array();

		$this->load->view('Sig_UpdateTroure_View',$data);

		}


}


?>

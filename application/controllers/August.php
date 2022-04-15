<?php

/**
 * 
 */
class August extends CI_Controller
{
	
	function __construct()
	{
		// code...
		parent::__construct();
	}
	public function index($value='')
	{
		// code...
		$this->load->view('August_View');

	}

	function strToBin(){
     $str=$this->input->post('string_to_convert');
    $str_len = strlen($str);
 
    for($i = 0 ; $i < $str_len ; $i++){
        if(is_numeric(substr($str, 0, 1))){
            echo 0,0,base_convert(ord($str), 10, 2).' ';
        }
        else{
            echo 0,base_convert(ord($str), 10, 2).' ';
        }
        $str = substr($str, 1);
    }

}


function strToBin__()
{  $string=$this->input->post('string_to_convert');
    $characters = str_split($string);
 
    $binary = [];
    foreach ($characters as $character) {
        $data = unpack('H*', $character);
        $binary[] = base_convert($data[1], 16, 2);
    }
 
    echo implode(' ', $binary);    
}

function bin_to_dec()
{
	$binary=$this->input->post('messagebin_crypt');
    $binaries = explode(' ', $binary);
 
    $string = null;
    foreach ($binaries as $binary) {
        $string .= pack('H*', dechex(bindec($binary)));
    }
 
    echo $string;    
}

// function bin_to_dec_($bin){
// 	    $bin=$this->input->post('string_to_convert');
// 	    $bin = str_split($bin);
// 		$bin = array_reverse($bin);
// 		$i=0;
// 		$dec=0;
// 		$values=0;
// 		foreach($bin as $values){
// 		$ans = $values * pow(2, $i);
// 		$dec += $ans;
// 		$i++;
// 			 }
// 			 echo  $dec;
//    }


function encryptthis(){
	$data=$this->input->post('string_to_convert');
	$key="";
	$encryption_key=base64_decode($key);
	$iv=openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
	$encrypted=openssl_encrypt($data,'aes-256-cbc',$encryption_key,0,$iv);
	echo base64_encode($encrypted.'..'.$iv);
}

}


?>
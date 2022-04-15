<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	 
	public function index()
	{
		/*$nom="NDIHOKUBWAYO Jules";

		echo "LE md5 de ".$nom." est <strong>". md5($nom)."</strong><br><br>";

		echo "<br>LE sha1 de ".$nom." est <strong>". sha1($nom)."</strong>";*/
		$a=277;
		$b=709;
		$p=64333;
		$j=0;
		$tab="<table style='border:1px;color: black;'><tr><th>x</th><th>y</th><th>y2</th><th>x3+ax+b</th></tr>";
		while ($j<$p) {
			// code...
            $x=$j;
            $y=$j;
            $ycarre=($y*$y)%$p;
            $fonct=(($x*$x*$x)+($x*$a)+$b)%$p;
            $tab.="<tr><td>".$x."</td><td>".$y."</td><td>".$ycarre."</td><td>".$fonct."</td></tr>";

			$j++;
		}

		//echo $tab.="</table>";

		echo decbin(4);
		
	}
}

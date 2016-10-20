<?php
class Element{

	private $value;
	private $matrix;


	function __construct($file,$value=null){
		$this->matrix = $this->imageToMatrix(imagecreatefromstring(file_get_contents($file)));
		$this->value  = $value;
	}

	public static function printMatrix(Array $matrix){
		foreach ($matrix as $line) {
	 		foreach ($line as $bit) {
	 			echo $bit;
	 		}

	 		echo "<br>";
	 	}
	}

	public static function cropImage($image){
		for ($i=0; $i < imagesy($image) ; $i++) { 
			for ($j=0; $j < imagesx($image); $j++) { 
				$matrix[$i][$j] = imagecolorat($image,$j,$i)>=hexdec("CCCCCC")?0:1;
			}
		}
		$result = array_values(array_filter($matrix,function($value){
											return array_sum($value)>1;
										}));


		$xsize = count($result);
		$ysize = count($result[0]);

		for ($i=0; $i < $ysize ; $i++) { 
			$count = 0;
			for ($j=0; $j < $xsize; $j++) { 
				$count+=$result[$j][$i];	
			}
				
			if($count<1){
				for ($x=0; $x < count($result); $x++) { 
					unset($result[$x][$i]);
					
				}
			}
		}

		array_walk($result, function(&$value)
		{
			$value = array_values($value);
		});

		return array_values($result);
	}

	public function imageToMatrix($image, $patternx = 50, $patterny = 50){
		
		$srcMatrix = Element::cropImage($image);
		$imagesy = count($srcMatrix);
	 	$imagesx = count($srcMatrix[0]);
	 	$matrix = array();

	 	for ($i=0; $i < $patterny; $i++) { 
	 		for ($j=0; $j < $patternx; $j++) { 

	 			$ratio = 0;

	 	
	 			for($y = 0; $y<floor($imagesy/$patterny); $y++){
			 		for($x = 0; $x<floor($imagesx/$patternx); $x++){
			 			
			 			$secx = floor($imagesx/$patternx*$j)+$x;
			 			$secy = floor($imagesy/$patterny*$i)+$y;

			 			

			 			if($secy<$imagesy && $secx<$imagesx){
			 				
			 				$col = $srcMatrix[$secy][$secx];
			 			}else{
			 				$col = 0;
			 			}
			 			$ratio+=$col;
			 		
			 			
			 		}
			 		//echo "x:$secx <> y:$secy<br>";
			 		//echo "<br>";
			 		
			 	}
			 	$treshold = ($imagesy/$patterny*$imagesx/$patternx)/10000*4;
			 	
			 	$matrix[$i][$j] = $ratio>=$treshold?1:0;

	 		}
	 	}
	 	return $matrix;
	}	

	public function sumTransfer($weights){
		$result = 0;
		for($y = 0; $y<count($this->matrix);$y++){
			for($x = 0; $x<count($this->matrix[$y]);$x++){
				$result+=$this->matrix[$x][$y]*$weights[$x][$y];
			}		
		}
		//echo $result."<br>";
		return $result>0?1:0;
	}

	public function isTrained($weights){
		return $this->sumTransfer($weights)==$this->value;
	}

	public function getMatrix(){
		return $this->matrix;
	}

	public function getValue(){
		return $this->value;
	}

}

?>
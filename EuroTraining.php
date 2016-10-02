<?php 

	class EuroTraining{
		
		private $weights;
		private $trainingSet;

		function __construct($trainingSet){
			$this->weights = EuroTraining::initializeWeights();
			$this->trainingSet = $trainingSet;
		}

		public function delta($value,$weight,$wanted,$received){
			$delta = ($wanted-$received)*1*$value;
			$result = $weight+$delta;
			return $result;
		}		

		public static function initializeWeights($x=50,$y=50){
			$weights = array();

			for($i = 0 ; $i<$y; $i++){
				$weights[$i] = array();
				for($j = 0 ; $j<$x; $j++){
					$weights[$i][$j] = 0;
				}
			}

			return $weights;		
		}

		public function training(){

			while (!($this->trainingSet->trainingSetResult($this->weights))){
				
				foreach ($this->trainingSet->getArraySet() as $element) {

					if(!$element->isTrained($this->weights)){


						$matrix = $element->getMatrix();
						$currentOutput = $element->sumTransfer($this->weights);
						
						for($i = 0; $i<count($matrix); $i++){
							for($j = 0; $j<count($matrix[$i]); $j++){
								$this->weights[$i][$j] = $this
															->delta(
																$matrix[$i][$j],
																$this->weights[$i][$j],
																$element->getValue(),
																$currentOutput
																);
							}	
						}
					}

				}
			}

			

			


			return $this->weights;
		}
 	
	}



?>
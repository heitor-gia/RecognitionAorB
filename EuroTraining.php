<?php 

	class EuroTraining{
		
		private $weights;
		
		function __construct(){
			$this->weights = EuroTraining::initializeWeights();
		}

		private function delta($value,$weight,$wanted,$received){
			$delta = ($wanted-$received)*1*$value;
			$result = $weight+$delta;
			return $result;
		}		

		private static function initializeWeights(){
			
			
			$weights = array();
			
			if(!file_exists('weights.json')){
				$x=50;
				$y=50;
				for($i = 0 ; $i<$y; $i++){
					$weights[$i] = array();
					for($j = 0 ; $j<$x; $j++){
						$weights[$i][$j] = 0;
					}
				}
			}else{

				$weightsJSON = file_get_contents('weights.json');
				$weights = json_decode($weightsJSON);

			}

			return $weights;		
		}

		public function training(TrainingSet $trainingSet){

			while (!($trainingSet->trainingSetResult($this->weights))){
				
				foreach ($trainingSet->getArraySet() as $element) {

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

			$this->saveWeights('weights.json');			
		}

		private function saveWeights($filename){
			file_put_contents($filename, json_encode($this->weights));
		}

		public function getWeights(){
			return $this->weights;
		}

		public function isTrained(){
			$result = false;
			foreach ($this->weights as $line) {
				foreach ($line as $weight) {
					$result = $result||$weight!=0;
				}
			}

			return $result;		
		}
 	
	}



?>
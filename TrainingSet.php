<?php

	/**
	* 
	*/
	class TrainingSet {
		
		private $set;

		function __construct(array $set){
			$this->set = $set;
		}

		function trainingSetResult($weights){
			$result = true;
			foreach ($this->set as $element) {
				$result = $result && $element->isTrained($weights);
			}
			return $result;
		}

		public function getArraySet()
		{
			return $this->set;
		}
	}

?>
<p style="font-family:'monospace';font-size:10px"><strong>
 <?php
 	include_once 'Element.php';
 	include_once 'EuroTraining.php';
 	include_once 'TrainingSet.php';
 	//ini_alter("display_errors", 0);
 	ini_set('memory_limit', '2048M');
	


	$euro = new EuroTraining();

	if(!$euro->isTrained()){
		//A
		$set[] = new Element('./resources/a1.png',0);
		$set[] = new Element('./resources/a2.png',0);
		$set[] = new Element('resources/testA.png',0);
		$set[] = new Element('resources/amin.png',0);
		$set[] = new Element('resources/amin2.png',0);
		$set[] = new Element('resources/amin3.png',0);
		$set[] = new Element('resources/a-bem-loco.jpg',0);

		//B
		$set[] = new Element('./resources/b1.png',1);
		$set[] = new Element('./resources/b2.png',1);
		$set[] = new Element('resources/testb.jpg',1);
		$set[] = new Element('resources/bmin.png',1);
		$set[] = new Element('resources/bmin3.png',1);
		$set[] = new Element('resources/bmin2.png',1);
		

		$trainingSet = new TrainingSet($set);

		$euro->training($trainingSet);
	}

	$file = new Element($_FILES['image']['tmp_name']);
	


	Element::printMatrix($file->getMatrix());
	echo "<br><br>";



	if($file->sumTransfer($euro->getWeights())==0){
		echo "Isso parece um A";
	} else {
		echo "Isso parece um B";
	}

 ?>
</strong></p>
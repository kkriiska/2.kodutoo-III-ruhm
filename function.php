<?php

	//functions.php
	require("../../../config.php");
	
	//et saab kasutada $_SESSION muutujaid
	//koigis failides mis on selle failiga seotud
	session_start();

	$database = "if16_karokrii";

	//var_dump($GLOBALS);

	function signup($email, $password) {
	
		$mysqlu = new mysqli(
	
		$GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"] );
	
		$stmt = $mysqi->prepare("INSERT INTO user_sample (email, password) VALUES(?, ?)");
		echo $mysqli->error;
	
		$stmt->bind_param("ss", $email, $password);
	
		if ($stmt->execute()) {
			echo "salvestamine onnestus";
		}else{
			echo "ERROR ".$stmt->error;
		}
	}
	
	function login($email, $password) {
		
		$notice = "";
		
		$mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare ("SELECT id, email, password, created FROM user_sample WHERE email = ?");
		
		//asendan?
		$stmt->bind_param ("s", $email);
		
		//maaran muutujad reale mis katte saan
		$stmt->binf_result ($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		//ainult SELECTi puhul
		if ($stmt->fetch()) {
			
				//vahemalt uks rida tuli
				//kasutaja sisselogimis parool rasiks
				$hash = hash ("sha512", $password);
				if ($hash == $passwordFromDb) {
					
					//onnestus
					echo "Kasutaja ".$id." logis sisse";
					
					$_SESSION["userId"] = $id;
					$_SESSION["userEmail"] = $emailFromDb;
					
					header("Location: data.php");
					
				}else{
					
					$notice = "Vale parool!";
				}
				
		}else{
			
			//ei leitud uhtegi rida
			$notice = "Sellist emaili ei ole!";
		}
		
		return $notice;
	}
	
	function saveNote ($note, $color) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO colorNotes (note, color) VALUES (?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param ("ss", $note, $color );
		
		if ($stmt->execute()) {
			echo "salvestamine onnestus";
		}else{
			echo "ERROR ".$stmt->error;
		}
	}
	
	function getAllNotes() {
		$mysqli = new mysqli (GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, note, color FROM colorNotes");
		
		$stmt->bind_result("ss", $note, $color);
		$stmt->execute();
		
		$result = array();
		
		//tsukkel tootab seni, kuni saab uue rea AB'i
		//nii mitu korda palju SELECT lausega tuli
		while ($stmt->fetch()) {
			//echo $note."<br>";
			
			$object = new StdClass();
			$object->id = $id;
			$object->note = $note;
			$object->noteColor = $color;
			
			array_push ($result, $oject);
		}
		
		return $result;
	}
	
	function cleanInput ($input ) {
		
		//"  tere tulemast  "
		$input = trim($input);
		//"tere tulemast"
		
		//"tere \\tulemast"
		$input = striplashes($input);
		//"tere tulemast"
		
		//"<"
		$input = htmlspecialchars($input);
		//"&lt;"
		
		return $input;
	}
	
	
	/*function sum($x, $y) {
		$answer = $x+$y;
		
		return $answer;
	}
	
	function hello ($firstname, $lastname) {
		return "Tere tulemast ".$firstname." ".$lastname."!";
	}
	
	echo sum (123456789, 123456789);
	echo "<br>";
	echo sum (1,2);
	echo "<br>";
	echo hello ("Karolin", "K.");
	*/
	?>
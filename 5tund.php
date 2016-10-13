<?php

	require("../config.php");
	require("function.php");
	
    //var_dump($_GET):
	//echo "<br>";
	//var_dump($_POST);
	
	//kui kasutaja on sisse loginud, siis suuna data lehele
	if (isset ($_SESSION["userId"])) {
		header ("Location: data.php");
		exit();
	}
	
	$signupFirstNameError = "";
	$signupFirstName = "";
	
	//kas on üldse olemas
	if (isset ($_POST["signupFirstName"])) {
	 
	   //oli olemas, ehk keegi vajutas nuppu
	   //kas oli tuhi
	   if (empty ($_POST["signupFirstName"])) {
	     
		  //oli toesti tuhi
		  $singupFirstNameError = "See vali on kohustuslik";
		 
	    }else{	

           //koik korras, vali ei ole tuhi ja on olemas
		   $signupFirstName = $_POST["signupFirstName"];
		 
		
		}  
		
	}
	
	$signupLastNameError = "";
	$signupLastName = "";
	
	//kas on üldse olemas
	if (isset ($_POST["signupLastName"])) {
	 
	   //oli olemas, ehk keegi vajutas nuppu
	   //kas oli tuhi
	   if (empty ($_POST["signupLastName"])) {
	     
		  //oli toesti tuhi
		  $singupLastNameError = "See vali on kohustuslik";
		 
	    }else{	

           //koik korras, vali ei ole tuhi ja on olemas
		   $signupEmail = $_POST["signupLastName"];
		 
		
		}  
		
	}
	
	$signupEmailError = "";
	$signupEmail = "";
	
	//kas on üldse olemas
	if (isset ($_POST["signupEmail"])) {
	 
	   //oli olemas, ehk keegi vajutas nuppu
	   //kas oli tuhi
	   if (empty ($_POST["signupEmail"])) {
		   
		   //oli toesti tuhi
		   $signupEmailError = "See vali on kohustuslik";
		   
	    }else{
		   
		   //koik korras, email ei ole tuhi ja on olemas
		   $signupEmail = $_POST["signupEmail"];
		   
		}
	
	}
	
	$signupPasswordError = "";
	
	//kas on uldse olemas
	if (isset ($_POST ["signupPassword"])) {
		
		//oli olemas, ehk keegi vajutas nuppu
		//kas oli tuhi
		if (empty ($_POST["signupPassword"])) {
			
			//oli toesti tuhi
			$signupPasswordError = "See on kohustuslik";
			
		}else{
			
			//oli midagi, ei olnud tuhi
			
			//kas pikkus vahemalt 8 tahemarki
			if (strlen ($_POST["signupPassword"]) <8 ) {
				
				$signupPasswordError = "Parool on liiga luhike!";
				
			}
			
		}
		
	}
	
	$gender = "";
	
	if (isset ($_POST["gender"])) {
		
		if (!empty ($_POST["gender"])) {
			
			//on olemas ja ei ole tuhi
			$gender = $_POST["gender"];
			
		}
		
	}
	
	if ( isset($_POST["signupEmail"]) &&
             isset($_POST["signupPassword"]) &&
             $signupEmailError == "" &&
             empty($signupPasswordError)  
	    ) {
		
		//uhtegi viga ei ole, koik vajalik olemas
		
		echo "salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
		
		$password = hash ("sha512", $_POST["signupPassword"]);
		
		echo "rasi ".$password."<br>";
		
		//kutsun funktsiooni, et salvestada
		signup($signupEmail, $password);
			
	}
	
	$notice = "";	
	//mõlemad login vormi väljas on täidetud
	if ( isset($_POST["loginEmail"]) &&
		isset($_POST["loginPassword"]) &&
		!empty($_POST["loginEmail"]) &&
		!empty($_POST["loginPassword"])
	) {
			login($_POST["loginEmail"], $_POST["loginPassword"]);
	}

	
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimine</title>
	</head>
	<body>
		<h1>Logi Sisse</h1>
		
		<form method = "POST">
		
			<input placeholder = "E-mail" name = "loginEmail" type = "email">
			
			<br><br>
			
			<input placeholder = "Parool" name = "loginPassword" type = "password">
			
			<br><br>
			
			<input type = "submit" value = "Logi sisse">
			
		</form>
		
	</body>
</html>

<html>
	<head>
		<title>Sisselogimine</title>
	</head>
	<body>
		<h1>Loo kasutaja</h1>
		
		<form method = "POST">
			<input placeholder="Eesnimi" name="signupFirstName" type="firstname"> <?php echo $signupFirstNameError; ?>
			  
			<br><br>
			  
			<input placeholder="Perekonnanimi" name="signupLastName" type="lastname"> <?php echo $signupLastNameError; ?>
			  
			<br><br>
			
			<input placeholder = "Email" name = "signupEmail" type = "email"> <?php echo $signupEmailError; ?> 
			
			<br><br>
			
			<input placeholder = "Parool" name = "signupPassword" type = "password"> <?php echo $signupPasswordError; ?>
			
			<br><br>
			
			<input placeholder = "Sunnipaev" type = "date" name = "birthday">
			
			<br><br>
			
			<label>Sugu</label><br>
			<?php if ($gender == "male") { ?>
			        <input type="radio" name="gender" value="male"> Mees<br>
			  <?php } else { ?>
			        <input type="radio" name="gender" value="male" checked> Mees<br>
			  <?php } ?>
			 
			  <?php if ($gender == "female") { ?>
			        <input type="radio" name="gender" value="female"> Naine<br>
			  <?php } else { ?>
			        <input type="radio" name="gender" value="male" checked> Naine<br>
			  <?php } ?>
			  
			  <?php if ($gender == "other") { ?>
			        <input type="radio" name="gender" value="other"> Muu<br><br>
			  <?php } else { ?>
			        <input type="radio" name="gender" value="other" checked> Muu<br><br>
			  <?php } ?>
			        
					<input type = "submit" value = "Loo kasutaja"
					
		  </form>
    </body>
</html>

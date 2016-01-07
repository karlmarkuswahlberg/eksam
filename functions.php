<?php
	
    require_once("../config_global.php");
    $database = "if15_skmw";
    session_start();

	
	function logInUser($email, $hash){
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?"); 
        $stmt->bind_param("ss", $email, $hash);
        $stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
			if($stmt->fetch()){
                    echo "Kasutaja ".$email_from_db. "logis sisse";
					$_SESSION['logged_in_user_id'] =  $id_from_db;
					$_SESSION['logged_in_user_email'] =  $email_from_db;
					header("Location: data.php");
					
                }else{
                    echo "Wrong credentials!";
                }
                $stmt->close();
				$mysqli->close();
	}
	
	function createUser($create_email, $hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
		$stmt->bind_param("ss", $create_email, $hash);
		$stmt->execute();
        $stmt->close();
		$mysqli->close();	
	}
	
	function addBird($bird_name, $observed, $bird_count){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO birds (user_id, bird_name, observed, bird_count) VALUES (?,?,?,?)");
		echo $mysqli->error;
		$stmt->bind_param("issi", $_SESSION['logged_in_user_id'], $bird_name, $observed, $bird_count);
		$message = "";
		
		if($stmt->execute()){
			
			$message = "Linnuliik lisatud!";
		}else{
			$message = "Ei õnnestunud!";
		}
		
        $stmt->close();
		$mysqli->close();
		
		return $message;
	}

	function getAllData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, bird_name, observed, bird_count FROM birds");
		echo $mysqli->error;
		$stmt->bind_result($id_from_db, $user_id_from_db, $bird_name_from_db, $observed_from_db, $bird_count_from_db);
		$stmt->execute();
		
		$array = array();
		while($stmt->fetch()){
			
		   $bird = new StdClass();
		   $bird->id = $id_from_db;
		   $bird->user_id = $user_id_from_db;
		   $bird->bird_name = $bird_name_from_db;
		   $bird->observed = $observed_from_db;
		   $bird->bird_count = $bird_count_from_db;

			array_push($array, $bird);
		
		}
		return $array;
		
        $stmt->close();
		$mysqli->close();
		
		
	}
	
	function createDropdown(){ 
		
		$html = '';
	
		$html .= '<select name = "dropdown_interest">';
		
		$stmt = $this->connection->prepare("SELECT id, name FROM interests"); 
		$stmt->bind_result($id, $name);
		$stmt->execute();
	
		while($stmt->fetch()){
			
			
			$html .= '<option value="'.$id.'">'.$name.'</option>';
		}
		
		$stmt->close();
		
		
		
		$html .= '</select>';
		return $html;
		
	}
	
	

?>
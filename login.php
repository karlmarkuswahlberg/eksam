<h2>Linnuvaatlusmärkmik</h2>
<h3>Siin lehel saad lisada nähtud linnuliike, vaatlusaegu ning isendite arvu.</h3>

<?php

	
	require_once("functions.php");
	
	if(isset($_SESSION['logged_in_user_id'])){
		header("Location: data.php");
	}
	
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";
 
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
   //LOGIN
   
		if(isset($_POST["login"])){
			if ( empty($_POST["email"]) ) {
				$email_error = "See väli on kohustuslik";
			}else{
       
				$email = cleanInput($_POST["email"]);
			}
			if ( empty($_POST["password"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}
      
			if($password_error == "" && $email_error == ""){
				//Sisselogitud
			
                $hash = hash("sha512", $password);
                
                logInUser($email, $hash);
                
            
            
            }
		}
  
    //LOO KASUTAJA
   
    if(isset($_POST["create"])){
			if ( empty($_POST["create_email"]) ) {
				$create_email_error = "Email on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}
			if ( empty($_POST["create_password"]) ) {
				$create_password_error = "Parool on kohustuslik!";
			} else {
				if(strlen($_POST["create_password"]) < 6) {
					$create_password_error = "Peab olema vähemalt 6 tähemärki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				}
			}
			if(	$create_email_error == "" && $create_password_error == ""){
				
                echo "Kasutaja loodud!";
                
                $hash = hash("sha512", $create_password);
                
                
               createUser($create_email, $hash); 
                
                
            }
        }
	
	}
 
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }

 
  
?>
<!DOCTYPE html>

<html>
<head>
  <title>Login</title>
</head>
<body>

  <h2>Log in</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
  	<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Log in">
  </form>

  <h2>Create user</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
  	<input type="submit" name="create" value="Create user">
  </form>
<body>
<html>
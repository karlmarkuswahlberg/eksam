
<?php
	require_once("functions.php");
	if(!isset($_SESSION['logged_in_user_id'])){
		header("Location: login.php");
	}
	
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php"); 
	}
	$m = "";
	$bird_name = $observed = $bird_count = "";
	$bird_name_err = $observed_err = $bird_count_err = "";
	
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		if(isset($_POST["add_bird"])){
		
		if ( empty($_POST["bird_name"]) ) {
				$bird_name_err = "Sisesta linnunimi";
			}else{
				$bird_name = cleanInput($_POST["bird_name"]);
			}	
		if ( empty($_POST["observed"]) ) {
				$observed_err = "Sisesta vaatlusaeg";
			}else{
				$observed = cleanInput($_POST["observed"]);
			}	
		if ( empty($_POST["bird_count"]) ) {
				$bird_count_err = "Sisesta lindude arv";
			}else{
				$bird_count = cleanInput($_POST["bird_count"]);
			}	
		}

	if($bird_name_err == "" && $observed_err == "" && $bird_count_err == ""){
		$m = addBird($bird_name, $observed, $bird_count);
		
		if($m != ""){
			$bird_name = "";
			$observed = "";
			$bird_count = "";
			}
		}
	}
	
	function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
  getAllData();
  
?>

<?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1">Logi välja!</a>

<h2>Lisa vaadeldud linnuliik</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <label for="bird_name"> Linnuliik: </label>
  	<input id="bird_name" name="bird_name" type="text" placeholder="nt. musträstas" value="<?=$bird_name;?>"> <?=$bird_name_err;?><br><br>
	<label for="observed"> Vaatlusaeg:  </label>
    <input id="observed" name="observed" type="text" placeholder="nt. 2. jaanuar 2015" value="<?=$observed;?>"> <?=$observed_err;?><br><br>
	<label for="bird_count"> Isendite arv: </label>
  	<input id="bird_count" name="bird_count" type="text" placeholder="nt. 6" value="<?=$bird_count;?>"> <?=$bird_count_err;?><br><br>
	<input type="submit" name="add_bird" value="Lisa">
	<p style="color:green;"><?=$m;?></p>
  </form>
  <br>
  <a href='table.php'>Tabelit vaatama</a>
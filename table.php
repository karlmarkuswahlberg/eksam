
<?php
	require_once("functions.php");
	if(!isset($_SESSION['logged_in_user_id'])){
		header("Location: login.php");
	}
	
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php"); 
	}
	$bird_array = getAllData();
	
?>
<h1>Linnuvaatluse tabel</h1>
<table border=1>
<tr>
	
	<th>Kasutaja ID</th>
	<th>Linnuliik</th>
	<th>Vaatlusaeg</th>
	<th>Lindude arv</th>
	
</tr>
<?php

	for($i = 0; $i < count($bird_array); $i++){
		if(isset($_GET["edit"]) && $_GET["edit"] ==  $bird_array[$i]->id){
			echo "<tr>";
			echo "<form action='table.php' method='get'>";
			echo "<input type='hidden' name='bird_id' value='".$bird_array[$i]->id."'>";
			
			echo "<td>".$bird_array[$i]->user_id."</td>";
			echo "<td><input name='bird_name' value='".$bird_array[$i]->bird_name."'></td>";
			echo "<td><input name='observed' value='".$bird_array[$i]->observed."'></td>";
			echo "<td><input name='bird_count' value='".$bird_array[$i]->bird_count."'></td>";
			echo"</tr>";
	}else{
		
		
			echo "<td>".$bird_array[$i]->user_id."</td>";
			echo "<td>".$bird_array[$i]->bird_name."</td>";
			echo "<td>".$bird_array[$i]->observed."</td>";
			echo "<td>".$bird_array[$i]->bird_count."</td>";
			
			echo "</tr>";
		
	}
	}
?>
</table>
<br>
<a href='data.php'>Lisa uus linnuliik</a>
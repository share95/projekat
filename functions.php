<?php
	$dbhost = 'localhost';
	$dbname = 'shbasketball';
	$dbuser = 'root';
	$dbpass = '';
	$appname = "SHARE Basketball";

	$salt1 = "qm&h*";
	$salt2 = "pg!@";

	$connection = new mysqli($dbhost,$dbuser, $dbpass, $dbname);
	if($connection->connect_error){
		die($connection->connect_error); //salje poruku koja je data kao parametar i prekida izvrsenje
	}

	function qM($query) {  //queryMysql
		global $connection;
		$result = $connection->query($query);
		if(!$result) die($connection->error);
		return $result;
	}

	function cT($name, $query) { //createTable
		qM("CREATE TABLE IF NOT EXISTS $name($query)");// TYPE='InnoDB' da se postavi tip tabele da rade strani kljucevi
		echo "Table `$name` created or already exists.<br>";
	}

	function sS($var) {  //sanitizeString - da brise specijalne karaktere
		$var = strip_tags($var);
		$var = htmlentities($var);
		$var = stripslashes($var);
		global $connection;
		return $connection->real_escape_string($var); //?
	}

	function dS() { //destroySession
		$_SESSION = array();
		session_destroy();
	}

	function sP($id){ //showProfile
		$result = qM("SELECT * FROM `profiles` WHERE `user_id`=$id");
		if($result->num_rows){
			$row = $result->fetch_array(MYSQL_ASSOC);
			if(file_exists($id.".jpg")){
					echo "<img src='".$id.".jpg' style='float:left;'>";
			}
			echo stripslashes($row['text']);
			echo "<br><br>";
		}
	}

	function dI($id){ //deleteImage
		$result = qM("SELECT * FROM `images` WHERE `id`=$id");
		if($result->num_rows){
			$row = $result->fetch_assoc();
			unlink($row['file_path']);
			qM("DELETE FROM `images` WHERE `id`=$id");
		}
	}

	function sI($id){  //showImages
		$result = qM("SELECT * FROM `images` WHERE `user_id`=$id");
		if($n = $result->num_rows){
			for($j = 0; $j < $n; $j++){
				$row = $result->fetch_array(MYSQL_ASSOC);
				echo "<img src='".$row['file_path']."' alt = 'text' class='images'>Image name: "."<span>".$row['date_update']."</span>";
				echo "<input type='button' value='delete' onclick='window.location.href=\" /galery.php?id=" . $row['id']. "\"'><br><br>";
			}
		}
	}

<?php
	require_once 'functions.php';

	if(isset($_POST['user'])){
		$user = sS($_POST['user']);
		$result = qM("SELECT * FROM `members` WHERE `user`='$user'");
		if($result->num_rows){
			echo "<span class='taken'>&nbsp;&#x2718; This username is taken</span>";
		}
		else {
			echo "<span class='available'>&nbsp;&#x2714; This username is available</span>";
		}
	}
?>

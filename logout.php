<?php
	require_once 'header.php';
	
	if(isset($_SESSION['user'])){
		dS();
		echo "<div class='main'>You have been logged out. Please ".
				"<a href='index.php'>click here</a>".
				" to refresh the screen.";
	}
	else{
		echo "<div class='main'>You cannont log out because you are not logged in.";
	}
echo "<br></div></body></html>";
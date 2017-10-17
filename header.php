<?php

	session_start();

	echo "<!DOCTYPE html><html><head>";
	
	require_once 'functions.php';
	require_once 'Role.php';
	$userstr = ' (Guest)';
	if(isset($_SESSION['user'])){
		$id = $_SESSION['id'];
		$user = $_SESSION['user'];
		$loggedIn = TRUE;
		$userstr = " ($user)";
	}
	else{
		$loggedIn = FALSE;
	}
	
	echo "<title>$appname$userstr</title>".
	"<link type='text/css' rel='stylesheet' href='styles.css'></link>".
	"</head><body><center><canvas id='logo' width='624' height='96'>".
	"$appname</canvas></center>".
	"<div class='$appname'>$appname$userstr</div>";
?>
<?php if(!$loggedIn){?>	
	<ul class="menu">
		<li><a href="index.php">Home</a></li>
		<li><a href="signup.php">Sign up</a></li>
		<li><a href="login.php">Log in</a></li>
	</ul>
	<br>
	<span class="info">&#8658; You must be logged in to view this site.</span>
<?php } else {
    $result = qM("SELECT * FROM `members` AS m LEFT JOIN `member_role` AS mr ON
                          `m`.`id`=`mr`.`member_id` LEFT JOIN `roles` AS r ON `mr`.`role_id`=`r`.`id` WHERE `m`.`id`=$id");
    while ($row = $result->fetch_assoc()){
        if($row['id']==Role::ADMIN){
            echo"<a href='manage_users.php'>Manage Users</a>";
			echo"<a href='manage_fields.php'>Manage Fields</a>";
        }
    }
    ?>

	<ul class="menu">
  		<li> <a href="members.php?id=<?php echo $id?>">Home</a> </li>
  		<li> <a href="members.php">Clanovi</a> </li>
  		<li> <a href="fields.php">Tereni</a> </li>
  		<li> <a href="friends.php">Prijatelji</a> </li>
  		<li> <a href="profile.php">Profil</a> </li>
  		<li> <a href="logout.php">Log out</a> </li>
	</ul><br>
<?php }?>
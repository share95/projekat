<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
	function cU(user){
		if(user.value == ''){
			document.getElementById('info').innerHTML = '';
			return;
		}
		$.ajax({
			method : "POST",
			url : "checkuser.php",
			data: {
				'user' : user.value
			},
			success : function(result){
				document.getElementById('info').innerHTML = result;
			}
		});
	}
</script>

<?php
	require_once 'header.php';

	$user = $pass = $error = '';
	if(isset($_POST['user'])){
		$user = sS($_POST['user']);
		$pass = sS($_POST['pass']); //index = name atribut
		if($user == '' || $pass == ''){
			$error = "Not all fields were entered<br>";
		}
		else{
			$result = qM("SELECT * FROM `members` WHERE `user`='$user'");
			if($result->num_rows){
				$error = "That username is already in use<br><br>";
			}
			else{
				$hpass = hash('ripemd128', "$salt1$pass$salt2");
				qM("INSERT INTO `members`(`user`,`pass`) VALUES ('$user', '$hpass')");
				die("<h4>Account created</h4>Please log in");
			}
		}
	}

?>

		<form method="post" action="signup.php">
			<?php
				echo $error
			?>
			<br>
			<label class="fieldname" for="user">Username</label>
			<input type="text" name="user" id="user" value="" maxlength="16" onBlur="cU(this)">
			<span id="info"></span>
			<br>

			<label class="fieldname" for="pass">Password</label>
			<input type="password" name="pass" id="pass" value="" maxlength="16"><br>

			<label class="fieldname">&nbsp;</label> <!-- za poravnanje -->
			<input type="submit" value="Sign up">

		</form>
	</body>
</html>

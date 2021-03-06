<?php 
	require 'config.php';

	//If something send in POST
	if(!empty($_POST)){

		//Stock login and different password
		$login      = $_POST['login'];
		$password_1 = $_POST['password-1'];
		$password_2 = $_POST['password-2'];

		//Get users with login in DB
		$prepare = $pdo->prepare('SELECT 1 FROM users WHERE login=:login');
		$prepare->bindValue(':login', $login);
		$prepare->execute();
		$user 	 =$prepare->fetch();

		//If user already exist in DB
		if($user){
			echo "User arleady exist, please choose and other one<br/>";
		}
		//If user don't exist in DB
		else{		
			//if same password
			if($password_1 == $password_2){
				$prepare = $pdo->prepare('INSERT INTO users (login, password) VALUES (:login, :password)');
				$prepare->bindValue('login', $login);
				$prepare->bindValue('password', hash('sha256', $password_1.SALT));

				$exec = $prepare->execute();

				if($exec)
					echo "User registred, go to login page<br/>";
			}

			//If different password
			else{
				echo 'Password are not the same<br/>';
			}
			
		}



	}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Inscription</title>
	<link rel="stylesheet" type="text/css" href="../src/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../src/css/style.css">
</head>
<body>
	<a href="../index.php">Login</a>
	<!-- Inscription form -->
	<form action="#" method="POST">
		<div>
			<input type="text" name="login" id="login">
			<label for="login">Login</label>
		</div>
		<div>
			<input type="password" name="password-1" id="password-1">
			<label for="password-1">Password</label>
		</div>
		<div>
			<input type="password" name="password-2" id="password-2">
			<label for="password-2">Confirm Password</label>
		</div>
		<div>
			<input type="submit" value="Valider" name="submit">
		</div>
	</form>

	<script type="text/javascript" src="../src/js/jquery.min.js"></script>
	<script type="text/javascript" src="../src/js/script.js"></script>
</body>
</html>
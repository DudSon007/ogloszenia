<?php
	session_start();

	if (isset($_SESSION ['login']) && $_SESSION ['login'] = true) 
	{
		header('Location:index.php');
	}
	else
	{
		
	}

	require_once('resources/db_connect.php');
	/* walidacja formularza */
	$login = '';
	$password = '';
	$errorLogin = '';
	$errorPassword = '';
	$error = '';
	$userLogin = 0;
	if( isset($_POST['ok']) )
	{
		$login = $_POST['login'];
		$password = $_POST['password'];

		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$password = htmlentities($password, ENT_QUOTES, "UTF-8");

		if( ! $login )
		{
			$errorLogin = 'Musisz wpisać login';
		}
		if( ! $password )
		{
			$errorPassword = 'Musisz wpisać hasło';
		}


		/* otwarcie połączenia z baządanych */
		/*$sql = "SELECT * FROM users WHERE username='$login' AND password='$password'";*/
		if( $result = $mysqli->query(
		sprintf("SELECT * FROM users WHERE username='%s' AND password='%s'",
		mysqli_real_escape_string($mysqli,$login),
		mysqli_real_escape_string($mysqli,$password)
		)))
		{
			$users = $result->num_rows;
			if( $users == 1 )
			{
				$_SESSION ['login'] = true;
				$goodLogin = $result->fetch_assoc();
				$_SESSION['username'] = $goodLogin['username'];
				$userPassword = $goodLogin['password']; 

				header('Location:add.php');
				$userLogin = 1;	
				$result->close();
			}
			else
			{
					if( $login != null)
					{
						$error = '</br>Nieprawidłowy login lub hasło</br>';
					}	
					
			}
		}
	}
	/* zamknięcie połączenia z bazą danych */
	$mysqli->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ogłoszenia lokalne</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="style/style.css">
</head>
<body>
	<header>
		<?php include("resources/header.php"); ?><!-- Dołączenie nagłówka strony wraz z menu -->
	</header>

	<main>
		<div class="loginForm">
			<h2>Zaloguj się</h2>
					
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
				<div class="requiredFiled">
					<label for="login">Login:</label>
					<?php if( $error != null ) { ?>
						<span class="redLabel">
							<?php echo $error; ?>
						</span>
					<?php } ?>
					<?php if( $errorLogin != null ) { ?>
						<span class="redLabel">
							<?php echo $errorLogin; ?>
						</span>
					<?php } ?>
					<input type="text" name="login" id="login">
				</div>
				<div class="requiredFiled">
					<label for="hasło">Hasło:</label>
					<?php if( $errorPassword != null ) { ?>
						<span class="redLabel">
							<?php echo $errorPassword; ?>
						</span>
					<?php } ?>
					<input type="password" name="password" id="password">
				</div>
				<input class="loginButton" type="submit" name="ok" id="ok" value="Zaloguj">
			</form>
			<a href="#">Zapomniałem hasła</a>
			<a href="registration.php">Nie mam konta</a>
		</div>
	</main>

	<footer>
		<?php include('resources/footer.php'); ?>
	</footer>
</body>
</html>
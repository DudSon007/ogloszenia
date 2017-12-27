<?php 
session_start();
include_once('resources/db_connect.php');
/* Przeniesienie do strony index.php kiedy użytkownik jest zalogowany */
	if (isset($_SESSION ['login']) && $_SESSION ['login'] = true) 
	{
		header('Location:index.php');
	}
		$phpInfo = '';
		$login = '';
		$email = '';
		$email2 = '';
		$good = '';
	$errorLogin = '';
	$errorEmail = '';
	$errorEmail2 = '';
	$randomPassword = substr(md5(rand()), 0, 6);

	if( isset($_POST['registration']) )
	{
		$login = $_POST['login'];
		$email = $_POST['email'];
		$email2 = $_POST['email2'];
		$loginInBase = $mysqli->query("SELECT * FROM users WHERE username = '$login'");
		$result = $loginInBase->fetch_assoc();
		$lginCheck = $result['username'];

		$emailInBase = $mysqli->query("SELECT * FROM users WHERE email = '$email'");
		$result2 = $emailInBase->fetch_assoc();
		$emailCheck =  $result2['email'];

		if ( ! $login )
		{
			$errorLogin = 'Login jest obowiązkowy';
		}
		else if( $login && (strlen($login) < 5 || strlen($login) > 15 ))
		{
			$errorLogin = 'Login musi składać się z 5 do 10 znaków';
		}

		else if ( $login == $lginCheck)
		{
			$errorLogin = 'Użytkownik o podanym loginie już instnieje';
		}
		if ( ! $email )
		{
			$errorEmail = 'Email jest obowiązkowy';
		}
		else if ( $email != $email2 )
		{
			$errorEmail = 'Emial nie zgadza się';
			$errorEmail2 = 'Emial nie zgadza się';
		}
		else if ( $email && !filter_var($email, FILTER_VALIDATE_EMAIL) )
		{
			$errorEmail = 'Emial ma niepoprawny format';
		}
		else if ( $email == $emailCheck)
		{
			$errorEmail = 'Użytkownik o podanym adresie email już istnieje';
			$errorEmail2 = 'Użytkownik o podanym adresie email już istnieje';
		}
		else if( ! $errorLogin && ! $errorEmail && ! $errorEmail2 )
		{
			$to = $email;
			$subject = 'Twoje dane do logowania (Ogłoszenia lokalne)';
			$message = 'Twój login to: '. $login . ' a twoje hasło to: '. $randomPassword;
			$emailSent = mail($to, $subject, $message);
			$good = 1;
		}
	}

	/* Dodawanie użytkownika do bazy */
	if ( isset($_POST['registration']) && $good == 1 )
	{
		$mysqli->query("INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES (NULL, '$login', '$randomPassword', '$email')");
		$phpInfo = 'Możesz się teaz zalogować hasło zostało wysłane na twój email';
		$login = '';
		$email = '';
		$email2 = '';
	}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ogłoszenia lokalne</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="style/style.css">
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
	<header>
		<?php include("resources/header.php"); ?><!-- Dołączenie nagłówka strony wraz z menu -->
	</header>

	<main>
		<div class="loginForm">
			<h2>Zarejestruj się</h2>
				<?php if( $good == 1 ) { ?>
				<span class = greenLabel>	
					<?php echo $phpInfo; ?>
				</span>
				<?php } ?>

			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div class="requiredFiled">
					
					<label for="login">Login:</label>
						<?php if( $errorLogin != null ) { ?>
						<span class="redLabel">
							<?php echo $errorLogin; ?>
						</span>
						<?php } ?>
					<input type="text" name="login" id="login" value="<?php echo $login ?>">
				</div>
				<div class="requiredFiled">
					<label for="email">Adres Email:</label>
						<?php if( $errorEmail != null ) { ?>
						<span class="redLabel">
							<?php echo $errorEmail; ?>
						</span>
						<?php } ?>
					<input type="text" name="email" id="email" value="<?php echo $email ?>">
				</div>

				<div class="requiredFiled">
					<label for="email">Powtórz adres Email:</label>
						<?php if( $errorEmail2 != null ) { ?>
						<span class="redLabel">
							<?php echo $errorEmail2; ?>
						</span>
						<?php } ?>
					<input type="text" name="email2" id="email2" value="<?php echo $email2 ?>">
				</div>
				
				<div class="terms">		
						<!--<input type="checkbox" name="regulations" id="regulations">-->
					<span class="greenLabel">Rejestracja w serwisie jest jednoznaczna z akceptacją regulaminu</span>	
				</div>

				<input class="loginButton" type="submit" name="registration" id="registration" value="Zarejestruj">
			</form>
		</div>
	</main>

	<footer>
		<?php include('resources/footer.php'); ?>
	</footer>
</body>
</html>
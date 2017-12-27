<?php  
	session_start();
	if (isset($_SESSION ['login']) && $_SESSION ['login'] = true) 
	{
		
	}
	else
	{
		header('Location:login.php');
	}

	$title = '';
	$category = '';
	$content = '';
	$nickname = '';
	$email = '';
	$errorTitle = '';
	$errorCategory = '';
	$errorContent = '';
	$errorNickname = '';
	$errorEmail = '';
	$good = 0;

	/* walidacja formularza */

	if( isset($_POST['ok']) )
	{
		$title = $_POST['title'];
		$category = $_POST['category'];
		$content = $_POST['content'];
		/*
		$nickname = $_POST['nickname'];
		*/
		$nickname = $_SESSION['username'];
		/*$email = $_POST['email'];*/
		if ( ! $title )
		{
			$errorTitle = 'Tytuł jest obowiązkowy aby dodać ogłoszenie';
		}
		if ( $category == "sellect" )
		{
			$errorCategory = 'Musisz wybrać kategorię';
		}
		if ( ! $content )
		{
			$errorContent = 'Musisz podać treść ogłoszenia';
		}
		/*
		if ( ! $nickname )
		{
			$errorNickname = 'Musisz się podpisać';
		}
		else if ( $nickname && strlen($nickname) < 6 )
		{
			$errorNickname = 'Podpis musi mieć minimum 6 znaków';
		}
		if ( !$email )
		{
			$errorEmail = 'Musisz podać adres email';
		}
		else if ( $email && ! filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$errorEmail = 'Adres email musi mieć poprawny format';
		}
		/* Wysyłanie email */
		if( ! $errorTitle && ! $errorCategory && ! $errorContent && ! $errorNickname && ! $errorEmail )
		{
			$to = $email;
			$subject = 'Właśnie dodałeś ogłoszenie';
			$message = 'Twoje ogłoszenie zostało dodane pomyślnie';
			$emailSent = mail($to, $subject, $message);
			$good = 1;
		}
	}

	/* dodawanie nowego ogłoszenia */
	include('resources/db_connect.php');
	if ( isset($_POST['ok']) && $good == 1 )
	{
		echo $nickname;
		$title = $_POST['title'];
		$category = $_POST['category'];
		$content = $_POST['content'];
		$nickname = $_SESSION['username'];
		/*$email = $_SESSION['email'];*/
		$title = htmlentities($title, ENT_QUOTES, "UTF-8");
		$category = htmlentities($category, ENT_QUOTES, "UTF-8");
		$content = htmlentities($content, ENT_QUOTES, "UTF-8");
		$nickname = htmlentities($nickname, ENT_QUOTES, "UTF-8");

		$statement = $mysqli->prepare("INSERT classifieds (title, category, content, nickname) VALUES (?,?,?,?)");
		$statement->bind_param("ssss", $title, $category, $content, $nickname);
		$statement->execute();
		$statement->close();

		header("Location:index.php");
	}
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

	<main class="container">
		<div class="addForm">
			<h2>Dodaj ogłoszenie</h2>
			
			<?php if ( $emailSent == 1 ) { ?>
				<span class = "greenLabel">
					<?php echo 'Ogłoszenie zostało dodane. Potwierdzenie dodania ogłoszenia zostało wysłane na twój adres email' ?>
				</span>
			<?php } ?>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
								
				<div class="requiredFiled">
					<label for="Tytuł ogłoszenia">Tytuł ogłoszenia:</label>
					<?php if ( $errorTitle != null ) { ?>
						<span class = "redLabel">
							<?php echo $errorTitle; ?>
						</span>
					<?php } ?>
					<input type="text" name="title" id="title" value="<?php echo $title; ?>">
				</div>

				<div class="requiredFiled">
					<label for="Wybór kategorii">Wybierz kategorię:</label>
					<select name="category" id="category">
						<option value="sellect">Wybierz kategorię</option>
						<option value="Kupię">Kupię</option>
						<option value="Sprzedam">Sprzedam</option>
						<option value="Zamienię">Zamienię</option>
					</select>

					<?php if( $errorCategory != "sellect" ) { ?>
						<span class = "redLabelCat">
							<?php echo $errorCategory; ?>
						</span>
					<?php } ?>
				</div>

				<div class="requiredFiled">
					<label for="Treść ogłoszenia">Treść ogłoszenia:</label>
					<?php if( $errorContent != null) { ?>
						<span class = "redLabel">
							<?php echo $errorContent; ?>
						</span>
					<?php } ?>
					<textarea name="content" id="content" cols="55" rows="10"><?php echo $content; ?></textarea>
				</div>
				<!--
				<div class="requiredFiled">
					<label for="Podpis">Podpis:</label>
					<?php if( $errorNickname != null ) { ?>
						<span class="redLabel">
							<?php echo $errorNickname; ?>
						</span>
					<?php } ?>
					<input type="text" name="nickname" id="nickname" value="<?php echo $nickname; ?>">
				</div>
				
				<div class="requiredFiled">
					<label for="email">Email:</label>
					<?php if( $errorEmail != null ) { ?>
						<span class = "redLabel">
							<?php echo $errorEmail ?>
						</span>
					<?php } ?>
					<input type="text" name="email" id="email" value="<?php echo $email; ?>">
				</div>
				-->
				<input class="addButton" type="submit" name="ok" id="ok" value="Dodaj ogłoszenie">

			</form>
		</div>
	</main>

	<footer>
		<?php include('resources/footer.php'); ?>
	</footer>
</body>
</html>
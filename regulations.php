<?php 
session_start();
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
		<div class="regulationsForm">
			<h2>Regulami serwisu</h2>
				<div class=regulations>
					<p>
						1. Serwis jest w pełni darmowy.<br/>
						2. Ogłoszenie nie może zawierać wulgaryzmów.<br/>
						3. Zakazuję się umieszczć w treści ogłoszenia reklam innych serwisów.<br/>
						4. Przed dodaniem ogłoszenia wymagana jest rejestracja.<br/>
						5. Administrator serwisu nie będzie wysyłać żadnych reklam na adres<br/>
						email podany przy rejestracji.<br/>
					</p>
				</div>
			</div>
		</div>
	</main>

	<footer>
		<?php include('resources/footer.php'); ?>
	</footer>
</body>
</html>
<div class="topMenu">
	<h1>Ogłoszenia lokalne</h1>
	<ol>
		<?php 
			if( isset($_SESSION['username']) )
			{
				echo '<li><a href="logout.php">Wyloguj</a></li>';
			}
			else
			{
				echo '<li><a href="registration.php">Zarejestruj</a></li>';
				echo '<li><a href="login.php">Zaloguj</a></li>';
			}

		?>
		<li><a href="regulations.php">Regulamin</a></li>
		<li><a href="add.php">Dodaj</a></li>
		<li><a href="index.php">Przeglądaj</a></li>
	</ol>
</div>

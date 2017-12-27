<?php session_start(); ?>
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
		<?php include("resources/header.php"); ?><!-- Dołączenie nagłówka strony wraz z menu. -->
	</header>

	<main class="container">

		
		<?php 
		
		/* Połączenie z bazą. */
		include('resources/db_connect.php'); 

		/* Umieszczanie wyników na stronie */
			$records_per_page = 4;

			if($result = $mysqli->query("SELECT * FROM classifieds ORDER BY id DESC"))
			{
				if( $result->num_rows != 0 )
				{
					$total_records = $result->num_rows;
					$total_pages = ceil($total_records / $records_per_page);

					if( isset($_GET['page']) && is_numeric($_GET['page']) )
					{
						$show_page = $_GET['page'];

						if( $show_page > 0 && $show_page <= $total_pages )
						{
							$start = ($show_page - 1) * $records_per_page;
							$end = $start + $records_per_page;	
						}
						else
						{
							$start = 0;
							$end = $records_per_page;
						}
					}
					else
					{
						$start = 0;
						$end = $records_per_page;
					}
					echo "<div class='siteNumber'>";
					echo "<p class='siteNumber'> <span class='lookColor'>Zobacz stronę: </br></span>";
					/*echo "<p><a href='index.php'>Zobacz wszystko</a> | Zobacz stronę: ";*/
					for( $i = 1; $i <= $total_pages; $i++ ) 
					{
						if( isset($_GET['page']) && $_GET['page'] == $i )
						{
							echo "<span class='boldNumber'>" . "[" . $i . "]" . "</span>";
						}
						else
						{
							echo "<a href='index.php?page=$i'>" . "[" . $i . "]" . "</a>";
						}
					}
					echo "</p>";
					echo "</div>";
					echo "<div class='space'>";
					echo "</div>";
					for($i = $start; $i < $end ; $i++)
					{
						if( $i == $total_records)
						{
							break;
						}
						else
						{
							$result->data_seek($i);
							$classified = mysqli_fetch_array($result);
							echo "<div class='formText'>";
							echo '<div class="addForm">';
							echo '<h2>' . '<p>Tytuł ogłoszenia:</p>' . $classified['title'] . '</h2>';
							echo '<h3>' . '<p>Kategoria:</p>' . $classified['category'] . '</h3>';
							echo '<h4>' . '<p>Treść: </br></p>' . $classified['content'] . '</h4>';
							echo '<h5>' . $classified['nickname'] . '</h5>';
							echo '</div>'; 
							echo '</div>'; 

						}
					}
				}
				else
				{
					echo "Brak ogłoszeń w bazie danych";
				}
			}
			else
			{
				echo "Błąd zapytania";
			}
			$mysqli->close();
		?> 
		
	</main>

	<footer>
		<?php include('resources/footer.php'); ?>
	</footer>
</body>
</html>
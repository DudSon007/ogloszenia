<?php 
echo '<p>';
if (isset($_SESSION['username'])) 
{
	echo '<p>' . 'Zalogowany jako: ' . $_SESSION['username'] . '</br>'; 
}
else
{
	echo '</br>';
}

?>
Wszystkie prawa zastrzeżone &copy; Ogłoszenia lokalne 2017 </br> Stronę wykonał DudSon
<?php echo '</p>' ?>
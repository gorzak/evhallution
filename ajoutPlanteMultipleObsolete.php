<!-- menu general -->
<?php
include('fixe.php');

?>

<div id='content'>
<!-- Fonction de BDD à commenter pour comprendre ??? -->
<?php
	$dbh = Database::connect();
	//Donne 1 PI à chaque joueur
	$dbh->exec("UPDATE joueur SET _pi=_pi+1");
	echo "j'ai donné un PI à chaque joueur<br><br>";
	//Ajoute une plante sur chaque case du monde habité
	$repxmin = $dbh->query('SELECT MIN(_x) FROM `creatures`');
	while ($xwmin = $repxmin->fetch())
	$xmin=$xwmin['MIN(_x)'];
	{ echo 'le creature le plus bas en X est en '. $xmin .' <br>'; 
	
	$repxmax = $dbh->query('SELECT MAX(_x) FROM `creatures`');
	while ($xwmax = $repxmax->fetch())
	$xmax=$xwmax['MAX(_x)'];	
	{ echo 'le creature le plus haut en X est en '. $xmax .'<br>'; 
	
	$repymin = $dbh->query('SELECT MIN(_y) FROM `creatures`');
	while ($ywmin = $repymin->fetch())
	$ymin=$ywmin['MIN(_y)'];
	$yraz=$ymin;
	{ echo 'le creature le plus bas en Y est en '. $ymin .'<br>'; 
	echo 'y raz vaut '. $yraz .'<br>';

	$repymax = $dbh->query('SELECT MAX(_y) FROM `creatures`');
	while ($ywmax = $repymax->fetch())
	$ymax=$ywmax['MAX(_y)'];
	{ echo 'le creature le plus haut en Y est en '. $ymax .'<br>'; 
	}}}}// les variables sont en place.
	echo 'le minimum y est '. $ymin .' et le max '. $ymax .'<br>';

	while  ($xmin!=$xmax) { //tant que xmin n'egale pas xmax
		if ($ymin!=$ymax) { //si ymin n'est pas egale à ymax
			Plante::insererPlante($xmin,$ymin); //insère une plante
			print "Plante ajout&eacute; en x=$xmin et y=$ymin <br>";	
			$ymin=(($ymin)+1);} // ajoute 1 à ymin
						// recommence jusqu'à ymin=ymax
		else { // une fois la première collone remplis
			echo "ymin $ymin egale ymax $ymax mais xmin n egale pas xmax<br>";
			$ymin=$yraz;//remet ymin au minimum
			echo "ymin est maintenant $ymin <br>";
			$xmin=(($xmin)+1);//augmente xmax de 1 pour démarrer une nouvelle collonne
			echo "xmin est maintenant $xmin <br>";
			echo "xmax est toujours $xmax <br>";
			}
							} 
							
			

						
					
	
		
 ?>
</div>

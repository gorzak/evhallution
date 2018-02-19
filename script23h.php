<!-- menu general -->

<?php

include(__DIR__ . "/../evoluhall/fixe.php");
?>



<div id='content'>
<?php
	$dbh = Database::connect();
	
	//engendre les naissance
	//On liste tous les joueurs avec le ratio naissance > 1
	$reprepro = $dbh->query('SELECT * FROM joueur WHERE _repro>=1');										
	$resrepro = $reprepro->fetchAll();//
	//si le résultat est 0 on s'arrète
	if (count($resrepro) == 0) {echo 'Il n y a pas de bébé à naitre<br>';}
	//sinon on fais jouer les creatures		
		else { foreach ($resrepro as $resrepro2) {//si il y a des creatures à faire jouer
		$owner=$resrepro2['nom'];
		echo 'je vais faire naitre une créature pour le joueur '. $owner .'<br>';
		//je recherche où la faire naitre
		$replieu = $dbh->query("SELECT * FROM `creatures` where _owner='$owner' ORDER BY _x DESC LIMIT 1"); //recupère les nouvelles informations concernant le creature
		while ($donneeslieu = $replieu->fetch()){	
		$x=$donneeslieu['_x'];	
		$y=$donneeslieu['_y'];
		echo 'Je vais faire naitre une créature en '. $x .' et '. $y .'<br>';
		creature::Naissancecreatures($x,$y,$owner);
		echo 'J ai fais naitre un creature à cette position pour '. $owner .'<br>';
		//On va ajouter un evenement naissance, on cherche la dernière naissance du owner
		$repbb = $dbh->query("SELECT * FROM `creatures` where _owner='$owner' ORDER BY id DESC LIMIT 1"); //recupère les nouvelles informations concernant le creature
		while ($donneesbb = $repbb->fetch()){	
		$id=$donneesbb['id'];			
		Evenement::eventnaissance($id);
		echo 'j ai ajouté un evenement naissance<br>';}
		//On remet le ratio naissance à 0
		$dbh->exec("UPDATE joueur SET _repro=0  WHERE nom='$owner'");
		echo 'J ai remis à zéro le facteur repro de '. $owner .'<br><br>';
		}
		
		
		}}
	
	//Donne 1 PI à chaque joueur
	$dbh->exec("UPDATE joueur SET _pi=_pi+1");
	echo "j'ai donné un PI à chaque joueur<br><br>";
	
	$dbh->exec("INSERT INTO `Event` VALUES (now(), 'PI', 'Tous les joueurs', NULL, '','', 'ont reçu des PI', NULL, NULL, NULL)");
	echo "J'ai ajouté un Event PI<br><br>";
	

	
	//Ajoute une plante sur chaque case du monde habité
	$repxmin = $dbh->query('SELECT MIN(_x) FROM `creatures`');
	while ($xwmin = $repxmin->fetch())
	$xmin=$xwmin['MIN(_x)']-1;
	{ echo 'Le creature le plus bas en X est en '. ($xmin+1) .' Je démarre donc en Xmin='. $xmin .' <br>'; 
	
	$repxmax = $dbh->query('SELECT MAX(_x) FROM `creatures`');
	while ($xwmax = $repxmax->fetch())
	$xmax=$xwmax['MAX(_x)']+1;	
	{ echo 'Le creature le plus haut en X est en '. ($xmax-1) .' Je démarre donc en Xmax='. $xmax .' <br>'; 
	
	$repymin = $dbh->query('SELECT MIN(_y) FROM `creatures`');
	while ($ywmin = $repymin->fetch())
	$ymin=$ywmin['MIN(_y)']-1;
	$yraz=$ymin;
	{ echo 'Le creature le plus bas en X est en '. ($ymin+1) .' Je démarre donc en Xmin='. $ymin .' <br>'; 
	echo 'y raz vaut '. $yraz .'<br>';

	$repymax = $dbh->query('SELECT MAX(_y) FROM `creatures`');
	while ($ywmax = $repymax->fetch())
	$ymax=$ywmax['MAX(_y)']+1;
	{ echo 'Le creature le plus haut en X est en '. ($ymax-1) .' Je démarre donc en Xmax='. $ymax .' <br>'; 
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

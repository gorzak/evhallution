<!-- menu general -->
<?php
include('fixe.php');

?>

<div id='content'>
<!-- Fonction de BDD à commenter pour comprendre ??? -->
<?php
  $dbh = Database::connect();
  $dbh->exec('UPDATE pstats SET nbr=0');//suppression des stats de période
  echo 'J ai vidé la table pstats<br>';
  $dbh->exec('DELETE FROM plantes');// suppression des plantes
  echo 'J ai vidé la table plantes<br>';
  $dbh->exec('DELETE FROM creatures');// suppression des créatures
  echo 'J ai vidé la table creatures<br>';
  $dbh->exec('UPDATE joueur SET _pi=0');// Ràz des Points d'investissement
  echo 'J ai mis les Pis de tous les joueurs à zéro<br>';
  $dbh->exec('UPDATE joueur SET _repro=0');// Ràz du facteur reproduction
  echo 'J ai mis le facteur reproduction de tous les joueurs à zéro<br>';
  $dbh->exec('UPDATE nid SET idj=0');// Ràz des propriétaire des nids
  echo 'Tous les nids n ont plus de propriétaire<br>';
  $dbh->exec('UPDATE joueur SET _nid=0');// Ràz des nids des joueurs
  echo 'Tous les joueurs n ont plus de nids<br>';
  $dbh->exec('UPDATE joueur SET _repro=0');// Ràz du taux de reproduction des joueurs
  echo 'Tous les joueurs ont leur repro à 0<br>';
  $dbh->exec('UPDATE joueur SET _famineMAX=DEFAULT, _pa=DEFAULT, _vue=DEFAULT, _dureedla=DEFAULT ');// Ràz des statistiques des joueurs
  echo 'Tous les joueurs ont leurs stats de races à défaut<br>';
  
  
	//Assigne un nid à chaque joueur
	//Recherche les joueurs sans nid
	$repj = $dbh->query('SELECT * FROM joueur WHERE _nid=0');										
	$resj = $repj->fetchAll();//je tri le résultat 
	//si le résultat est 0 on s'arrète
	if (count($resj) == 0) {echo 'Tous les joueurs ont un nid<br>';}
	//sinon on donne un nid différent à chaque joueur	
		else { foreach ($resj as $resj2) {//pour chaque joueur
		$idj=$resj2['idj'];//on donne l'id du joueur à $idj
		$nomj=$resj2['nom'];//on donne le nom du joueur à $nomj
		$nidj=$resj2['_nid'];//on donne le nid du joueur à $nidj
		echo '<br>je suis le joueur numéro '. $idj .' et mon nom est '. $nomj .'<br>';
		
			//Recherche les nids sans joueurs
			$repnid = $dbh->query('SELECT * FROM nid WHERE idj=0 LIMIT 1');										
			$resnid = $repnid->fetchAll();//je tri le résultat 
			
			//si le résultat est 0 on s'arrète
			if (count($resnid) == 0) {echo 'Il n y a plus de nids disponibles';}
				//sinon on donne un nid différent à chaque joueur	
				else { foreach ($resnid as $resnid2) {//pour chaque nid
					
					//si le joueur n a pas de nid
					if ($nidj == 0) {
					
						$idn=$resnid2['id'];//on donne l'id du nid à $idn
						$idjnid=$resnid2['idj'];//on donne l'id du propriétaire du nid à $idjnid
						$x=$resnid2['_x'];
						$y=$resnid2['_y'];
						echo 'je suis le 	nid numéro '. $idn .' et mon propriétaire est '. $idjnid .'<br>';
			
						//Donne au premier nid un propriétaire
						echo 'je vais donner au nid '. $idn .' le joueur '. $nomj .'<br>';
						$dbh->exec('UPDATE nid SET idj="'. $idj .'" WHERE id='. $idn .'');
						echo 'je vais donner au joueur '. $idj .' dont le nom est '. $nomj .' le nid numéro '. $idn .'<br>';
						$dbh->exec('UPDATE joueur SET _nid='. $idn .' WHERE idj='. $idj .'');
						
						// on va créer 5 creatures sur ce nid, appartenant au propriétaire du nid.
		
						// on listes les données	
						echo 'le nid est en position X='. $xnid .' et Y='. $ynid .'<br>';
						echo 'le joueur concerné est '. $nomj .'<br>';
						$xO=$resnid2['_x'];
						$yO=$resnid2['_y'];
						$owner=$nomj;
						$x=$xO;
						$y=$yO;
						creature::inserer5creatures($x,$y,$owner);
						$x=$xO+1;
						$y=$yO+1;
						creature::inserer5creatures($x,$y,$owner);
						$x=$xO+1;
						$y=$yO-1;
						creature::inserer5creatures($x,$y,$owner);
						$x=$xO-1;
						$y=$yO-1;
						creature::inserer5creatures($x,$y,$owner);
						$x=$xO-1;
						$y=$yO+1;  
						creature::inserer5creatures($x,$y,$owner);	
						echo 'j ai créer 5 creatures en X='. $x .' Y='. $y .' pour le joueur '. $owner .'<br>';
						
						
					}
						
					
					else {echo 'le joueur '. $nomj .' a déjà le nid '. $idn .'';}
			}}
		
		}}
		$dbh->exec('UPDATE creatures SET _pa=6');
		echo '<br>J ai donné 6 pa à chaque creature<br>';
		$dbh->exec("INSERT INTO `Event` VALUES (now(), 'PERIODE', 'Une nouvelle période viens de commencer', NULL, '','', '', NULL, NULL, NULL)");
		ECHO 'Ajout d un evenement Période<br><br>';
 ?>
</div>
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
 
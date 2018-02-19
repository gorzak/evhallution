

<?php

include(__DIR__ . "/../evoluhall/fixe.php");


?>

﻿<meta charset="UTF-8">

<link rel="stylesheet" href="evoluhall.css" />

<!-- le menu general : -->

<div id="fixe">
<a href="index.php" >Accueil</a> -
<a href="creatures.php" >Créatures</a> -
<a href="vue.php" >Vue 2D</a> -
<a href="event.php" >Evènements</a> -
<a href="stats.php" >Statistiques</a> -
<a href="jouer.php" >Jouer</a> -
<a href="http://eh.raistlin.fr/smf/" target="_blank">Forum</a> -
<a href="contact.php" >Contact</a>
</div>

<!-- FIN DE CONTENU DE FIXE.PHP -->


<div id='content'>

<?php
$dbh = Database::connect(); 

//Enlève 2 aux creatures qui ont dépassés leur dla
$repact = $dbh->query('SELECT * FROM creatures WHERE _dla < NOW()');										
$resact = $repact->fetchAll();//je tri le résultat 
//si le résultat est 0 on s'arrète
	if (count($resact) == 0) {echo 'pas de créature avec dla dépassée<br>';}
	//sinon leur impute la famine		
		else { foreach ($resact as $resact2) {//si il y a des creatures à faire jouer
		$id=$resact2['id'];	
	
$dbh->exec("UPDATE creatures SET _famine=_famine-(2) WHERE id=$id");
echo 'J ai descendu de 2 la famine de la créature '. $id .'<br><br>';
	
	
	
$dbh->exec("INSERT INTO `Event` VALUES (now(), 'FAMINE', 'La créature', '". $id ."', '','', 'a subit la famine', NULL, NULL, NULL)");
echo "J'ai ajouté un Event FAMINE<br><br>";
		}}
	
//listes les créatures avec famine =0 et dla dépassée
$repact = $dbh->query('SELECT * FROM creatures WHERE _dla < NOW() AND _famine=0');										
$resact = $repact->fetchAll();//je tri le résultat 
	//si le résultat est 0 on s'arrète
	if (count($resact) == 0) {echo 'pas de créature morte de faim<br>';}
	//sinon on tue ces créatures		
		else { foreach ($resact as $resact2) {//si il y a des creatures à faire jouer
		$id=$resact2['id'];
		Evenement::eventmortfaim($id);
		creature::meurtfamine($id);
		echo 'j ai tué la créature '. $id .' morte de faim<br>';
		}}
		
//donne 12h de durée dla aux créatures qui n'en ont pas (à modifier quand chaque joueur pourra avoir sa durée de dla)
$dbh->exec("UPDATE creatures SET _dureedla='12:00:00' WHERE _dureedla IS NULL");
echo 'j ai mis des dla de 1s aux créatures qui n en avaient pas<br>';
//défini la dla de chaque créature qui n'en a pas
$dbh->exec("UPDATE creatures SET _dla=ADDTIME(now(),_dureedla) WHERE _dla IS NULL");   
echo 'j ai calculé la dla de chaque créature qui n en avaient pas<br>';
		
		
//donne 6 pa aux créatures qui ont dépassé leur DLA
$dbh->exec("UPDATE creatures SET _pa=6 WHERE _dla < NOW()");   
echo 'j ai donné 6 PA aux créatures qui ont dépassées leur dla<br>';
//défini la prochaine dla, d'une créature qui l'a dépassée
$dbh->exec("UPDATE creatures SET _dla=ADDTIME(now(),_dureedla) WHERE _dla < NOW()");   
echo 'j ai calculé la dla de chaque créatures qui ont dépassées leur dla<br>';
  
  
  ?>
 
 
</div>	

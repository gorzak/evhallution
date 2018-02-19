<!-- ici on insère le menu general -->
<?php
 require_once(__DIR__ . "/../evoluhall/utils/classes.php"); 
?>

﻿<meta charset="UTF-8">

<link rel="stylesheet" href="evoluhall.css" />

<!-- ici le contenu de la page -->

	<div id="content">
<?php
class Event {
	public $time;
	public $TypeEvent;
	public $MessCre;
	public $id;
	public $Messde;
	public $nomj;
	public $MessAct;
	public $id2;
	public $X;
	public $Y;
}
//recupere l'id dans l'url 
$nomj=$_GET['nomj'];

function listeEvent () {
	/* retourne tout le contenu de la table evènements */

  $event = array();
  $dbh = Database::connect();
  try {
	  $nomj=$_GET['nomj'];
    $sth = $dbh->prepare("SELECT * FROM `Event` WHERE `nomj`='". $nomj ."' ORDER BY `time` DESC, `TypeEvent`  DESC LIMIT 50");
	
    $sth->setFetchMode(PDO::FETCH_CLASS, 'Event');
    $sth->execute();

    foreach($sth as $p) {
        array_push($event, $p);
    }
    $sth->closeCursor();
    $dbh = null;

    return $event;
  }
  catch (PDOException $e) {
      print $e->getMessage();
    }

}?>
<div id="eventcreature">
    <h2>Liste des Evènements du joueur : <?php echo "$nomj"; ?></h2>
	<?php

if (($_GET['nomj'])!=NULL) // On a une id
{	
	
	$liste=listeEvent();
		  foreach($liste as $e) {

			$time = $e->time;
			$TypeEvent = $e->TypeEvent;
			$MessCre = $e->MessCre;
			$id = $e->id;
			$Messde = $e->Messde;
			$nomj = $e->nomj;	
			$MessAct = $e->MessAct;
			$id2 = $e->id2;
			$x = $e->X;
			$y = $e->Y;
			$str = "$e->time : $e->TypeEvent : $e->MessCre : <a href='./eventc.php?id=$id' target='_blank'	>$e->id</a> : $e->Messde : <a href='./eventj.php?nomj=$nomj' target='_blank'	>$e->nomj</a> : $e->MessAct : $e->id2 : $e->X : $e->Y <br>";
			print($str);
}}
else // Il manque des paramètres, on avertit le visiteur
{
	echo 'Il faut renseigner une id de créature !';
}
	?>
	
	
</div>
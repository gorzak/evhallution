<!-- menu general -->
<?php
include './fixe.php';
?>

<div id="content">
  <div id="affichecreatures">
  
  <?php	 $dbh = Database::connect();
	$reponse = $dbh->query('SELECT COUNT(*) FROM `creatures`') ; 
	$resultat = $reponse->fetchColumn(); //je compte les lignes de la réponse
    {
    	}?>
    <h2>Liste des Créatures Vivantes : (<?php echo ''. $resultat .'' ?>)</h2>
<br>Classer par : <a href="./creatures.php">ID</a> : <a href="./creaturesbyj.php">Joueur</a><br><br>
	
	<!-- à commenter pour décrire les fonctions bdd ??? -->
    <?php
      $liste=listecreaturesbyj();
      foreach($liste as $m) {
        $x = $m->_x;
        $y = $m->_y;
		$pa = $m->_pa;
		$owner = $m->_owner;
		$vue = $m->_vue;
		$dla = $m->_dla;
        $str = "Créature Id = $m->id de $owner en ($x,$y) famine: ($m->_famine) Pa: ($pa) Vue: ($vue) DLA: ($dla) <br>";
        print($str);
      }
    ?>
  </div></div>
<div id="content">  
  	<!-- à commenter pour décrire les fonctions bdd ??? -->
<?php
	 $dbh = Database::connect();
	$reponse = $dbh->query('SELECT COUNT(*) FROM `plantes`') ; 
	$resultat = $reponse->fetchColumn(); //je compte les lignes de la réponse
    {
    	}
	?>
  <div id="affichePlantes">
    <h2>Liste des Plantes : (<?php echo ''. $resultat .'' ?>)</h2>
    <?php
      $l=listePlantes();
      foreach($l as $m) {
        $x = $m->_x;
        $y = $m->_y;
        $str = "Plante Id = $m->id en ($x,$y) <br />";
        print($str);
      }
    ?>
  </div>
</div>

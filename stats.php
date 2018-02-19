
<!-- ici on insère le menu general -->
<?php
include 'fixe.php';
?>
<!-- ici le contenu de la page -->
	<div id="content">
<h3>STATISTIQUES GLOBALES</h3><br>
<br>
<?php
	 $dbh = Database::connect();
	$reponse = $dbh->query('SELECT COUNT(*) FROM `plantes`') ; 
	$resultat = $reponse->fetchColumn(); //je compte les lignes de la réponse
    {echo 'Il y a <b>'. $resultat .' Plantes</b> en vie.<br>';
    	}
	?>
<?php
	 $dbh = Database::connect();
	$reponse = $dbh->query('SELECT COUNT(*) FROM `creatures`') ; 
	$resultat = $reponse->fetchColumn(); //je compte les lignes de la réponse
    {echo 'Il y a <b>'. $resultat .' Créatures</b> en vie.<br>';
    	}
	?>	
<?php
 $dbh = Database::connect();
$reponse = $dbh->query('SELECT nbr FROM `stats` WHERE `cat` = "plantedie"') ; 
$resultat = $reponse->fetchColumn(); //je compte les lignes de la réponse
   {echo '<b>'. $resultat .' Plantes</b> ont été mangées.<br>';
    	}
?>	
<?php
 $dbh = Database::connect();
$reponse = $dbh->query('SELECT nbr FROM `stats` WHERE `cat` = "creaturedie"') ; 
$resultat = $reponse->fetchColumn(); //je compte les lignes de la réponse
   {echo '<b>'. $resultat .' Créatures</b> sont mortes.<br>';
    	}
?>	
<?php
 $dbh = Database::connect();
$reponse = $dbh->query('SELECT nbr FROM `stats` WHERE `cat` = "creatureborn"') ; 
$resultat = $reponse->fetchColumn(); //je compte les lignes de la réponse
   {echo '<b>'. $resultat .' Créatures</b> sont nées d une procréation.<br>';
    	}
?>	<br>
</DIV>
	<div id="content">
<h3>STATISTIQUES DE LA PERIODE</h3><br>
<br>
<?php
 $dbh = Database::connect();
$reponse = $dbh->query('SELECT nbr FROM `pstats` WHERE `cat` = "plantedie"') ; 
$resultat = $reponse->fetchColumn(); //je compte les lignes de la réponse
   {echo '<b>'. $resultat .' Plantes</b> ont été mangées.<br>';
    	}
?>	
<?php
 $dbh = Database::connect();
$reponse = $dbh->query('SELECT nbr FROM `pstats` WHERE `cat` = "creaturedie"') ; 
$resultat = $reponse->fetchColumn(); //je compte les lignes de la réponse
   {echo '<b>'. $resultat .' Créatures</b> sont mortes.<br>';
    	}
?>	
<?php
 $dbh = Database::connect();
$reponse = $dbh->query('SELECT nbr FROM `pstats` WHERE `cat` = "creatureborn"') ; 
$resultat = $reponse->fetchColumn(); //je compte les lignes de la réponse
   {echo '<b>'. $resultat .' Créatures</b> sont nées d une procréation.<br>';
    	}
?>
<br>
</DIV>

	<div id="content">
<h3>MEILLEUR creature (actuel)</h3>
<?php
 $dbh = Database::connect();
$reponse = $dbh->query('SELECT * FROM `creatures` ORDER BY `_vue` DESC LIMIT 1') ;
		while ($donnees = $reponse->fetch()) //tri les données récupérées
		{
   echo 'Oeil de faucon ; Créature n°'. $donnees['id'].' de '. $donnees['_owner'] .' ; <b> Meilleur Vue = '. $donnees['_vue'] .' </b> <br>';
    	}
?>	
<br>
</div>
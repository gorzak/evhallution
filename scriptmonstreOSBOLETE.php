<!-- menu general -->
<?php
include('fixe.php');

?>

<div id='content'>

<?php
$id=($_POST['id']); // je transforme le résultat du formulaire en une variable $id
echo "Je suis la créature n° $id et je veux agir ! <br>"; //Description Front End
$dbh = Database::connect(); //connexion à la bdd
    $reponse1 = $dbh->query('SELECT * FROM `creatures` where id='. $id .''); //recupère les informations concernant le creature
while ($donnees = $reponse1->fetch()) //tri les données récupérées
    {
    ?>
    <p> <!-- on liste toutes les données connues en front end -->
    <strong>Id</strong> : <?php echo $donnees['id']; ?><br />
    Ma position est X=<?php echo $donnees['_x']; ?>, et Y=<?php echo $donnees['_y']; ?> <br />
    Ma famine est à <?php echo $donnees['_famine']; ?> et il me reste <?php echo $donnees['_pa']; ?> Points d'actions.<br />   </p>
   
    <?php
    // on va vérifier qu'il y a suffisament de PA
    if ($donnees['_pa']>0) {
    echo 'J ai suffisament de points d actions pour agir ('. $donnees['_pa'] .')<br>';
        //on va vérifier si il y a besoin de manger
        if ($donnees['_famine']<1) {
        echo 'Ma famine est à ('. $donnees['_famine'] .'), je dois donc manger.<br>';
            //je regarde s'il y a des plantes sur la case
            $reponse2 = $dbh->query('SELECT COUNT(*) FROM `plantes` WHERE  _x='. $donnees['_x'] .' AND _y='. $donnees['_y'] .'') ; //à rendre dynamique ensuite
            $resultat2 = $reponse2->fetchColumn(); //je compte les lignes de la réponse
            echo 'Il y a ('. $resultat2 .') plantes sur ma case.<br><br>'; //si il y a des plantes sur la case
				if ($resultat2>0) { 
				echo "Il y a des plantes sur ma case, je peux donc manger.<br>";
								//je mange une plante
				Plante::detruirePlante($donnees['_x'],$donnees['_y']);// ici on détruit la plante
				print 'Plante détruite en x='. $donnees['_x'] .' et y='. $donnees['_y'] .'.<br>';
				$dbh->exec('UPDATE `creatures` SET _famine=_famine+(0.5) WHERE id = '. $id .'');// !!! Ici on règle la quantité de nourriture par plante.
				echo 'Ma famine est remontée de 0.5 points.<br>';	
				$dbh->exec('UPDATE `creatures` SET _pa=_pa-1 WHERE id = '. $id .'');
				echo 'Manger m a couté un pa, il me reste ('. $donnees['_pa'] .') Points d actions.<br>';	
				Evenement::eventmanger($id);
				//ajout d'un évènement manger
				echo 'J ai ajouté un évènement manger<br>';
				$reponse2->closeCursor(); 
					//ferme le curseur qui compte les plantes					
								} 
							
			else {echo "Il n'y a pas de plantes sur ma case, je vais devoir me déplacer.<br>"; //si il n'y a pas de plantes, je me déplace
			//récupérer la vue du creature $id
			$vue=$donnees['_vue'];
			echo 'Ma vue est de '. $vue .' cases.<br>';
			$x=$donnees['_x'];
			$y=$donnees['_y'];
			echo 'Je suis en X='. $x .' et Y='. $y .'<br>';
			$xvuemax=$x+$vue;
			$xvuemin=$x-$vue;
			$yvuemin=$y-$vue;
			$yvuemax=$y+$vue;
			echo 'Je vois donc jusqu en Xmax='. $xvuemax .', Xmini='. $xvuemin .', Ymax='. $yvuemax .', Ymini=' . $yvuemin .'<br><br>';
			//Je cherche la plante la plus proche en nombre de déplacement : formule améliorable à priori avec un truc comme  MAX(ABS(_x), ABS(_y)))
			$reponsevue = $dbh->query('SELECT * FROM plantes  WHERE _x>='. $xvuemin .' AND _x<='. $xvuemax .' AND _y>=' . $yvuemin .' AND _y<='. $yvuemax .' ORDER BY SQRT(((_x-' .$x. ')*(_x-' .$x. '))+((_y-' .$y. ')*(_y-' .$y. '))) LIMIT 1');//changement de coordonnées XY										
			$resultatvue = $reponsevue->fetchAll();
			if (count($resultatvue) == 0) {echo 'Il n y a pas de plantes dans ma vue<br>';
				echo 'Je dois me déplacer vers le centre du monde<br><br>';
				echo 'Je suis en X='. $x .' et Y='. $y .'<br>';
				// je dois me déplacer vers le centre du monde
				//dans quel sens je dois me déplacer en X ?
				
				if (((0)-($x))==0) { echo 'Je ne dois pas me déplacer en X<br>';
				$depx=0;}
				else  { echo 'Je dois me déplacer en X<br>';
						if (((0)-($x))<0) {echo 'Je dois me déplacer -X<br>';
						$depx=(-1);}
						else {echo 'Je dois me déplacer en +X<br>';
						$depx=(+1);}}
				// dans quel sens je dois me déplacer en Y ?
				if (((0)-($y))==0) { echo 'Je ne dois pas me déplacer en Y<br>';
				$depy=0;}
				else  { echo 'Je dois me déplacer en Y<br>';
						if (((0)-($y))<0) {echo 'Je dois me déplacer -Y<br>';
						$depy=(-1);}
						else {echo 'Je dois me déplacer en +Y<br>';
						$depy=(+1);}}
						// si je suis déjà en 0
				if ($depy==0 && $depx==0){ echo 'je ne dois pas me déplacer, je suis LE CENTRE DU MONDE !';}
					else {		
					echo 'Je dois me déplacer selon X='. $depx .' et Y='. $depy .'<br>';
					//je me déplace vers le centre	
					$dbh->exec('UPDATE `creatures` SET _x=_x+'. $depx .', _y=_y+'. $depy .' WHERE id = '. $id .'');//changement de coordonnées XY														
					// je perd un pa
					$dbh->exec('UPDATE `creatures` SET _pa=_pa-1 WHERE id = '. $id .'');// je perd un pa			
					// je verifie ma nouvelle position
					$reponse3 = $dbh->query('SELECT * FROM `creatures` where id='. $id .''); //recupère les nouvelles informations concernant le creature
					while ($donnees3 = $reponse3->fetch()){						
					echo 'Je me suis déplacé vers le centre, je suis maintenant en X=('. $donnees3['_x'] .') et Y=('. $donnees3['_y'] .')<br><br>';
					//j'ajoute un evenement deplacement
					Evenement::eventdep($id,'".$donnees3['_x']."','".$donnees3['_y']."');
					echo 'J ai ajouté un évènement déplacement<br><br>';
			
					echo 'Mon déplacement m a couté un pa, il me reste ('. $donnees3['_pa'] .') Points d actions.<br>';
					}}}	
			else {
				foreach ($resultatvue as $resvue) {
			
			echo 'la plante la plus proche de moi est la plante numéro '. $resvue['id'] .'<br>';
			// je liste les informations de la plante
			echo 'la plante numéro '. $resvue['id'].' est en X='. $resvue['_x'] .' et Y='. $resvue['_y'] .'<br>';
			//dans quel sens je dois me déplacer en X ?
			if ((($resvue['_x'])-($x))==0) { echo 'Je ne dois pas me déplacer en X<br>';
			$depx=0;}
				else  { echo 'Je dois me déplacer en X<br>';
						if ((($resvue['_x'])-($x))<0) {echo 'Je dois me déplacer -X<br>';
						$depx=(-1);}
						else {echo 'Je dois me déplacer en +X<br>';
						$depx=(+1);}}
			// dans quel sens je dois me déplacer en Y ?
			if ((($resvue['_y'])-($y))==0) { echo 'Je ne dois pas me déplacer en Y<br>';
			$depy=0;}
				else  { echo 'Je dois me déplacer en Y<br>';
						if ((($resvue['_y'])-($y))<0) {echo 'Je dois me déplacer -Y<br>';
						$depy=(-1);}
						else {echo 'Je dois me déplacer en +Y<br>';
						$depy=(+1);}}
			echo 'Je dois me déplacer selon X='. $depx .' et Y='. $depy .'<br>';
			// je me déplace vers la plante
			$dbh->exec('UPDATE `creatures` SET _x=_x+'. $depx .', _y=_y+'. $depy .' WHERE id = '. $id .'');//changement de coordonnées XY														
			// je perd un pa
			$dbh->exec('UPDATE `creatures` SET _pa=_pa-1 WHERE id = '. $id .'');// je perd un pa
			// je verifie ma nouvelle position
			$reponse3 = $dbh->query('SELECT * FROM `creatures` where id='. $id .''); //recupère les nouvelles informations concernant le creature
			while ($donnees3 = $reponse3->fetch()){						
			echo 'Je me suis déplacé, je suis maintenant en X=('. $donnees3['_x'] .') et Y=('. $donnees3['_y'] .'), je mangerais plus tard.<br><br>';
			//j'ajoute un evenement deplacement
			Evenement::eventdep($id,'".$donnees3['_x']."','".$donnees3['_y']."');
			echo 'J ai ajouté un évènement déplacement<br><br>';
			echo 'Mon déplacement m a couté un pa, il me reste ('. $donnees3['_pa'] .') Points d actions.<br>';
								
			}//ferme le foreach il y a des plantes dans ma vue.
								}//ferme le else il y a des plantes dans ma vue
			}
					}
         } else {echo 'Ma famine est à ('. $donnees['_famine'] .'), je n ai plus faim, je digère. Burp!.<br>';}
         //stop script à faire
    } else {echo 'Je n ai plus de points d actions, le script s arrète.<br>';}
   
    $reponse3->closeCursor(); //ferme les informations après déplacement
    $reponse1->closeCursor(); //ferme les informations de début de script
    }  
   
    ?>
 
 
</div>	

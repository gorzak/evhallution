<!-- menu general -->
<?php
include('fixe.php');

?>

<div id='content'>
<!-- Fonction de BDD à commenter pour comprendre ??? -->
<?php
  $id=$_POST['id'];
  echo 'je suis le creature '. $id .'<br>';
  creature::ajouterPA($id);
  echo 'j ai à nouveau 6 PA<br>';
  $dbh = Database::connect(); //connexion à la bdd
  $reponse1 = $dbh->query('SELECT * FROM `creatures` where id='. $id .''); //recupère les informations concernant le creature
	while ($donnees = $reponse1->fetch()) //tri les données récupérées
    { echo 'ma famine est à '. $donnees['_famine'] .'<br>';
	if ($donnees['_famine']==0){
  echo 'je vais tuer le creature '. $id .'<br>';
  creature::meurtfamine($id);
  echo 'le creature '. $id .' est mort de faim<br>';
  Evenement::eventmortfaim($id);
  //evenement mort de faim
 echo 'j ai ajouté un évènement MORT DE FAIM<br>';
	}}



 ?>
</div>

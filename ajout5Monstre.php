<!-- menu general -->
<?php
include('fixe.php');

?>

<div id='content'>
<!-- Fonction de BDD à commenter pour comprendre ??? -->
<?php
  $x=$_POST['x'];
  $y=$_POST['y'];
  $owner=$_POST['nomjoueur'];
  creature::inserer5creatures($x,$y,$owner);
  creature::inserer5creatures($x,$y,$owner);
  creature::inserer5creatures($x,$y,$owner);
  creature::inserer5creatures($x,$y,$owner);
  creature::inserer5creatures($x,$y,$owner);
  print "5 creatures ajout&eacute; en x=$x et y=$y pour $owner";
  
 ?>
</div>

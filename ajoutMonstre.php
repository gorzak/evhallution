<!-- menu general -->
<?php
include('fixe.php');

?>

<div id='content'>
<!-- Fonction de BDD à commenter pour comprendre ??? -->
<?php
  $x=$_POST['x'];
  $y=$_POST['y'];
  creature::inserercreatures($x,$y);
  print "creature ajout&eacute; en x=$x et y=$y";
 ?>
</div>

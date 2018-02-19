<!-- menu general -->
<?php
include('fixe.php');

?>

<div id='content'>
<!-- Fonction de BDD à commenter pour comprendre ??? -->
<?php
  $id=$_POST['id'];
  creature::ajouterPA($id);
  echo "Le creature $id a maintenant 6 Points d Actions";
 ?>
</div>

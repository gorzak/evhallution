<!-- menu general -->
<?php
include('fixe.php');

?>

<div id='content'>
<!-- Fonction de BDD à commenter pour comprendre ??? -->
<?php
  $id=$_POST['id'];
  creature::razfamine($id);
  echo "Le creature $id a sa famine à 0";
 ?>
</div>
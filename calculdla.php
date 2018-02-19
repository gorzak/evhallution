<!-- menu general -->
<?php
include('fixe.php');

?>

<div id='content'>

<?php
$id=($_POST['id']); // je transforme le résultat du formulaire en une variable $id
$dbh = Database::connect(); //connexion à la bdd
$dbh->exec('UPDATE creatures SET _dla=ADDTIME(now(),_dureedla) WHERE id='. $id .''); //recupère les informations concernant le creature
ECHO 'j ai calculé la dla du creature '. $id .'';
    ?>
 
 
</div>	

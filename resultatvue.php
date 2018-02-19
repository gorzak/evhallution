<link rel="stylesheet" href="./evoluhall.css" />

<!-- menu general -->
<?php
include './fixe.php';
?>

	<div id="content">
<!-- formulaire de saisie des coordonnées de la vue-->
<br>
<form action="resultatvue.php" method="post">
Nouvelle saisie :<br><br>
X= <input type="text" name="VueX" placeholder="<?php echo $_POST['VueX']; ?>"> Y= <input type="text" name="VueY" placeholder="<?php echo $_POST['VueY']; ?>">
 <input type="submit" name="resY" /> 
</form>

<!-- résultat -->
 <?php
if ( !empty($_POST['VueY']) && !empty($_POST['VueX'])) echo 'La vue est centrée sur : X=' . $_POST['VueX'] . '  Y=' . $_POST['VueY']; //Phrase qui indique le centre de la vue
if ( ( empty($_POST['VueY']) != "") && ( empty($_POST['VueX']) == "0")) echo 'La vue est centrée sur : X=' . $_POST['VueX'] . '  Y=' . $_POST['VueY']; //Phrase qui indique le centre de la vue
if ( ( empty($_POST['VueY']) == "0") && ( empty($_POST['VueX']) != "")) echo 'La vue est centrée sur : X=' . $_POST['VueX'] . '  Y=' . $_POST['VueY']; //Phrase qui indique le centre de la vue

if( empty($_POST['VueY']) && trim($_POST['VueY']) == "") echo '<font color="red">Le champ Y est vide ! </font>'; // si formulaire X n'est pas vide
if( empty($_POST['VueX']) && trim($_POST['VueX']) == "") echo '<font color="red">Le champ X est vide ! </font>'; // si formulaire Y n'est pas vide
?>
<br><br>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<link rel="stylesheet" href="./evoluhall.css" />
</head>
<body>
<center>
<br> C= Créature<br>
<table class="table_1"><!-- parametre du tableau -->

<tr> <!-- première ligne -->
<td><div id="td"><?php echo 'Case = ' .($_POST['VueX']-1) . ';' . ($_POST['VueY']+1) ; ?><br>
	<?php 	 $liste=listecreatures();
		foreach($liste as $m) {
	    $x = $m->_x;
        $y = $m->_y;
	 if ((($m->_x)==($_POST['VueX']-1)) && (($m->_y)==($_POST['VueY']+1))) {
	 echo "C$m->id " ;} 
	}?></div>
</td><!-- première case -->
<td><div id="td"><?php echo 'Case = ' . $_POST['VueX'] . ';' . ($_POST['VueY']+1) ; ?><br>
	<?php 	 $liste=listecreatures();
		foreach($liste as $m) {
	    $x = $m->_x;
        $y = $m->_y;
	 if ((($m->_x)==($_POST['VueX'])) && (($m->_y)==($_POST['VueY']+1))) {
	 echo "C$m->id " ;} 
	}?></div></td><!-- seconde case -->
<td><div id="td"><?php echo 'Case = ' .($_POST['VueX']+1) . ';' . ($_POST['VueY']+1) ; ?><br>
	<?php 	 $liste=listecreatures();
		foreach($liste as $m) {
	    $x = $m->_x;
        $y = $m->_y;
	 if ((($m->_x)==($_POST['VueX']+1)) && (($m->_y)==($_POST['VueY']+1))) {
	 echo "C$m->id " ;} 
	}?></div></td><!-- troisième case -->
</tr>
<tr><!-- seconde ligne -->
<td><div id="td"><?php echo 'Case = ' .($_POST['VueX']-1) . ';' . $_POST['VueY'] ; ?><br>
	<?php 	 $liste=listecreatures();
		foreach($liste as $m) {
	    $x = $m->_x;
        $y = $m->_y;
	 if ((($m->_x)==($_POST['VueX']-1)) && (($m->_y)==($_POST['VueY']))) {
	 echo "C$m->id " ;} 
	}?></div></td>
<td><div id="td"><?php echo 'Case = ' . $_POST['VueX'] . ';' . $_POST['VueY'] ; ?><br>
	<?php 	 $liste=listecreatures();
		foreach($liste as $m) {
	    $x = $m->_x;
        $y = $m->_y;
	 if ((($m->_x)==($_POST['VueX'])) && (($m->_y)==($_POST['VueY']))) {
	 echo "C$m->id " ;} 
	}?></div></td>
<td><div id="td"><?php echo 'Case = ' .($_POST['VueX']+1) . ';' . $_POST['VueY'] ; ?><br>
	<?php 	 $liste=listecreatures();
		foreach($liste as $m) {
	    $x = $m->_x;
        $y = $m->_y;
	 if ((($m->_x)==($_POST['VueX']+1)) && (($m->_y)==($_POST['VueY']))) {
	 echo "C$m->id " ;} 
	}?></div></td>
</tr>
<tr>
<td><div id="td"><?php echo 'Case = ' .($_POST['VueX']-1) . ';' . ($_POST['VueY']-1) ; ?><br>
	<?php 	 $liste=listecreatures();
		foreach($liste as $m) {
	    $x = $m->_x;
        $y = $m->_y;
	 if ((($m->_x)==($_POST['VueX']-1)) && (($m->_y)==($_POST['VueY']-1))) {
	 echo "C$m->id " ;} 
	}?></div></td>
<td><div id="td"><?php echo 'Case = ' . $_POST['VueX'] . ';' . ($_POST['VueY']-1) ; ?><br>
	<?php 	 $liste=listecreatures();
		foreach($liste as $m) {
	    $x = $m->_x;
        $y = $m->_y;
	 if ((($m->_x)==($_POST['VueX'])) && (($m->_y)==($_POST['VueY']-1))) {
	 echo "C$m->id " ;} 
	}?></div></td>
<td><div id="td"><?php echo 'Case = ' .($_POST['VueX']+1) . ';' . ($_POST['VueY']-1) ; ?><br>
	<?php 	 $liste=listecreatures();
		foreach($liste as $m) {
	    $x = $m->_x;
        $y = $m->_y;
	 if ((($m->_x)==($_POST['VueX']+1)) && (($m->_y)==($_POST['VueY']-1))) {
	 echo "C$m->id " ;} 
	}?></div></td>
</tr>


</table>
</center>
</body>
</html>
</div>
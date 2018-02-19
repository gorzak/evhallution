<link rel="stylesheet" href="evoluhall.css" />



<!DOCTYPE html>
<!-- menu general -->
<?php
include './fixe.php';
?>


<html>
	<head>
		<meta charset="uft-8" />

	</head>
	<body>

<div id="content">
Bienvenue sur EvoluHall !<br>
<br>
EvoluHall est jeu vous donnant la responsabilité de l'évolution d'une espèce dans un monde imaginaire.<br>
Le jeu se déroule en tour par tour d'une durée de 24h.<br>
Toutes les 24h vous recevez des points d'investissements.<br>
Vous pouvez dépenser vos points d'investissements à tout moment pour améliorer votre espèce.<br>
Celle ci est incontrolable, gérée par une Intelligence Artificielle commune à tous les joueurs.<br>
<br>
Qui sait si vos choix seront les bons pour maintenir votre espèce en vie au sein de l'évolution permanente ?<br>
<br>
La participation au jeu est entièrement gratuite et l' inscription est ouverte à tous les internautes disposant d'une adresse Email et d'un accès à Internet régulier.<br>
<br>
Au commencement... il n'y avait rien.<br>
Voici une première raison de notre design épuré. Par ailleurs cela nous fait moins de boulot, et en plus c'est plus discret pour jouer au travail !
</div>
<div id="content">
<h3>INSCRIPTION</h3>
La participation au jeu est entièrement gratuite et l' inscription est ouverte à tous les internautes disposant d'une adresse Email et d'un accès à Internet régulier.<br>
L'<a href="">Inscription</a> entraine l'acceptation de <a href="">La Charte</a> et des <a href="">Règles</a>.<br>
		</div>
<div id="content">
<h3>ACTUALIT&#201S</h3>
18/11/2017 : Le jeu est en construction.
		
</div>
<!-- bas de page phrase aléatoire -->
<p class="bottom">
<?php
$lines = file('./citations.txt', /*FILE_IGNORE_NEW_LINES|*/FILE_SKIP_EMPTY_LINES);
$index = array_rand($lines);
echo $lines[$index];
?>
</p>

	</body>

</html>

	



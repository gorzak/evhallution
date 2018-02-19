<!-- ici on insère le menu general -->
<?php
include 'fixe.php';
?>
<!-- ici on insère le menu joueur -->

<?php
include './fixe2.php';
?>

<div id="content">
<center><b>Améliorer votre race</b></center><br>
<br>
Points d'Investissement (PI) restant :<br>
Points Investis :<br>
Temps avant nouveaux PI : <br>
<br>
</div><div id="content">
<center><b>Améliorer une caractéristique</b></center><br>
Attaque actuelle : ?dT     Dés supplémentaire : ?PI<br>
<br>
Dégats actuelle: ?dT     Dés supplémentaire : ?PI<br>
<br>
Esquive actuelle: ?dT     Dés supplémentaire : ?PI<br>
<br>
Vue actuelle: ?dT      Case supplémentaire : ?PI<br>
<br></div><div id="content">
<center><b>Apprendre une Compétence</b></br>
Toutes vos créatures possèdent la compétence.</center><br>
<br>
<b>Carnivore :</b> peut manger une créature si sa Taille est inférieur. Apporte T de nourriture si elle la tue.<br>
Laisse une charogne sur la case d’une durée de vie de X h et de nourriture Y*Taille de l’espèce tuée.<br>
Ne peut plus manger de végétaux.<br>
<br>
<b>Homnivore :</b>  permet de manger des végetaux en étant carnivore<br>
<br>
<b>Meute :</b> Si plusieurs membre d’une espèce sont sur la même case, ils ne comptent que comme un, leur caractéristiques étant fusionnées.<br>
<br>
<b>Soutteraine :</b>  cette espèce peut se déplacer en -1 et 0<br>
<br>
<b>Aerienne :</b>  cette espèce peut se déplacer en 0 et +1<br>
<br>
<b>Charognard :</b>  cette espèce peut manger de la charogne en plus des végetaux.<br>
<br>
<b>Camouflage :</b> ??<br>
<br>
<b>Hermaphrodite :</b> permet de se reproduire seul<br>
<br>
<b>Cannibale :</b> peut manger un membre de son espèce si nécessaire pour survivre.<br>
<br></div><div id="content">
<center><b>Développer un Template</b><br>
Vos nouveaux spécimens peuvent naîtres avec le template.</center><br>
<br>	
<b>Alpha :</b> DLA + lente, bonus en Carac<br>
<b>Cracheur :</b> Attaque à distance<br>
<b>Esculape :</b> Soin des autres créatures<br>
<b>Hancloc :</b> A la mort 2 nouvelles crétures apparaissent (ceux ci ne sont pas Hancloc)<br>
<b>Venimeux :</b> -x PV pour le creature qui le tue<br>
<b>Fouisseur :</b>  permet d’attaquer entre la surface et vers le sol<br>
<b>Rafale :</b> permet d’attaquer entre les air et le sol<br>
</div>

<?php
include('database.php');


class Plante {
  /* Défini la classe Plante: la nourriture de base de evoluhall */
  public $id;
  public $_x;
  public $_y;


  //function __construct($x, $y)
  //{
    /* constructeur de la classe plante*/
    //$this->id = '';
    //$this->_x = $x;
    //$this->_y = $y;
  //}

  public function position()
  {
    /* retourne la position d'une plante */
    return array ($this->_x, $this->_y);
  }

  public static function insererPlante($x,$y)
  {
    /* Insère une plante dans la base de donnée, à la position x,y */
    $dbh = Database::connect();
    $sth = $dbh->prepare("INSERT INTO `plantes` (`_x`, `_y`) VALUES(?,?)");
    $sth->execute(array($x,$y));
    $dbh=null;
  }

  public static function detruirePlante($x,$y) {
    /* Détruit la plante à la position x,y dans la base de donnée*/
    $dbh = Database::connect();
	$dbh->exec("UPDATE pstats SET nbr=((nbr)+1) WHERE `cat` = 'plantedie' ");
	$sth = $dbh->exec("UPDATE stats SET nbr=((nbr)+1) WHERE `cat` = 'plantedie' ");
    $sth = $dbh->prepare("DELETE FROM `plantes` WHERE `_x`=? AND `_y`=? LIMIT 1");
    $success = $sth->execute(array($x, $y));
    $dbh=null;
    return $success;
  }
}

class Evenement {
	/* Définition de la classe de l'event */
	public $id;
	
	public static function eventmanger($id) {
		/*ajoute un evenement manger dans la db pour le creature $id */
	 $dbh = Database::connect();
	$reponse = $dbh->query('SELECT * FROM `creatures` where id='. $id .''); //recupère les informations concernant le creature
	while ($donnees = $reponse->fetch()) //tri les données récupérées
    {
    $sth = $dbh->prepare("INSERT INTO `Event` VALUES (now(), 'MANGER', 'La Créature', '". $id ."', 'de','". $donnees['_owner'] ."', 'a mangée une plante', NULL, NULL, NULL)");
	  $sth->execute(array($id));
    $dbh=null;}}

	public static function eventdep($id) {
		/*ajoute un evenement deplacement dans la db pour le creature $id */
	 $dbh = Database::connect();
	$reponse = $dbh->query('SELECT * FROM `creatures` where id='. $id .''); //recupère les informations concernant le creature
	while ($donnees = $reponse->fetch()) //tri les données récupérées
    {
    $sth = $dbh->prepare("INSERT INTO `Event` VALUES (now(), 'DEPLACEMENT', 'La Créature', '". $id ."', 'de','". $donnees['_owner'] ."', 's est déplacée vers', NULL, '". $donnees['_x'] ."', '". $donnees['_y'] ."')");
	  $sth->execute(array($id));
    $dbh=null;}	}

		public static function eventnaissance($id) {
		/*ajoute un evenement naissance dans la db pour le creature $id */
	 $dbh = Database::connect();
	$dbh->exec("UPDATE pstats SET nbr=((nbr)+1) WHERE `cat` = 'creatureborn' ");
	$sth = $dbh->exec("UPDATE stats SET nbr=((nbr)+1) WHERE `cat` = 'creatureborn' ");
	$reponse = $dbh->query('SELECT * FROM `creatures` where id='. $id .''); //recupère les informations concernant le creature
	while ($donnees = $reponse->fetch()) //tri les données récupérées
    {
    $sth = $dbh->prepare("INSERT INTO `Event` VALUES (now(), 'NAISSANCE', 'La Créature', '". $id ."', 'de','". $donnees['_owner'] ."', 'viens de naitre', NULL, NULL, NULL)");
	  $sth->execute(array($id));
    $dbh=null;}	}
	
		public static function eventmortfaim($id) {
		/*ajoute un evenement MORT DE FAIM dans la db pour le creature $id */
	 $dbh = Database::connect();
	$dbh->exec("UPDATE pstats SET nbr=((nbr)+1) WHERE `cat` = 'creaturedie' ");
	 $sth = $dbh->exec("UPDATE stats SET nbr=((nbr)+1) WHERE `cat` = 'creaturedie' ");
	$reponse = $dbh->query('SELECT * FROM `creatures` where id='. $id .''); //recupère les informations concernant le creature
	while ($donnees = $reponse->fetch()) //tri les données récupérées
    {
    $sth = $dbh->prepare("INSERT INTO `Event` VALUES (now(), 'MORT', 'La Créature', '". $id ."', 'de','". $donnees['_owner'] ."', 'est morte de faim', NULL, NULL, NULL)");
	  $sth->execute(array($id));
    $dbh=null;}	}			


}		

	

class creature {
  /* Définition de la classe creature */
  public $id;
  public $_x;
  public $_y;
  public $_famine;
  public $_pa;
  
  //function __construct($x, $y)
  //{
    /* Constructeur de la classe, à la position x,y */
  //  $this->id = '';
  //  $this->_x = $x;
  //  $this->_y = $y;
  //  $this->_famine = 0;
  //}

  public function position()
  {
    /* Position d'un objet creature */
    return array ($this->_x, $this->_y);
  }
  
 public function pa()
  {
    /* PA d'un objet creature */
    return array ($this->_pa);
  }

  public function faim()
  {
    /* Ajoute 1 à la famine d'un creature */
    $val = $this->_famine +1;
    $this->_famine = $val;
  }

  /* A MODIFIER SELON LES CARACS DU JOUEURS */
  public static function inserercreatures($x,$y) {
    /* ajoute un creature dans la db, à la position x,y */
    $dbh = Database::connect();
    $sth = $dbh->prepare("INSERT INTO `creatures` (`_x`, `_y`) VALUES(?,?)");
    $sth->execute(array($x,$y));
    $dbh=null;
  }

  
    public static function repro($owner) {
    /* augmente de 1 le facteur reproduction du joueur */
    $dbh = Database::connect();
    $sth = $dbh->prepare("UPDATE joueur SET _repro=_repro+0.1  WHERE nom='$owner'");
    $sth->execute(array($owner));
    $dbh=null;
  }
  
    /* A MODIFIER SELON LES CARACS DU JOUEURS */
    public static function Naissancecreatures($x,$y,$owner) {
    /* fais naitre une creature dans la db, à la position x,y, même owner, et event naissance et stat naissance*/
	/* famine à 0, 6 pa */
    $dbh = Database::connect();
    $sth = $dbh->prepare("INSERT INTO creatures (`_x`, `_y`, `_famine`, `_pa`, `_vue`, `_owner`) VALUES (?,?,0,6,3,?) ");
    $sth->execute(array($x,$y,$owner));
    $dbh=null;
  }

  /* A MODIFIER SELON LES CARACS DU JOUEURS */
  public static function inserer5creatures($x,$y,$owner) {
    /* ajoute un creature dans la db, à la position x,y */
    $dbh = Database::connect();
    $sth = $dbh->prepare("INSERT INTO creatures (`_x`, `_y`, `_famine`, `_pa`, `_vue`, `_owner`, `_dla`, `_dureedla`) VALUES (?,?,0,6,3,?,NULL,NULL) ");
    $sth->execute(array($x,$y,$owner));
    $dbh=null;
  }
  
  public static function calculdla($id) {
    /* défini la date limite d'action de la créature $id */
    $dbh = Database::connect();
    $sth = $dbh->prepare("UPDATE creatures SET _dla=ADDTIME(now(),_dureedla) WHERE _id=$id");
    $sth->execute(array($id));
    $dbh=null;
  }
  
  
  public static function detruirecreature($x,$y) {
    /* detruit dans la db le creature à la position x,y */
    $dbh = Database::connect();
	$sth = $dbh->exec("UPDATE stats SET nbr=((nbr)+1) WHERE `cat` = 'creaturedie' ");
    $sth = $dbh->prepare("DELETE FROM `creatures` WHERE `_x`=? AND `_y`=?");
    $success = $sth->execute(array($x, $y));
    $dbh=null;
    return $success;
  }
  public static function meurtfamine($id) {
    /* detruit dans la db le creature à l'id $id */
    $dbh = Database::connect();
    $sth = $dbh->prepare("DELETE FROM `creatures` WHERE `id`=?");
    $success = $sth->execute(array($id));
    $dbh=null;
    return $success;
  }

  public static function ajouterPa($id) {
    /* ajoute 6 pa au creature $id */
	$dbh = Database::connect();
    $sth = $dbh->prepare("UPDATE `creatures` SET _pa=6 WHERE `id`=?"); 
	$success = $sth->execute(array($id));
    $dbh=null;
    return $success;
  }
  public static function razfamine($id) {
    /* Met la famine du creature $id à 0 */
	$dbh = Database::connect();
    $sth = $dbh->prepare("UPDATE `creatures` SET _famine=0 WHERE `id`=?"); 
	$success = $sth->execute(array($id));
    $dbh=null;
    return $success;
  }
}



function listePlantes() {
  /* Retourne tout le contenu de la table plante */

  $plantes = array();
  $dbh = Database::connect();

  try {
    $sth = $dbh->prepare("SELECT * FROM `plantes`");
    $sth->setFetchMode(PDO::FETCH_CLASS, 'Plante');
    $sth->execute();

    foreach($sth as $p) {
        array_push($plantes, $p);
    }

    $sth->closeCursor();
    $dbh = null;

    return $plantes;

  }
  catch (PDOException $e) {
      print $e->getMessage();
    }

}

function listecreatures() {
  /* retourne tout le contenu de la table creatures */

  $creatures = array();
  $dbh = Database::connect();
  try {
    $sth = $dbh->prepare("SELECT * FROM `creatures`");
    $sth->setFetchMode(PDO::FETCH_CLASS, 'creature');
    $sth->execute();

    foreach($sth as $p) {
        array_push($creatures, $p);
    }
    $sth->closeCursor();
    $dbh = null;

    return $creatures;
  }
  catch (PDOException $e) {
      print $e->getMessage();
    }

}

function listecreaturesbyj() {
  /* retourne tout le contenu de la table creatures */

  $creatures = array();
  $dbh = Database::connect();
  try {
    $sth = $dbh->prepare("SELECT * FROM `creatures` ORDER BY _owner");
    $sth->setFetchMode(PDO::FETCH_CLASS, 'creature');
    $sth->execute();

    foreach($sth as $p) {
        array_push($creatures, $p);
    }
    $sth->closeCursor();
    $dbh = null;

    return $creatures;
  }
  catch (PDOException $e) {
      print $e->getMessage();
    }

}



?>

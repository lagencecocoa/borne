<?php
  
define('DB_TYPE', 'mysql');
define('DB_HOST', '149.202.187.252');
define('DB_NAME', 'site1498');
define('DB_USER', 'site1498');
define('DB_PASS', 'nZTeguN5');
define('DB_CHARSET', 'utf8');

$options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

$bdd = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);

$term = $_GET['term'];

$requete = $bdd->prepare('SELECT * FROM orthop_article WHERE art_lib LIKE :term'); // j'effectue ma requête SQL grâce au mot-clé LIKE
$requete->execute(array('term' => '%'.$term.'%'));

$array = array(); // on créé le tableau

while($donnee = $requete->fetch()) // on effectue une boucle pour obtenir les données
{
    array_push($array, $donnee->art_lib); // et on ajoute celles-ci à notre tableau
}

echo json_encode($array); // il n'y a plus qu'à convertir en JSON

?>
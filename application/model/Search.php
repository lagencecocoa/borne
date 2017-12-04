<?php

class Search
{

    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    
    function rechercher($term){
        
        $rq = "SELECT * FROM orthop_article WHERE art_lib LIKE :term";
		$query = $this->db->prepare($rq);
        $query->execute(array('term' => '%'.$term.'%'));

		$res = array();
		while ($rq_row = $query->fetch(PDO::FETCH_ASSOC))
			$res[] = (object) $rq_row;
		return (object) $res;
        
    }
}
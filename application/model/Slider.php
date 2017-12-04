<?php

class Slider
{

    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }


	public function getSlides()
	{
    $query_slides = $this->db->prepare('SELECT * FROM borne_slider');
    $query_slides->execute();
    return $query_slides->fetchAll();
	}

}

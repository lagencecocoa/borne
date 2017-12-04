<?php

class Controller
{
    /**
     * @var null Database Connection
     */
    public $db = null;

    /**
     * @var null Model
     */
    public $model = null;

    /**
     * Whenever controller is created, open a database connection too and load "the model".
     */
    function __construct()
    {
        $this->openDatabaseConnection();
        $this->loadModel();
    }

    /**
     * Open the database connection with the credentials from application/config/config.php
     */
    private function openDatabaseConnection()
    {
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        $this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);
    }

    public function loadModel()
    {
        require APP . 'model/Users.php';
        require APP . 'model/Tasks.php';
        require APP . 'model/Products.php';
        require APP . 'model/Slider.php';
        require APP . 'model/Search.php';
        require APP . 'model/Wishlisted.php';

        $this->users = new Users($this->db);
        $this->tasks = new Tasks($this->db);
        $this->products = new Products($this->db);
        $this->slider = new Slider($this->db);
        $this->search = new Search($this->db);
        $this->wishlisted = new Wishlisted($this->db);
    }
}

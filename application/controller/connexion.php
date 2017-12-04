<?php

class Connexion extends Controller
{ 
   
    public function index()
    {
        require APP . 'view/connexion/index.php';
        
    }

    public function connect()
    {
        if (isset($_POST['connect']) && !empty($_POST['form-username']) && !empty($_POST['form-password'])) {
         $this->users->verif($_POST['form-username'],$_POST['form-password']);
        }
    }

    public function disconnect()
    {
		session_start();
		
        unset($_SESSION['auth']);

        header('Location: /');
    }
	
	
}

    



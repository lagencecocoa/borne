<?php


class user extends Controller
{
	
    public function index()
    {
        session_start();
		$this->users->authenticator();
		
        $task = $this->user->getAllUsers();
        require APP . 'view/_templates/header.php';
        require APP . 'view/user/view.php';
        require APP . 'view/_templates/footer.php';
    }


    public function viewuser($user_id)
    {
		session_start();
		$this->users->authenticator();
		
        if (isset($user_id)) {
            $user = $this->users->getUser($user_id);
            $nbTasks = $this->users->CountTaskByUser($user_id);
            $tasks = $this->users->TaskByUser($user_id);
            $nbTaskThisWeek = $this->users->TaskByUserByWeek($user_id);
            $sumTaskThisWeek = $this->users->TaskTimeByUserByWeek($user_id);
            $sumTaskPassedThisWeek = $this->users->TaskTimeUserdByUserByWeek($user_id);
            require APP . 'view/_templates/header.php';
            require APP . 'view/user/view.php';
            require APP . 'view/_templates/footer.php';
        }     
    }

 
	

}

<?php


class task extends Controller
{


    public function index()
    {
        session_start();
		    $this->users->authenticator();

        $task = $this->tasks->getAlltask();
        $amount_of_task = $this->tasks->getAmountOftasks();
        require APP . 'view/_templates/header.php';
        require APP . 'view/task/index.php';
        require APP . 'view/_templates/footer.php';
    }


    public function addtask()
    {

			session_start();
			$this->users->authenticator();

            $users = $this->users->getAllUsers();
            require APP . 'view/_templates/header.php';
            require APP . 'view/task/add.php';
            require APP . 'view/_templates/footer.php';

    }

    public function createtask()
    {

       //mise à jour de la tache
        if (isset($_POST["submit_add_task"])) {

            $this->tasks->addtask(htmlspecialchars($_POST["title"],ENT_NOQUOTES), htmlspecialchars($_POST["desc"],ENT_NOQUOTES),  $_POST["date"], $_POST['time'],$status = "",htmlspecialchars($_POST['attribute'],ENT_NOQUOTES));
        }

        header('location: ' . URL . 'home');
    }


    public function deletetask($task_id)
    {

        if (isset($task_id)) {
            $this->tasks->deletetask($task_id);
        }

        header('location: ' . URL . 'home');
    }


    public function edittask($task_id)
    {
		session_start();
		$this->users->authenticator();

        if (isset($task_id)) {
            //on récupère la tache courante
            $task = $this->tasks->gettask($task_id);
            //on récupère tous les users (pour leur attribuer la tache courante)
            $users = $this->users->getAllUsers();
            require APP . 'view/_templates/header.php';
            require APP . 'view/task/edit.php';
            require APP . 'view/_templates/footer.php';
        } else {
            header('location: ' . URL . 'home');
        }
    }


    public function updatetask()
    {
       //mise à jour de la tache
        if (isset($_POST["submit_update_task"])) {

            $this->tasks->updatetask(htmlspecialchars($_POST["title"],ENT_NOQUOTES), htmlspecialchars($_POST["desc"],ENT_NOQUOTES),  $_POST["date"], $_POST['time'],htmlspecialchars($_POST['attribute'],ENT_NOQUOTES),$_POST['idUser']);
        }

        header('location: ' . URL . 'home');
    }

    public function viewtask($task_id)
    {
		session_start();
		$this->users->authenticator();

        if (isset($task_id)) {
            //on récupère la tache courante
            $task = $this->tasks->gettask($task_id);
			$hours = explode(":", $task->task_time_passed);
			$remainingTime = $this->tasks->remainingTime($task->task_deadline);
			$formatedDate = new DateTime($task->task_deadline);
			$formatedDate =$formatedDate->format('d-m-Y');
            require APP . 'view/_templates/header.php';
            require APP . 'view/task/view.php';
            require APP . 'view/_templates/footer.php';
        }
    }

    public function enregistreChrono()
    {
        if (isset($_POST["secondes"])) {

            $this->tasks->updateTime(htmlspecialchars($_POST["heures"],ENT_NOQUOTES), htmlspecialchars($_POST["minutes"],ENT_NOQUOTES),  htmlspecialchars($_POST["secondes"],ENT_NOQUOTES),$_POST['task_id']);
        }
    }

	public function setToEnCours()
    {

          $this->tasks->updateStatus($_POST['task_id'],'en cours');

    }

    	public function setToFinish()
    {
          $this->tasks->updateTime(htmlspecialchars($_POST["heures"],ENT_NOQUOTES), htmlspecialchars($_POST["minutes"],ENT_NOQUOTES),  htmlspecialchars($_POST["secondes"],ENT_NOQUOTES),$_POST['task_id']);
          $this->tasks->updateStatus($_POST['task_id'],'terminée');

    }

}

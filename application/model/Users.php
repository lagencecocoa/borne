<?php

class Users
{

    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function verif($formusername, $formpassword)
    {
        if (!empty($formusername) && !empty($formpassword)) {
        $sql ='SELECT * FROM admin_account WHERE email = ?';
        $req = $this->db->prepare($sql);
        $req->execute(array($formusername));
        $user = $req->fetch();
        $password = hash('sha256', $formpassword);
            if (isset($user->id) && $password == $user->password) {
                session_start();
                $_SESSION['auth'] = $user;
                header('location: ' . URL . 'admin');
            } else {
                echo 'Identifiant ou mot de passe incorrect';
                // header('location: ' . URL );
                die();
            }
        }

    }


	public function authenticator()
	{
		if (!isset($_SESSION['auth'])) {
			header('location: ' . URL);
		}
	}

    public function getAllUsers()
    {
        $sql ='SELECT * FROM ar_user';
        $req = $this->db->prepare($sql);
        $req->execute();
        return $req->fetchAll();

    }


    public function getUser($user_id)
    {
        $sql = "SELECT * FROM ar_user WHERE user_id = ? LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array($user_id);
        $query->execute($parameters);

        return $query->fetch();
    }

        public function CountTaskByUser($user_id)
    {
        $sql = "SELECT count(*) as amount_of_tasks FROM ar_task WHERE task_user = ? ";
        $query = $this->db->prepare($sql);
        $parameters = array($user_id);
        $query->execute($parameters);

        return $query->fetch()->amount_of_tasks;
    }

        public function TaskByUser($user_id)
    {
        $today = date("Y-m-d");
        $date = new DateTime($today);
        $week = $date->format("W");
        $sql = "SELECT * FROM ar_task WHERE task_user = ? AND WEEKOFYEAR(task_deadline) = ? ";
        $query = $this->db->prepare($sql);
        $parameters = array($user_id,$week);
        $query->execute($parameters);

        return $query->fetchAll();
    }

        public function TaskByUserByWeek($user_id)
    {

        $today = date("Y-m-d");
        $date = new DateTime($today);
        $week = $date->format("W");
        $sql = "SELECT count(*) as amount_of_tasks_by_week FROM ar_task WHERE task_user = ? AND WEEKOFYEAR(task_deadline) = ? ";
        $query = $this->db->prepare($sql);
        $parameters = array($user_id,$week);
        $query->execute($parameters);

        return $query->fetch()->amount_of_tasks_by_week;
    }

         public function TaskTimeByUserByWeek($user_id)
    {

        $today = date("Y-m-d");
        $date = new DateTime($today);
        $week = $date->format("W");
        $sql = "SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( `task_time` ) ) ) as sum_of_tasks_time FROM ar_task WHERE task_user = ? AND WEEKOFYEAR(task_deadline) = ? ";
        $query = $this->db->prepare($sql);
        $parameters = array($user_id,$week);
        $query->execute($parameters);

        return $query->fetch()->sum_of_tasks_time;
    }

         public function TaskTimeUserdByUserByWeek($user_id)
    {

        $today = date("Y-m-d");
        $date = new DateTime($today);
        $week = $date->format("W");
        $sql = "SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( `task_time_passed` ) ) ) as sum_of_tasks_time_passed FROM ar_task WHERE task_user = ? AND WEEKOFYEAR(task_deadline) = ? ";
        $query = $this->db->prepare($sql);
        $parameters = array($user_id,$week);
        $query->execute($parameters);

        return $query->fetch()->sum_of_tasks_time_passed;
    }


}

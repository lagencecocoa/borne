<?php

class Tasks
{
    
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }


    
    public function getAllTask()
    {
        $sql = "SELECT *, WEEKOFYEAR(task_deadline) AS semaine_deadline FROM ar_task ORDER BY task_deadline ASC";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

   
    public function addTask($title, $desc, $date, $time ,$status,$attribute)
    {
		$today = date("Y-m-d");
        
        if(isset($attribute) && !empty($attribute) && $today <= $date){
            $status ="assignée";
        }elseif($today > $date){
            $status = "dépassée";
        }else{
			$status = "";
		}

        $sql = "INSERT INTO ar_task (task_title, task_desc, task_deadline, task_time, task_status, task_user) VALUES (?,?,?,?,?,?)";
        $query = $this->db->prepare($sql);
        $parameters = array($title, $desc, $date, $time ,$status,$attribute);
        $query->execute($parameters);
    }

   
    public function deleteTask($task_id)
    {
        $sql = "DELETE FROM ar_task WHERE task_id = ?";
        $query = $this->db->prepare($sql);
        $parameters = array($task_id);

        $query->execute($parameters);
    }

    
    public function getTask($task_id)
    {
        $sql = "SELECT *  FROM ar_task WHERE task_id = ? ";
        $query = $this->db->prepare($sql);
        $parameters = array($task_id);
        $query->execute($parameters);

        return $query->fetch();
    }


   
    public function updateTask($title, $desc, $date, $time,$attribute, $task_id)
    {
		
		$today = date("Y-m-d");
		
        if(isset($attribute) && !empty($attribute) && $today <= $date){
            $status ="assignée";
        }elseif($today > $date){
            $status = "dépassée";
        }else{
			$status = "";
		}
        
        //on met à jour les infos de la tache courante
        $sql = "UPDATE ar_task SET task_title = ?, task_desc = ?, task_deadline =?, task_time =? ,task_status = ?, task_user = ? WHERE task_id = ?";
        $query = $this->db->prepare($sql);
        $parameters = array($title, $desc, $date, $time ,$status,$attribute, $task_id);

        $query->execute($parameters);
    }

    
    public function getAmountOfTasks()
    {
        $sql = "SELECT COUNT(task_id) AS amount_of_tasks FROM ar_task";
        $query = $this->db->prepare($sql);
        $query->execute();

        
        return $query->fetch()->amount_of_tasks;
    }

    public function updateTime($heures,$minutes,$secondes,$task_id)
    {
        $time_passe = $heures.':'.$minutes.':'.$secondes;
        $sql = "UPDATE ar_task SET task_time_passed = ? WHERE task_id = ?";
        $query = $this->db->prepare($sql);
        $parameters = array($time_passe , $task_id);
        $query->execute($parameters);
        
        

    }
	
	public function updateStatus($task_id,$status)
    {
        $sql = "UPDATE ar_task SET task_status = ? WHERE task_id = ?";
        $query = $this->db->prepare($sql);
        $parameters = array($status , $task_id);
        $query->execute($parameters);

    }
	
	public function remainingTime($task_date)
	{
		
		$today = date("Y-m-d");
		
		if($today < $task_date){
			
			$dureesejour = 'il reste '. round((strtotime($task_date) - strtotime($today))/86400) .' jour(s) pour cette tâche.';  
			return $dureesejour;
			
		}else{
			
			return 'l\'échéance est dépassée';
		}
	}	
	
	
}

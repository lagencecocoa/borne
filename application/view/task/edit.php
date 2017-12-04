    <div class="col-xs-12 col-sm-8 col-md-6">
	
		<div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Editer la tâche: <?=$task->task_title?></h3>
				
				<?php if($task->task_status == 'terminée') {  ?>
        <small> Tache terminée</small>
        <button type="button" class="btn btn-primary" id="change">Relancer la tâche</button>
        <?php } ?>
            </div>
            <div class="box-body">
              	<form action="<?php echo URL; ?>task/updatetask" method="POST">
            <label>Titre</label><br>
            <input class="form-control" autofocus type="text" name="title" value="<?php echo htmlspecialchars($task->task_title, ENT_NOQUOTES, 'UTF-8'); ?>" required />
            <br>

            <label>Description</label><br>
            <textarea class="form-control" rows="5" style="resize:none" name="desc"><?php echo htmlspecialchars($task->task_desc, ENT_NOQUOTES, 'UTF-8'); ?></textarea>
            <br>

            <label>Deadline</label><br>
            <input class="form-control"  type="date" name="date" value="<?php echo htmlspecialchars($task->task_deadline, ENT_NOQUOTES, 'UTF-8'); ?>" required />
            <br>

            <label>Temps éstimé</label><br>
            <input class="form-control" type="time" name="time" value="<?php echo htmlspecialchars($task->task_time, ENT_NOQUOTES, 'UTF-8'); ?>" required />
            <br>
            <br>
            <input class="form-control"  type="number" name="idUser" style="display:none" value="<?php echo htmlspecialchars($task->task_id, ENT_NOQUOTES, 'UTF-8'); ?>" required />
            <?php

                
                 foreach($users as $user){
                    if($user->user_id == $task->task_user){
                       echo '<input  checked="checked"  type="radio" name="attribute" value="'.$user->user_id.'"  /> '.$user->user_lastname.' '.$user->user_firstname.'<br>';     
                    }else{
                       echo '<input  type="radio" name="attribute" value="'.$user->user_id.'"  /> '.$user->user_lastname.' '.$user->user_firstname.'<br>';
                    } 
                }
               

            ?>

            

            <br>
            <input type="hidden" name="task_id" id="task_id" value="<?php echo htmlspecialchars($task->task_id, ENT_NOQUOTES, 'UTF-8'); ?>">
            <input class="btn btn-primary" type="submit" name="submit_update_task" value="Mettre à jour" />
        </form>
            </div>
            <!-- /.box-body -->
          </div>
</div>


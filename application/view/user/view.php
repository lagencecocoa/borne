<section class="content-header">
      <h1>
        <?php echo $user->user_firstname.' '.$user->user_lastname; ?>
      </h1>
</section>

<section class="content-header">
    <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-speedometer"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Nombres de tâches</span>
              <span class="info-box-number"><?php echo $nbTasks ;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
          <!-- /.info-box -->
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-thermometer"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Nombres de tâches (semaine courante)</span>
              <span class="info-box-number"><?php echo $nbTaskThisWeek ;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
          <!-- /.info-box -->
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-clock"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Temps passé (cette semaine)</span>
              <span class="info-box-number">
				  <?php
						if ( $nbTaskThisWeek > 0){ 
							echo $sumTaskPassedThisWeek.' / '.$sumTaskThisWeek;
						}else{ 
							echo "Aucune tâche cette semaine";
						}
				  
				  		if ($sumTaskPassedThisWeek > $sumTaskThisWeek){ 
							echo '<img style="width:40px;margin-left:10px" src="/public/img/pasbien.png">';
						}?>
			</span>
            </div>
            <!-- /.info-box-content -->
          </div>
    </div>
          <!-- /.info-box -->
    <strong>Détails des tâches (cette semaine): </strong>
            <table class="table table-responsive">
                <thead style="background-color: #ddd; font-weight: bold;">
                <tr>
                    <td>Id</td>
                    <td>Titre</td>
                    <td>Description</td>
                    <td>Durée</td>
                    <td>Editer</td>
					<td>Supprimer</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tasks as $task) { ?>
                    <tr>
                        <td><?php if (isset($task->task_id)) echo htmlspecialchars($task->task_id, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php if (isset($task->task_title)) echo htmlspecialchars($task->task_title, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php if (isset($task->task_desc)) echo htmlspecialchars($task->task_desc, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php if (isset($task->task_time_passed)) echo htmlspecialchars($task->task_time_passed, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><a href="<?php echo URL . 'task/edittask/' . htmlspecialchars($task->task_id, ENT_QUOTES, 'UTF-8'); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
						<td><a href="<?php echo URL . 'task/deletetask/' . htmlspecialchars($task->task_id, ENT_QUOTES, 'UTF-8'); ?>"><i class="fa fa-times" aria-hidden="true"></i></a></td>

                    </tr>
                <?php } ?>
                </tbody>
            </table>
</section>
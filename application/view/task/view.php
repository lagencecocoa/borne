<div class="col-md-3">
	<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo htmlspecialchars($task->task_title, ENT_NOQUOTES, 'UTF-8') ?> (<?php echo htmlspecialchars($task->task_status, ENT_NOQUOTES, 'UTF-8') ?>)</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Description</strong>

              <p class="text-muted">
               	<?php echo htmlspecialchars($task->task_desc, ENT_NOQUOTES, 'UTF-8'); ?>
              </p>

              <hr>

              <strong><i class="fa fa-calendar" aria-hidden="true"></i> Echéance</strong>

              <p class="text-muted"><?php echo $formatedDate;?>, <?= $remainingTime; ?></p>

              <hr>
				
              <strong><i class="fa fa-clock-o" aria-hidden="true"></i> Temps estimé</strong>
			<p class="text-muted"><?php echo $task->task_time; ?></p>
			  <hr>
              <strong><i class="fa fa-clock-o" aria-hidden="true"></i> Tracking</strong>

              <p>
               <input type="hidden" name="task_id" id="task_id" value="<?php echo htmlspecialchars($task->task_id, ENT_NOQUOTES, 'UTF-8'); ?>">

	    <?php if ($task->task_status == 'terminée')  { ?>
             <span style="color:green">Tâche terminée, pour la relancer, contactez un administateur</span>     
        
       <?php  } else  { ?>                 
		<div id="cercle" >

			<div id="panneau"> <!--  Notre panneau qui affichera le temps -->

				<div class="col-xs-1" id="h" style="background-color: white;text-align: center;padding: 15px;font-size: 20px;margin-right:10px"><?= $hours['0'] ?></div>

				<div class="col-xs-1" id="m" style="background-color: white;text-align: center;padding: 15px;font-size: 20px;margin-right:10px"><?= $hours['1'] ?></div>

				<div class="col-xs-1" id="s" style="background-color: white;text-align: center;padding: 15px;font-size: 20px;margin-right:10px"><?= $hours['2'] ?></div>

			</div>

		</div>
	 
		<br>
	
		<div id="start" class="col-xs-1"><i class="fa fa-play" aria-hidden="true"></i></div>

		<div id="pause" class="col-xs-1"><i class="fa fa-pause" aria-hidden="true"></i></div>
		
        <div id="stop" class="col-xs-1"><i class="fa fa-stop" aria-hidden="true"></i></div>
              </p>
        <?php  } ?>
             
            </div>
            <!-- /.box-body -->
         </div>
	</div>
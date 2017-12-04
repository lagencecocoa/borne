<div class="col-xs-12 col-sm-8 col-md-6">
	<div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Créer une tâche</h3>
            </div>
            <div class="box-body">
              	<form action="<?php echo URL; ?>task/createtask" method="POST">
					<label>Titre</label><br>
					<input class="form-control" autofocus type="text" name="title" value="" required />
					<br>

					<label>Description</label><br>
					<textarea class="form-control" rows="5" style="resize: none;" name="desc"></textarea>
					<br>

					<label>Deadline</label><br>
					<input class="form-control"  type="date" name="date" value="" required />
					<br>

					<label>Temps éstimé</label><br>
					<input class="form-control" type="time" name="time" value="" required />
					<br>
					<br>

					<?php
						 foreach($users as $user){

						  echo '<input  type="radio" name="attribute" value="'.$user->user_id.'"  /> '.$user->user_lastname.' '.$user->user_firstname.'<br>';

						}
					?>    

					<br>
					<input class="btn btn-primary" type="submit" name="submit_add_task" value="Créer la tâche" />
        		</form>
            </div>
            <!-- /.box-body -->
          </div>
	 </div>
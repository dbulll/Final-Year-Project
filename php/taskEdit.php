<div class="row">
  <a class="btn btn-info" id="taskBacklogButton" href="taskBacklog.php" style="margin-bottom:10px;"><span class="glyphicon glyphicon-arrow-left"></span> Task Backlog
  </a>
</div>
	<div class="row">
		<h2>
			<?php 
				$taskSql = mysqli_query($conn, 'SELECT * FROM task_table WHERE id = '. $_GET['task_id']);
				$taskRow = mysqli_fetch_array($taskSql);
				echo $taskRow['task_name'];
			?>
		</h2>
	</div>
	<div class="row">
		<h3>Description</h3>
		<p><?php echo $taskRow['task_description'];?></p>
	</div>
	<div class="row">
		<div class="col-lg-4">
			<h4>Estimation: </h4>
			<p><?php echo $taskRow['task_estimation'];?> .hrs</p>
		</div>
		<div class="col-lg-4">
			<h4>Hours Spent</h4>
			<p><?php echo $taskRow['task_actual'];?> .hrs</p>
		</div>
		<div class="col-lg-4">
			<h4>Hours Spent</h4>
			<form class="form-horizontal" id="taskUpdateForm" data-toggle="validator" role="form" novalidate="true" action="taskBacklog.php?task_id=<?php echo $_GET['task_id'];?>" method="post">
			<div class="col-lg-4 form-group has-feedback">
        		<input type="text" class="form-control" name="task_hours" pattern="^[0-9]{1,2}$" maxlength="2" required>
        		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
		    </div>
		    <div class="col-lg-8 form-group has-feedback">
		      <button type="submit" class="btn btn-success pull-right" id="submit_button">Update Task <span class="glyphicon glyphicon-save"></button>
		    </div>
			</form>
		</div>
	</div>
	<div class="row">
		<?php 
			$storyIdSql = mysqli_query($conn, 'SELECT * FROM task_table WHERE id = '. $_GET['task_id']);
			$storyId = mysqli_fetch_array($storyIdSql);
			$sprintIdSql = mysqli_query($conn, 'SELECT * FROM story_table WHERE id = '. $taskRow['story_table_id']);
			$sprintId = mysqli_fetch_array($sprintIdSql);
			if($sprintId['sprint_table_id'] != '')
			{
				echo '<a class="btn btn-info" id="taskboardButton" href="taskboard.php?sprint_id='. $sprintId["sprint_table_id"].'" style="margin-bottom:10px;">TaskBoard <span class="glyphicon glyphicon-arrow-right"></span>
  					</a>';
			}
		?>	
	</div>
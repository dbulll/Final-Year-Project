<div class="row">
	<!-- PHP Code - 1.Insert new Task into the database -->
	<?php
	  $sql = 'UPDATE task_table SET task_actual = '. $_POST["task_hours"] .' WHERE id = '. $_GET['task_id'];
	  if ($conn->query($sql) === TRUE) 
	  {
	   echo '<div class="alert alert-success"><strong>Success!</strong> Task has been successfully updated!</div>';
	  } 
	  else 
	  {
	    echo '<div class="alert alert-failure"><strong>Error!</strong>' . $sql . '<br>' . $conn->error . '</div>';
	  }
	?>
</div>
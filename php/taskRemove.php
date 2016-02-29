<div class="row">
	<!-- PHP Code - 1.Remove Task by the given id. -->
	<?php
	  $sql = 'DELETE FROM task_table WHERE id = ' . $_GET['remove'];
	  if ($conn->query($sql) === TRUE) 
	  {
	   echo '<div class="alert alert-success"><strong>Success!</strong>The Task has been successfully removed.</div>';
	  } 
	  else 
	  {
	    echo '<div class="alert alert-failure"><strong>Error!</strong> ' . $sql . '<br>' . $conn->error . '</div>';
	  }
	?>
</div>
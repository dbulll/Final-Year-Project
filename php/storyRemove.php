<div class="row">
	<!-- PHP Code - 1.Remove Story by the given id. -->
	<?php
	  $sql = 'DELETE FROM story_table WHERE id = ' . $_GET['remove'];
	  if ($conn->query($sql) === TRUE) 
	  {
	   echo '<div class="alert alert-success"><strong>Success!</strong> User Stories and related tasks have been successfully removed.</div>';
	  } 
	  else 
	  {
	    echo '<div class="alert alert-failure"><strong>Error!</strong> ' . $sql . '<br>' . $conn->error . '</div>';
	  }
	?>
</div>
<!-- Form for creating new Task -->
<h2> Create New Task </h2>
<form class="form-horizontal col-lg-8 col-lg-offset-2" id="taskCreationForm" data-toggle="validator" role="form" novalidate="true" action="taskBacklog.php<?php if(isset($_GET['story_id'])){echo '?story_id='. $_GET["story_id"];}?>" method="post">
  <div class="row form-group has-feedback">
    <label class="control-label" for="task_name">Task Name:</label>
    <input type="text" class="form-control" name="task_name" pattern="^[A-z0-9\s]{1,}$" maxlength="30" placeholder="Enter Task Name" required>
    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
  </div>
  <div class="row form-group has-feedback">
    <label class="control-label" for="task_description">Task Description:</label>
    <textarea type="text" class="form-control" name="task_description" maxlength="1000" placeholder="Enter Task Description" rows="3" required></textarea>
    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
  </div>
  <div class="row">
    <div class="col-lg-6">
      <label class="control-label" for="task_story">Story</label>
      <select class="form-control" name="task_story">
        <?php
        $sql = mysqli_query($conn, 'SELECT id, story_name FROM story_table');
        while($row = mysqli_fetch_array($sql))          
        {
          echo '<option value='. $row['id'] .'>'. $row['story_name'].'</option>';
        }
        $conn->close();
        ?>
      </select>
    </div>
    <div class="col-lg-3 form-group has-feedback">
      <label class="control-label" for="task_estimation">Task Estimation (hrs.)</label>
      <input type="text" class="form-control" name="task_estimation" pattern="^[0-9]{1,2}$" maxlength="2" required>
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    </div>
  </div>
  <div class="row form-group has-feedback">
    <button type="submit" class="btn btn-primary pull-right" id="submit_button">Create Task <span class="glyphicon glyphicon-plus"></button>
  </div>
</form>
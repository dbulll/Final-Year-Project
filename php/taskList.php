<!-- List of Tasks in Backlog -->
<div class="table-responsive">        
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Task Name</th>
        <th>Task Description</th>
        <th>Story Name</th>
        <th>Time Estimation</th>
        <th>Time Spent</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <!-- PHP Code - 1.Grab list of Tasks from the database. -->    
    <?php
      if(isset($_GET['story_id']))
      {
        $sql = mysqli_query($conn, 'SELECT a.*, b.story_name FROM task_table a, story_table b WHERE a.story_table_id = b.id AND story_table_id = '.$_GET['story_id']);
      }
      else
      {
        $sql = mysqli_query($conn, 'SELECT a.*, b.story_name FROM task_table a, story_table b WHERE a.story_table_id = b.id');
      }
      while($row = mysqli_fetch_array($sql))          
      {
        ?>
          <tr>
            <td><?php echo $row['task_name'];?></td>
            <td><?php echo $row['task_description'];?></td>
            <td><?php echo $row['story_name'];?></td>
            <td><?php echo $row['task_estimation'];?></td>
            <td><?php echo $row['task_actual'];?></td>
            <td>
              <a class="btn btn-danger" id="removeButton" href="taskBacklog.php?<?php if(isset($_GET['story_id'])){echo 'story_id='. $_GET["story_id"];}?>&remove=<?php echo $row['id'];?>">
                Remove <span class="glyphicon glyphicon-remove"></span>
              </a>
            </td>
            </tr>
        <?php
      }
    ?>
    </tbody>
  </table> 
</div>
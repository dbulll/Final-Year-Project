<!-- This php code will find the list of user stories in the backlog and present them in a drop down select -->
<div class="row">
  <p>Select the desired sprint</p>
  <select class="col-lg-4" id="sprint_list" onchange="sprintChange(event)">
  <option value=0></option>
  <?php
    $sql = mysqli_query($conn, 'SELECT a.id, a.sprint_name, b.release_name FROM sprint_table a, release_table b WHERE a.release_table_id = b.id');
    while($row = mysqli_fetch_array($sql))          
    {
      echo '<option value='. $row['id'].' ';
      if(isset($_GET['sprint_id']))
      {
        if($_GET['sprint_id'] == $row['id'])
        {
          echo 'selected="selected"';
        }
      }
      echo '>'. $row['release_name'].'. '.$row['sprint_name'].'</option>';
    }
  ?>
  </select>
</div>
<!-- This php code will find the list of user stories in the backlog and present them in a drop down select -->
<div class="row">
  <p>Select the desired release</p>
  <select class="col-lg-4" id="release_list" onchange="releaseChange(event)">
  <option value=0></option>
  <?php
    $sql = mysqli_query($conn, 'SELECT id, release_name FROM release_table');
    while($row = mysqli_fetch_array($sql))          
    {
      echo '<option value='. $row['id'].' ';
      if(isset($_GET['release_id']))
      {
        if($_GET['release_id'] == $row['id'])
        {
          echo 'selected="selected"';
        }
      }
      echo '>'. $row['release_name'].'</option>';
    }
  ?>
  </select>
</div>
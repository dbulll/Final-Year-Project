<!-- PHP Code - 1.Insert new Release into the database -->

<?php
  // Grab variables from the form POST
  $release_name = $_POST['release_name'];
  $release_description = $_POST['release_description'];
  $release_start_date =  date('Y-m-d', strtotime($_POST['release_start_date']));
  $release_end_date =  date('Y-m-d', strtotime($_POST['release_end_date']));
  $release_sprint_length = $_POST['release_sprint_length'];
  $release_work_hours = $_POST['release_work_hours'];

  // This section of PHP adds a release to the releaseTable
  $sql = 'INSERT INTO release_table (release_name, release_description, release_start_date, release_end_date, release_sprint_length, release_work_hours) VALUES ("'. $release_name .'", "'. $release_description .'", "'. $release_start_date .'","'. $release_end_date .'", '. $release_sprint_length .','. $release_work_hours .')';
  if ($conn->query($sql) === TRUE) 
  {
   echo '<div class="alert alert-success"><strong>Success!</strong> Release has been successfully created!</div>';
  } 
  else 
  {
    echo '<div class="alert alert-failure"><strong>Error!</strong> ' . $sql . '<br>' . $conn->error . '</div>';
  }

  // This next segment calculates the difference in days between the release start and end date. Using this result i will divide by the by sprint length to calculate the number of sprints to be created!

  $rStart = new DateTime($release_start_date);
  $rEnd  = new DateTime($release_end_date);
  $rDiff = $rStart->diff($rEnd);
  $rDiffDays = $rDiff->days;
  $rSprints = floor($rDiffDays / $release_sprint_length);
  $sprintStartDate = $release_start_date;
  $release_id = mysqli_insert_id($conn);
  $loop=0;
  $success=0;
  while ($loop < $rSprints)
  { 
    //Create variables to insert into the Sprint Table. sprint name, start/end dates, release id.
    $sprintName = 'Sprint '. ($loop+1);
    $sprintStartDate = date('Y-m-d', strtotime($sprintStartDate));
    $sprintEndDate = date('Y-m-d', strtotime($sprintStartDate.'+ '.($release_sprint_length - 1).' days'));
    $sprintSql = 'INSERT INTO sprint_table (sprint_name, sprint_description, sprint_start_date, sprint_end_date, release_table_id) VALUES ("'. $sprintName .'", "Test desc", "'. $sprintStartDate .'","'. $sprintEndDate .'", '. $release_id .')';
    if ($conn->query($sprintSql) === TRUE) 
    {
      $success = $success + 1;
    } 
    $sprintStartDate = $sprintStartDate.'+ '. $release_sprint_length .' days';
    $loop = $loop + 1;
  }
  if ($rSprints == $success)
  {
   echo '<div class="alert alert-success"><strong>Success!</strong> '. $success .' Sprints have been successfully created!</div>';
  } 
  else 
  {
    echo '<div class="alert alert-failure"><strong>Error!</strong> ' . $sql . '<br>' . $conn->error . '</div>';
  }
?>
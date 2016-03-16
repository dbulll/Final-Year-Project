<div class="row">
    <h3>Task Completion</h3>
</div>
<div class="row">
<?php
	$sprintStorySql = mysqli_query($conn, 'SELECT id FROM story_table WHERE sprint_table_id = '. $_GET['sprint_id']);
    $storyIdArray = '';
    $loopCounter = 0 ;
    while($sql11 = mysqli_fetch_array($sprintStorySql))
    { 
      if($loopCounter == 0)
      {
        $storyIdArray = $storyIdArray.$sql11['id'];
        $loopCounter = $loopCounter+ 1;
      }
      else
      {
        $storyIdArray = $storyIdArray. ',' .$sql11['id']; 
      }
    }
    $countUPquery = mysqli_query($conn, 'SELECT COUNT(*) FROM task_table WHERE task_state = 0 AND story_table_id IN ('.$storyIdArray.')');
    $countTDquery = mysqli_query($conn, 'SELECT COUNT(*) FROM task_table WHERE task_state = 1 AND story_table_id IN ('.$storyIdArray.')');
    $countIPquery = mysqli_query($conn, 'SELECT COUNT(*) FROM task_table WHERE task_state = 2 AND story_table_id IN ('.$storyIdArray.')');
    $countDquery = mysqli_query($conn, 'SELECT COUNT(*) FROM task_table WHERE task_state = 3 AND story_table_id IN ('.$storyIdArray.')');
    $countTestquery = mysqli_query($conn, 'SELECT COUNT(*) FROM task_table GROUP BY task_state');
    $countUP = mysqli_fetch_array($countUPquery);
    $countTD = mysqli_fetch_array($countTDquery);
    $countIP = mysqli_fetch_array($countIPquery);
    $countD = mysqli_fetch_array($countDquery);
    $countTest = mysqli_fetch_array($countTestquery);
    $array = array($countUP[0], $countTD[0], $countIP[0], $countD[0]);
?>
	<canvas id="myChart4" width="400" height="400"></canvas>
    <script type="text/javascript">
      var ctx4 = document.getElementById("myChart4").getContext("2d");
      var data4 = 
      {
        labels: ["UnPlanned", "To Do", "In Progress", "Done"],
        datasets: [
        {
            label: "Task Numbers",
            fillColor: "rgba(151,187,205,0.5)",
            strokeColor: "rgba(151,187,205,0.8)",
            highlightFill: "rgba(151,187,205,0.75)",
            highlightStroke: "rgba(151,187,205,1)",
            data: <?php echo json_encode($array); ?>
        }
                  ]
      };
      
      var myNewChart4 = new Chart(ctx4).Bar(data4);
    </script>
</div>
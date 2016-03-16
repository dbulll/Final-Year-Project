<?php 
  #Create Dataset Arrays for graph
  $sprintArray = [];
  $estimateArray = [];
 
  #Retrieve total estimate of all tasks in a release.
  $totalEstimateSql = mysqli_query($conn, 'SELECT SUM( c.task_hours_estimation ) AS total_release_estimation FROM sprint_table a, story_table b, task_table c WHERE a.id = b.sprint_table_id AND b.id = c.story_table_id AND a.release_table_id = '.$_GET['release_id']);
  $totalEstimateArray = mysqli_fetch_array($totalEstimateSql);
  $totalEstimate = $totalEstimateArray['total_release_estimation']; 
  $remainingArray = [$totalEstimate];
  #Find all sprints within a release
  $sprintArraySql = mysqli_query($conn, 'SELECT id, sprint_name, sprint_end_date FROM sprint_table WHERE release_table_id ='. $_GET['release_id']);
  $estimateReduceVal = ($totalEstimate / mysqli_num_rows($sprintArraySql));
  while($row = mysqli_fetch_array($sprintArraySql))
  {
    $tempRemaining = 0;#sprint1
    array_push($sprintArray, $row['sprint_name']);
    array_push($estimateArray, $totalEstimate);
    $totalEstimate = $totalEstimate - $estimateReduceVal;
    #select all stories in the release
    $sqlA = mysqli_query($conn, 'SELECT a.* FROM story_table a, sprint_table b WHERE a.sprint_table_id = b.id AND b.release_table_id = '. $_GET['release_id']);
    while($rowA = mysqli_fetch_array($sqlA))
    {
      #select all tasks in the release
      $sqlB = mysqli_query($conn, 'SELECT * FROM task_table WHERE story_table_id = '. $rowA['id']);
      while($rowB = mysqli_fetch_array($sqlB))
      {
        #select all changes that have been made by the end of the sprint.
        $sqlC = mysqli_query($conn, 'SELECT * FROM change_table WHERE task_table_id = '. $rowB['id'] .' AND change_date <= "'. $row['sprint_end_date'] .'" ORDER BY change_date DESC');
        $sqlD = mysqli_fetch_array($sqlC);
        if($sqlD == NULL)
        {
          $value = $rowB['task_hours_estimation'];
        }
        else
        {
          $value = $sqlD['task_hours_remaining'];
        }
        $tempRemaining = $tempRemaining + $value;
      }
    }
    array_push($remainingArray, $tempRemaining);    
  }
  array_push($estimateArray, 0);
  array_push($sprintArray, "End");  
?>
<div class="row">
    <h3>Release Burndown</h3>
  </div>
  <div class="row">
    <canvas id="myChart" width="1000" height="500"></canvas>
    <script type="text/javascript">
      var ctx = document.getElementById("myChart").getContext("2d");
      var data = {
                labels: <?php echo json_encode($sprintArray); ?>,
                datasets: [
                    {
                        label: "EstimationLine",
                        fillColor: "rgba(0,0,0,0)",
                        strokeColor: "rgba(220,220,220,1)",
                        pointColor: "rgba(220,220,220,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: <?php echo json_encode($estimateArray); ?>             
                    },
                    {
                        label: "ActualLine",
                        fillColor: "rgba(0,0,0,0)",
                        strokeColor: "rgba(151,187,205,1)",
                        pointColor: "rgba(151,187,205,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(151,187,205,1)",
                        data: <?php echo json_encode($remainingArray); ?>
                    }
                ]
            };

      
      var myNewChart = new Chart(ctx).Line(data,{bezierCurve: false});
    </script>
  </div>
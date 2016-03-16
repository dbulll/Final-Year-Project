<?php 
  $storySql = mysqli_query($conn, 'SELECT a.id, a.sprint_start_date, a.sprint_end_date, b.release_work_hours FROM sprint_table a, release_table b WHERE a.release_table_id = b.id AND a.id = '. $_GET['sprint_id']);
  $totalSprintEstimate = mysqli_query($conn, 'SELECT SUM( task_hours_estimation ) AS sprint_total_estimate FROM task_table a, story_table b WHERE a.story_table_id = b.id AND sprint_table_id = '. $_GET['sprint_id']);

  $sprintEstimate = mysqli_fetch_array($totalSprintEstimate);
  $storyArray = mysqli_fetch_array($storySql);
  $begin = new DateTime($storyArray['sprint_start_date']);
  $end = (new DateTime($storyArray['sprint_end_date']))->modify('+1 day');
  $interval = DateInterval::createFromDateString('1 day');
  $period = new DatePeriod($begin, $interval, $end);
  $average_work_hours = $storyArray['release_work_hours'];
  $sprintEstimate2 = $sprintEstimate['sprint_total_estimate'] - $average_work_hours;
  $totalSpent = 0;
  $dateArray = [];
  $estimateArray = [];
  $remainingArray = [];
  foreach ( $period as $dt ){
    array_push($dateArray, $dt->format( "d-m-Y" ));
    array_push($estimateArray, $sprintEstimate2);
    $sprintEstimate2 = $sprintEstimate2 - $average_work_hours;
    if($sprintEstimate2 < 0)
    {
      $sprintEstimate2 = 0;
    }
    $tempRemaining = 0;
    $sqlA = mysqli_query($conn, 'SELECT * FROM story_table WHERE sprint_table_id = '. $_GET['sprint_id']);
    while($rowA = mysqli_fetch_array($sqlA))
    {
      $sqlB = mysqli_query($conn, 'SELECT * FROM task_table WHERE story_table_id = '. $rowA['id']);
      while($rowB = mysqli_fetch_array($sqlB))
      {
        $sqlC = mysqli_query($conn, 'SELECT * FROM change_table WHERE task_table_id = '. $rowB['id'] .' AND change_date <= "'. $dt->format( "Y-m-d" ) .'" ORDER BY change_date DESC');
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
  ;
?>
<div class="row">
    <h3>Sprint Burndown</h3>
  </div>
  <div class="row">
    <canvas id="myChart3" width="1000" height="500"></canvas>
    <script type="text/javascript">
      var ctx3 = document.getElementById("myChart3").getContext("2d");
      var data3 = {
                labels: <?php echo json_encode($dateArray); ?>,
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

      
      var myNewChart3 = new Chart(ctx3).Line(data3,{bezierCurve: false});
    </script>
  </div>
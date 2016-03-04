<!DOCTYPE html>
<html lang="en">
<head>
  <title>No Name</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="js/Chart.js"></script>
  <script type="text/javascript">
   function sprintChange(ev){
      var selectE = document.getElementById("sprint_list");
      var sprintId = selectE.options[selectE.selectedIndex].value;
      window.location.href = "review.php?sprint_id=".concat(sprintId);
    }
  </script>
</head>
<body>

<!-- Navigation Bar -->

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.html">No Name</a>
    </div>
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.html">Home</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Backlog<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="epicBacklog.php">Epic Backlog</a></li>
            <li><a href="storyBacklog.php">Story Backlog</a></li>
            <li><a href="taskBacklog.php">Task Backlog</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Planning<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="releasePlanning.php">Feature/Release Planning</a></li>
            <li><a href="sprintPlanning.php">Sprint Planning</a></li>
          </ul>
        </li>
        <li><a href="taskboard.php">Task Board</a></li>
        <li class="active"><a href="review.php">Review</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="login.html"><span class="glyphicon glyphicon-user"></span> Sign Up / Sign In</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Container -->
  
<div class="container">
  <div class="row">
    <a class="btn btn-default" id="taskboardButton" href="taskboard.php" style="margin-bottom: 10px;"><span class="glyphicon glyphicon-arrow-left"></span> Taskboard
    </a>
  </div>
  <div class="row">
    <button class="btn btn-primary pull-right" data-toggle="collapse" data-target="#help_div">Page Help</button>
  </div>
  <div class="row pageDesc collapse" id="help_div">
    <h4>Page Help <span class="glyphicon glyphicon-exclamation-sign"></h4>
    <p>This is the Review page. From here you can view graphs and statistics based on a Sprint's progress.</p>
    <ul style="text-align: left;">
      <li>Return to the Taskboard using the 'Taskboard' button</li>
      <li>Select which Sprint you would like review using the dropdown selection above the table</li>
      <li>Show/Hide this Page Help box using the 'Page Help' button</li>
    </ul>
  </div>
  <div class="row">
    <h2>Review</h2>
  </div>
  <div class="row">
    <p>This section of the website provides graphs and statistics for analysing the sprints.</p>
  </div>
  <?php 
    include 'php/connectionStart.php';
    include 'php/sprint_selection.php';
  ?>
  <?php 
      if(isset($_GET['sprint_id']))
      {
        $storySql = mysqli_query($conn, 'SELECT a.id, a.sprint_start_date, a.sprint_end_date, b.release_work_hours FROM sprint_table a, release_table b WHERE a.release_table_id = b.id AND a.id = '. $_GET['sprint_id']);
        $totalSprintEstimate = mysqli_query($conn, 'SELECT SUM( task_hours_estimation ) AS sprint_total_estimate FROM task_table a, story_table b WHERE a.story_table_id = b.id AND sprint_table_id = '. $_GET['sprint_id']);

        $sprintEstimate = mysqli_fetch_array($totalSprintEstimate);
        $storyArray = mysqli_fetch_array($storySql);
        $start_date = str_replace('-',',',$storyArray['sprint_start_date']);
        $end_date =  str_replace('-',',',$storyArray['sprint_end_date']);
        $begin = new DateTime($storyArray['sprint_start_date']);
        $end = (new DateTime($storyArray['sprint_end_date']))->modify('+1 day');
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        $sprintEstimate2 = $sprintEstimate['sprint_total_estimate'];
        $average_work_hours = $storyArray['release_work_hours'];
        $totalSpent = 0;
        $dateArray = [];
        $estimateArray = [];
        $remainingArray = [];
        foreach ( $period as $dt ){
          array_push($dateArray, $dt->format( "Y-m-d" ));
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
      }
    ?>
  <div class="row">
    <h3>Sprint Burndown</h3>
  </div>
  <div class="row">
    <canvas id="firstChart" width="1000" height="500"></canvas>
    <script type="text/javascript">
      var start_date = new Date(<?php echo $start_date; ?>);
      var end_date = new Date(<?php echo $end_date; ?>);
      var ctx1 = document.getElementById("firstChart").getContext("2d");
      var data1 = {
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

      
      var myNewChart1 = new Chart(ctx1).Line(data1,{bezierCurve: false});
    </script>
  </div>


  <div class="row">
    <h3>Task Completion</h3>
  </div>
  <div class="row">
    <?php
      if(isset($_GET['sprint_id']))
      {
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
      }
      else{$array = [0,0,0,0];}
    ?>
    <canvas id="myChart" width="400" height="400"></canvas>
    <script type="text/javascript">
      var ctx = document.getElementById("myChart").getContext("2d");
      var data = 
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
      
      var myNewChart = new Chart(ctx).Bar(data);
    </script>
  </div>
</div>
</body>
</html>

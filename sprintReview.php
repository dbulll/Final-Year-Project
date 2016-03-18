<!DOCTYPE html>
<html lang="en">
<head>
  <title>Scrumble</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="js/Chart.js"></script>
  <script type="text/javascript">
  function sprintChange(ev){
      var selectS = document.getElementById("sprint_list");
      var sprintId = selectS.options[selectS.selectedIndex].value;
      window.location.href = "sprintReview.php?sprint_id=" + sprintId;
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
      <a class="navbar-brand" href="index.php">Scrumble</a>
    </div>
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
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
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Review<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="active"><a href="sprintReview.php">Sprint Review</a></li>
            <li><a href="releaseReview.php">Release Review</a></li>
          </ul>
        </li>
      </ul>
      <!--<ul class="nav navbar-nav navbar-right">
        <li><a href="login.php"><span class="glyphicon glyphicon-user"></span> 
        <?php
          include 'php/userConnectionStart.php';
          if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
          {
            echo $_SESSION['Username'];
          }
          else
          {
            echo 'Sign Up / Sign In';
          }
        ?>
        </a></li>
      </ul>-->
    </div>
  </div>
</nav>

<!-- Main Container -->
  
<div class="container">
  <div class="row">
    <a class="btn btn-nav" id="taskboardButton" href="taskboard.php" style="margin-bottom: 10px;"><span class="glyphicon glyphicon-arrow-left"></span> Taskboard
    </a>
    <a class="btn btn-nav pull-right" id="releaseReviewButton" href="releaseReview.php" style="margin-bottom: 10px;">Release Review <span class="glyphicon glyphicon-arrow-right"></span> 
    </a>
  </div>
  <div class="row">
    <button class="btn btn-help pull-right" data-toggle="collapse" data-target="#help_div">Page Help</button>
  </div>
  <div class="row pageDesc collapse" id="help_div">
    <h4>Page Help <span class="glyphicon glyphicon-exclamation-sign"></h4>
    <p>This is the Review page. From here you can view graphs and statistics based on a Sprint's progress.</p>
    <ul style="text-align: left;">
      <li>Return to the Taskboard using the 'Taskboard' button</li>
      <li>Move on to the Release Review Page using the 'Release Review' button</li>
      <li>Select which Sprint you would like review using the dropdown selection above the table</li>
      <li>Show/Hide this Page Help box using the 'Page Help' button</li>
    </ul>
  </div>
  <div class="row">
    <h2>Sprint Review</h2>
  </div>
  <div class="row">
    <p>This section of the website provides graphs and statistics for analysing sprints within a release.</p>
  </div>
  <?php 
    include 'php/sprint_selection.php';
    if(isset($_GET['sprint_id']))
    {
      include 'php/sprintBurndown.php';
      include 'php/sprintTaskCompletion.php';
    }
  ?>
</div>
</body>
</html>

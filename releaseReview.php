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
  function releaseChange(ev){
      var selectR = document.getElementById("release_list");
      var releaseId = selectR.options[selectR.selectedIndex].value;
      window.location.href = "releaseReview.php?release_id=" + releaseId;
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
            <li><a href="sprintReview.php">Sprint Review</a></li>
            <li class="active"><a href="releaseReview.php">Release Review</a></li>
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
    <div class="col-lg-5">
      <a class="btn btn-nav" id="sprintReviewButton" href="sprintReview.php" style="margin-bottom: 10px;"><span class="glyphicon glyphicon-arrow-left"></span> Sprint Review</a>
    </div>
    <div class="col-lg-2">
      <button class="btn btn-help pull-right" data-toggle="collapse" data-target="#help_div">Page Help <span class="glyphicon glyphicon-info-sign"></span></button>
    </div>
  </div>
  <div class="row pageDesc collapse" id="help_div">
    <h4>Page Help <span class="glyphicon glyphicon-info-sign"></h4>
    <p>This is the Release Review page. From here you can view graphs and statistics based on a Release's progress.</p>
    <ul style="text-align: left;">
      <li>Return to the Sprint Review page using the 'Sprint Review' button</li>
      <li>Select which Release you would like review using the dropdown selection above the table</li>
      <li>Show/Hide this Page Help box using the 'Page Help' button</li>
    </ul>
  </div>
  <div class="row">
    <h2>Release Review</h2>
  </div>
  <div class="row">
    <p>This section of the website provides graphs and statistics for analysing releases.</p>
  </div>
  <?php 
    include 'php/release_selection.php';
    if(isset($_GET['release_id']))
    {
      include 'php/releaseBurndown.php';
    }
  ?>
</div>
</body>
</html>

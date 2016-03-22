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
        <li class="active"><a href="index.php">Home</a></li>
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
  <a class="btn btn-nav pull-right" id="epicBacklogButton" href="epicBacklog.php" style="margin-bottom: 10px;">Epic Backlog <span class="glyphicon glyphicon-arrow-right"></span>
  </a>
  <div class="row">
    <h4>Use the navigation bar in the header or navigation buttons located at the top of each screen to traverse through the site ></h4>
  </div>
  <div class="row" style="text-align:center; margin-top:5%; margin-bottom:5%;">
    <div class="col-lg-3">
      <a href="epicBacklog.php"><span class="glyphicon glyphicon-list-alt" style="font-size:8em;"></span></a>
      <h4>Create, estimate and prioritise Epic's, User Stories and Tasks in the Backlog</h4>
    </div>
    <div class="col-lg-3">
      <a href="releasePlanning.php"><span class="glyphicon glyphicon-calendar" style="font-size:8em;"></span></a>
      <h4>Define, manage and organise your projects using the Release and Sprint planning.</h4>
    </div>
    <div class="col-lg-3">
      <a href="taskboard.php"><span class="glyphicon glyphicon-blackboard" style="font-size:8em;"></span></a>
      <h4>Keep track of ongoing and completed work using the Task Board</h4>
    </div>
    <div class="col-lg-3">
      <a href="releaseReview.php"><span class="glyphicon glyphicon-stats" style="font-size:8em;"></span></a>
      <h4>Review the health of previous an currently running Sprints & Releases</h4>
    </div>
  </div>
  <?php
    if(!empty($_POST['feedback_like']) || !empty($_POST['feedback_dislike']) || !empty($_POST['feedback_suggestions']))
    {
      mail("up643992@myport.ac.uk", "Scrumble Feedback",
      "Likes: ".$_POST["feedback_like"].
      " Dislikes: ".$_POST["feedback_dislike"].
      " Suggestions: ".$_POST["feedback_suggestions"]
      , "From: bobhuddle@gmail.com");
    }
  ?>
  <div class="row feedbackForm">
    <div class="col-lg-8">
    <h1>Feedback</h1>
    <p>If you could spare some time to provide feedback on the application it would be appreciated.</p>
    <form action="index.php" class="form-horizontal" data-toggle="validator" id="feedbackForm" method="post" novalidate="true" role="form">
      <div class="form-group">
        <label class="control-label" for="feedback_like">Aspects that you liked</label>
        <div class="has-feedback">
          <textarea class="form-control" name="feedback_like" type="text"></textarea>
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label" for="feedback_diskike">Aspects that you you didn't like as much</label>
        <div class="has-feedback">
          <textarea class="form-control" name="feedback_dislike" type="text"></textarea>
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label" for="feedback_suggestions">Suggestions</label>
        <div class="has-feedback">
          <textarea class="form-control" name="feedback_suggestions" type="text"></textarea>
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        </div>
      </div>
      <div class="form-group">
        <button class="btn btn-success" type="submit" id="submit_feedback">Submit Feedback <span class="glyphicon glyphicon-plus"></span></button>
      </div>
    </form>
    </div>
  </div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>No Name</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-2.2.0.js"></script>
  <script src="js/validator.js"></script>
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
            <li class="active"><a href="releasePlanning.php">Feature/Release Planning</a></li>
            <li><a href="sprintPlanning.php">Sprint Planning</a></li>
          </ul>
        </li>
        <li><a href="taskboard.php">Task Board</a></li>
        <li><a href="review.php">Review</a></li>
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
    <div class="col-lg-6">
      <a class="btn btn-default" id="taskBacklogButton" href="taskBacklog.php" style="margin-bottom: 10px;"><span class="glyphicon glyphicon-arrow-left"></span> Task Backlog
      </a>
    </div>
    <div class="col-lg-6">
      <a class="btn btn-default pull-right" id="sprintPlanningButton" href="sprintPlanning.php" style="margin-bottom: 10px;">Sprint Planning <span class="glyphicon glyphicon-arrow-right"></span>
      </a>
    </div>
  </div>
  <?php
    include 'php/connectionStart.php'; 
    if(isset($_POST['release_name'])){include 'php/releaseCreate.php';}
    if(isset($_GET['remove'])){include 'php/releaseRemove.php';}
  ?>
  <div class="row">
    <button class="btn btn-primary pull-right" data-toggle="collapse" data-target="#help_div">Page Help</button>
  </div>
  <div class="row pageDesc collapse" id="help_div">
    <h4>Page Help <span class="glyphicon glyphicon-exclamation-sign"></h4>
    <p>This page of the planning lists the current Releases that are created in the project.</p>
    <ul style="text-align: left;">
      <li>Return to the Task Backlog using the 'Task Backlog' button</li>
      <li>Move on to the Sprint Planning using the 'Sprint Planning' button</li>
      <li>Create a new Release using the 'Create New Release' button</li>
      <li>Remove an unwanted Release using the 'Remove' button</li>
      <li>Expand a specific Release to start planning User Stories into associated Sprints using the 'Sprints' button</li>
      <li>Show/Hide this Page Help box using the 'Page Help' button</li>
    </ul>
  </div>
<!-- List of Releases -->
  <div class="row">
    <h2>Release Planning</h2>
  </div>
  <div class="row">
    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">Create New Release <span class="glyphicon glyphicon-plus"></button>
  </div>
  <div class="row">
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Create New Release</h3>
          </div>
          <div class="modal-body">
          <form action="releasePlanning.php" class="form-horizontal" data-toggle="validator" id="releaseCreationForm" method="post" novalidate="true" role="form">
            <div class="form-group">
              <label class="col-lg-3 control-label" for="release_name">Release Name:</label>
              <div class="col-lg-9 has-feedback">
                  <input class="form-control" name="release_name" maxlength="30" pattern="^[A-z0-9\s]{1,}$" placeholder="Enter Release Name" type="text" required/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label" for="release_description" >Release Description:</label>
              <div class="col-lg-9 has-feedback">
                  <textarea type="text" class="form-control" name="release_description" maxlength="1000" placeholder="Enter Release Description" rows="3" required></textarea>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4">
                <label class="control-label" for="release_start_date">Release Start Date</label>
                <input type="date" class="form-control" name="release_start_date" required>
              </div>
              <div class="col-lg-4">
                <label class="control-label" for="release_end_date">Release End Date</label>
                <input type="date" class="form-control" name="release_end_date" required>
              </div>
              <div class="col-lg-4 form-group has-feedback">
                <label class="control-label" for="release_sprint_length">Sprint Length (days.)</label>
                <input type="text" class="form-control" name="release_sprint_length" pattern="^[0-9]{1,2}$" maxlength="2" required>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-offset-8 col-lg-3">
                <button class="btn btn-success" type="submit" id="submit_button">Create Release <span class="glyphicon glyphicon-plus"></button>
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="table-responsive">        
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Release Name</th>
          <th>Release Description</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Sprint Length (days.)</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php include 'php/releaseList.php'; ?>
      </tbody>
    </table> 
  </div>
</div>
</body>
</html>

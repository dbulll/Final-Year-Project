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
            <li class="active"><a href="taskBacklog.php">Task Backlog</a></li>
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
        <li><a href="review.php">Review</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="login.html"><span class="glyphicon glyphicon-user"></span> Sign Up / Sign In</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  <div class="row">
    <div class="col-lg-6">
      <a class="btn btn-default" id="storyBacklogButton" href="storyBacklog.php" style="margin-bottom: 10px;"><span class="glyphicon glyphicon-arrow-left"></span> Story Backlog
      </a>
    </div>
    <div class="col-lg-6">
      <a class="btn btn-default pull-right" id="releasePlanningButton" href="releasePlanning.php" style="margin-bottom: 10px;">Release Planning <span class="glyphicon glyphicon-arrow-right"></span>
      </a>
    </div>
  </div>
  <?php 
    include 'php/connectionStart.php';
    if(isset($_POST['task_name'])){include 'php/taskCreate.php';}
    if(isset($_GET['remove'])){include 'php/taskRemove.php';}
  ?>
  <div class="row">
    <button class="btn btn-primary pull-right" data-toggle="collapse" data-target="#help_div">Page Help</button>
  </div>
  <div class="row pageDesc collapse" id="help_div">
    <h4>Page Help <span class="glyphicon glyphicon-exclamation-sign"></h4>
    <p>This page of the backlog list's the current Tasks that are created in the project.</p>
    <ul style="text-align: left;">
      <li>Return to the Story Backlog using the 'Story Backlog' button</li>
      <li>Move on to the Release Planning using the 'Release Planning' button</li>
      <li>Create a new Task using the 'Create New Task' button</li>
      <li>Remove an unwanted Task using the 'Remove' button</li>
      <li>Show/Hide this Page Help box using the 'Page Help' button</li>
    </ul>
  </div>

  <div class="row">
    <h2>Task Backlog</h2>
  </div>
  <div class="row">
  <!-- Trigger the modal with a button -->
      <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">Create New Task <span class="glyphicon glyphicon-plus"></button>
  </div>
  <div class="row">
<!-- Modal -->
    <div class="modal fade" id="myModal"  role="dialog">
      <div class="modal-dialog modal-lg">
<!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Create New Task </h3>
          </div>
          <div class="modal-body">
<!-- Form for creating new user stories -->
          <form action="taskBacklog.php<?php if(isset($_GET['story_id'])){echo '?story_id='. $_GET["story_id"];}?>" class="form-horizontal" data-toggle="validator" id="taskCreationForm" method="post" novalidate="true" role="form">
            <div class="form-group">
              <label class="col-lg-3 control-label" for="task_name">Task Name:</label>
              <div class="col-lg-9 has-feedback">
                  <input class="form-control" name="task_name" maxlength="30" pattern="^[A-z0-9\s]{1,}$" placeholder="Enter Task Name" type="text" required/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label" for="task_description" >Task Description:</label>
              <div class="col-lg-9 has-feedback">
                  <textarea type="text" class="form-control" name="task_description" maxlength="1000" placeholder="Enter Task Description" rows="3" required></textarea>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label" for="task_story" >Story:</label>
              <div class="col-lg-5 has-feedback">
                <select class="form-control" name="task_story">
                  <?php
                    $sql = mysqli_query($conn, 'SELECT * FROM story_table');
                    while($row = mysqli_fetch_array($sql))          
                    {
                      echo '<option value='. $row['id'].' ';
                      if(isset($_GET['story_id']))
                      {
                        if($_GET['story_id'] == $row['id'])
                        {
                          echo 'selected="selected"';
                        }
                      }
                      echo '>'. $row['story_name'].'</option>';
                    }
                  ?>
                </select>
              </div>
            </div>
          <div class="form-group">
            <label class="control-label col-lg-3" for="task_estimation">Task Estimation (hrs.):</label>
            <div class="col-lg-4 has-feedback">
              <input type="text" class="form-control" name="task_estimation" pattern="^[0-9]{1,2}$" maxlength="2" required>
              <span class="glyphicon form-control-feedback" aria-hidden="true" required></span>
            </div>
          </div>
          <div class="form-group has-feedback">
            <div class="col-lg-offset-9 col-lg-3">
              <button class="btn btn-success" id="submit_button" type="submit" >Create Task <span class="glyphicon glyphicon-plus"></button>
            </div>
          </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include 'php/taskList.php'; ?>
</div>
</body>
</html>

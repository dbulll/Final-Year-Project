<!DOCTYPE html>
<html lang="en">
<head>
  <title>Scrumble</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet"/>
  <script src="js/jquery-2.2.0.js"></script>
  <script src="js/validator.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
  <script type="text/javascript">
  function storyChange(ev){
      var selectE = document.getElementById("story_list");
      var storyId = selectE.options[selectE.selectedIndex].value;
      window.location.href = "taskBacklog.php?story_id=".concat(storyId);
    }
  $(document).ready(function() 
  {
    $('#example').dataTable( 
    {
      "order": [],
      "columnDefs": 
      [{
        "targets"  : 'no-sort',
        "orderable": false,
      }]
    });
  });
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

<div class="container">
  <div class="row">
    <div class="col-lg-5">
      <a class="btn btn-nav" id="storyBacklogButton" href="storyBacklog.php" style="margin-bottom: 10px;"><span class="glyphicon glyphicon-arrow-left"></span> Story Backlog</a>
    </div>
    <div class="col-lg-2">
      <button class="btn btn-help" data-toggle="collapse" data-target="#help_div">Page Help <span class="glyphicon glyphicon-info-sign"></span></button>
    </div>
    <div class="col-lg-5">
      <a class="btn btn-nav pull-right" id="releasePlanningButton" href="releasePlanning.php" style="margin-bottom: 10px;">Release Planning <span class="glyphicon glyphicon-arrow-right"></span></a>
    </div>
  </div>
  <?php 
    if(isset($_POST['task_name'])){include 'php/taskCreate.php';}
    if(isset($_GET['remove'])){include 'php/taskRemove.php';}
  ?>
  <div class="row pageDesc collapse" id="help_div">
    <h4>Page Help <span class="glyphicon glyphicon-info-sign"></h4>
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
    <p>Select Story:</p>
    <select class="col-lg-4" id="story_list" onchange="storyChange(event)">
      <option value=0></option>
    <?php
      $sql = mysqli_query($conn, 'SELECT id, story_name FROM story_table');
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
  <div class="row">
  <!-- Trigger the modal with a button -->
      <button type="button" class="btn btn-success pull-right successButton" data-toggle="modal" data-target="#myModal">Create New Task <span class="glyphicon glyphicon-plus"></button>
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
                  <input class="form-control" name="task_name" maxlength="100" pattern="^[A-z0-9\s]{1,}$" placeholder="Enter Task Name" type="text" required/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label" for="task_description" >Task Description:</label>
              <div class="col-lg-9 has-feedback">
                  <textarea type="text" class="form-control" name="task_description" maxlength="1000" placeholder="Enter Task Description" rows="3"></textarea>
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
            <label class="control-label col-lg-3" for="task_hours_estimation">Task Estimation (hrs.):</label>
            <div class="col-lg-4 has-feedback">
              <input type="text" class="form-control" name="task_hours_estimation" pattern="^[0-9]{1,2}$" maxlength="2" required>
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
  <!-- List of Tasks in Backlog -->
  <div class="table-responsive">        
    <table id="example" class="table table-striped">
      <thead>
        <tr>
          <th>Task Name</th>
          <th class="no-sort">Task Description</th>
          <th>Story Name</th>
          <th>Hours Estimated</th>
          <th>Hours Remaining</th>
          <th class="no-sort"></th>
        </tr>
      </thead>
      <tbody>
        <?php include 'php/taskList.php'; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>

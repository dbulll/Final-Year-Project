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
  function epicChange(ev){
      var selectE = document.getElementById("epic_list");
      var epicId = selectE.options[selectE.selectedIndex].value;
      window.location.href = "storyBacklog.php?epic_id=".concat(epicId);
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
      },
      {
        "targets" : 'moscow-priority',
        "type" : 'moscow',
      }]
    });
  });
  $.extend($.fn.dataTableExt.oSort, {
    "moscow-pre": function ( a ) {
      var vals = ["MUST", "SHOULD", "COULD", "WONT"];
        return $.inArray(a, vals);
    },
    "moscow-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
    "moscow-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
} );
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
            <li class="active"><a href="storyBacklog.php">Story Backlog</a></li>
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
  <div class="row">
    <div class="col-lg-5">
      <a class="btn btn-nav" id="epicBacklogButton" href="epicBacklog.php" style="margin-bottom: 10px;"><span class="glyphicon glyphicon-arrow-left"></span> Epic Backlog</a>
    </div>
    <div class="col-lg-2">
      <button class="btn btn-help pull-right" data-toggle="collapse" data-target="#help_div">Page Help <span class="glyphicon glyphicon-info-sign"></span></button>
    </div>
    <div class="col-lg-5">
      <a class="btn btn-nav pull-right" id="taskBacklogButton" href="taskBacklog.php" style="margin-bottom: 10px;">Task Backlog <span class="glyphicon glyphicon-arrow-right"></span></a>
    </div>
  </div>
  <!-- Start a connectin and check for actions -->
  <?php 
    if(isset($_POST['story_name'])){include 'php/storyCreate.php';}
    if(isset($_GET['remove'])){include 'php/storyRemove.php';}
  ?>
  <div class="row pageDesc collapse collapse" id="help_div">
    <h4>Page Help <span class="glyphicon glyphicon-info-sign"></h4>
    <p>This page of the backlog list's the current Stories that are created in the project.</p>
    <ul style="text-align: left;">
      <li>Return to the Epic Backlog using the 'Epic Backlog' button</li>
      <li>Move on to the Task Backlog using the 'Task Backlog' button</li>
      <li>Create a new Story using the 'Create New Story' button</li>
      <li>Remove an unwanted Story using the 'Remove' button</li>
      <li>Expand a specific Story to list all associated Tasks using the 'Tasks' button</li>
      <li>Show/Hide this Page Help box using the 'Page Help' button</li>
    </ul>
  </div>


  <div class="row">
    <h2>Story Backlog</h2>
  </div>
  <div class="row">
    <p>Select Epic:</p>
    <select class="col-lg-4" id="epic_list" onchange="epicChange(event)">
      <option value=0></option>
    <?php
      $sql = mysqli_query($conn, 'SELECT id, epic_name FROM epic_table');
      while($row = mysqli_fetch_array($sql))          
      {
        echo '<option value='. $row['id'].' ';
        if(isset($_GET['epic_id']))
        {
          if($_GET['epic_id'] == $row['id'])
          {
            echo 'selected="selected"';
          }
        }
        echo '>'. $row['epic_name'].'</option>';
      }
    ?>
    </select>
  </div>
  <div class="row">
  <!-- Trigger the modal with a button -->
      <button type="button" class="btn btn-success pull-right successButton" data-toggle="modal" data-target="#myModal">Create New Story <span class="glyphicon glyphicon-plus"></button>
  </div>
  <div class="row">
<!-- Modal -->
    <div class="modal fade" id="myModal"  role="dialog">
      <div class="modal-dialog modal-lg">
<!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Create New Story </h3>
          </div>
          <div class="modal-body">
<!-- Form for creating new stories -->
          <form action="storyBacklog.php<?php if(isset($_GET['epic_id'])){echo '?epic_id='. $_GET["epic_id"];}?>" class="form-horizontal" data-toggle="validator" id="storyCreationForm" method="post" novalidate="true" role="form">
            <div class="form-group">
              <label class="col-lg-3 control-label" for="story_name">Story Name:</label>
              <div class="col-lg-9 has-feedback">
                  <input class="form-control" name="story_name" maxlength="100" pattern="^[A-z0-9\s]{1,}$" placeholder="Enter Story Name" type="text" required/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label" for="story_description" >Story Description:</label>
              <div class="col-lg-9 has-feedback">
                  <textarea type="text" class="form-control" name="story_description" maxlength="1000" placeholder="Enter Story Description" rows="3" required></textarea>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label" for="story_epic" >Epic:</label>
              <div class="col-lg-5 has-feedback">
                <select class="form-control" name="story_epic">
                  <?php
                    $sql = mysqli_query($conn, 'SELECT * FROM epic_table');
                    while($row = mysqli_fetch_array($sql))          
                    {
                      echo '<option value='. $row['id'].' ';
                      if(isset($_GET['epic_id']))
                      {
                        if($_GET['epic_id'] == $row['id'])
                        {
                          echo 'selected="selected"';
                        }
                      }
                      echo '>'. $row['epic_name'].'</option>';
                    }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-3" for="story_priority">Story Priority:</label>
                <div class="col-lg-3">
                  <select class="form-control" name="story_priority">
                    <option>MUST</option>
                    <option>SHOULD</option>
                    <option>COULD</option>
                    <option>WONT</option>
                  </select>
              </div>
            </div>
            <div class="form-group has-feedback">
              <div class="col-lg-offset-9 col-lg-3">
                <button class="btn btn-success" id="submit_button" type="submit" >Create Story <span class="glyphicon glyphicon-plus"></button>
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- List of Stories in Backlog -->
  <div class="row">
    <div class="table-responsive">        
      <table id="example"  class="table table-striped">
        <thead>
          <tr>
            <th>Story Name</th>
            <th class="no-sort">Description</th>
            <th class="moscow-priority">Priority</th>
            <th>Estimation (Hrs)</th>
            <th>Epic Name</th>
            <th>Tasks (No.)</th>
            <th class="no-sort"></th>
            <th class="no-sort"></th>
          </tr>
        </thead>
        <tbody>
          <?php include 'php/storyList.php' ?>
        </tbody>
      </table> 
    </div>
  </div>
</div>
</body>
</html>

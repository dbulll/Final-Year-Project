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
            <li class="active"><a href="epicBacklog.php">Epic Backlog</a></li>
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
  <div class="row">
  <a class="btn btn-nav" id="homeButton" href="index.php" style="margin-bottom: 10px;"><span class="glyphicon glyphicon-arrow-left"></span>Homepage 
  </a>
  <a class="btn btn-nav pull-right" id="storyBacklogButton" href="storyBacklog.php" style="margin-bottom: 10px;">Story Backlog <span class="glyphicon glyphicon-arrow-right"></span>
  </a>
  </div>
  <?php 
    if(isset($_POST['epic_name'])){include 'php/epicCreate.php';}
    if(isset($_GET['remove'])){include 'php/epicRemove.php';}
  ?>
  <div class="row">
    <button class="btn btn-help pull-right" data-toggle="collapse" data-target="#help_div">Page Help</button>
  </div>
  <div class="row pageDesc collapse collapse" id="help_div">
    <h4>Page Help <span class="glyphicon glyphicon-exclamation-sign"></h4>
    <p>This page of the backlog list's the current Epic's that are created in the project.</p>
    <ul style="text-align: left;">
      <li>Move on to the Story Backlog using the 'Story Backlog' button</li>
      <li>Create a new Epic using the 'Create New Epic' button</li>
      <li>Remove an unwanted Epic using the 'Remove' button</li>
      <li>Expand a specific Epic to list all associated User Stories using the 'Stories' button</li>
      <li>Show/Hide this Page Help box using the 'Page Help' button</li>
    </ul>
  </div>
  <div class="row">
    <h2>Epic Backlog</h2>
  </div>
  <div class="row">
    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-success pull-right successButton" data-toggle="modal" data-target="#myModal">Create New Epic <span class="glyphicon glyphicon-plus"></button>
  </div>
  <div class="row">
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Create New Epic</h3>
          </div>
          <div class="modal-body">
          <form action="epicBacklog.php" class="form-horizontal" data-toggle="validator" id="epicCreationForm" method="post" novalidate="true" role="form">
            <div class="form-group">
              <label class="col-lg-3 control-label" for="epic_name">Epic Name:</label>
              <div class="col-lg-9 has-feedback">
                  <input class="form-control" name="epic_name" maxlength="100" pattern="^[A-z0-9\s]{1,}$" placeholder="Enter Epic Name" type="text" required/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label" for="epic_description" >Epic Description:</label>
              <div class="col-lg-9 has-feedback">
                  <textarea type="text" class="form-control" name="epic_description" maxlength="1000" placeholder="Enter Epic Description" rows="3" required></textarea>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-offset-9 col-lg-3">
                <button class="btn btn-success" type="submit" id="submit_button">Create Epic <span class="glyphicon glyphicon-plus"></button>
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- List of Epics in the backlog -->
  <div class="row">
  <div class="table-responsive">        
    <table id="example" class="table">
      <thead>
        <tr>
          <th>Epic Name</th>
          <th class="no-sort">Description</th>
          <th>User Stories (No.)</th>
          <th class="no-sort"></th>
          <th class="no-sort"></th>
        </tr>
      </thead>
      <tbody>
        <?php include 'php/epicList.php' ?>
      </tbody>
    </table> 
  </div>
  </div>
</div>  
</body>
</html>

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
            <li class="active"><a href="epicBacklog.php">Epic Backlog</a></li>
            <li><a href="storyBacklog.php">User Story Backlog</a></li>
            <li><a href="taskbacklog.php">Task Backlog</a></li>
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
        <li><a href="review.html">Review</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="login.html"><span class="glyphicon glyphicon-user"></span> Sign Up / Sign In</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Container -->

<div class="container">
<?php if(isset($_POST['epic_name'])){include 'epicCreate.php';}?>
<?php if(isset($_GET['id'])){include 'epicRemove.php';}?>

<!-- List of Epics in the backlog -->

  <h2>Epic's Backlog</h2>
  <div class="table-responsive">        
    <table class="table table-">
      <thead>
        <tr>
          <th>Epic Name</th>
          <th>Description</th>
          <th>User Stories (No.)</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php include 'epicList.php' ?>
      </tbody>
    </table> 
  </div>

<!-- Form for creating new epics-->

  <h2> Create New Epic </h2>
  <form class="form-horizontal col-lg-8 col-lg-offset-2" id="epicCreationForm" data-toggle="validator" role="form" novalidate="true" action="epicBacklog.php" method="post">
    <div class="row form-group has-feedback">
      <label class="control-label" for="epic_name">Epic Name:</label>
      <input type="text" class="form-control" name="epic_name" pattern="^[A-z0-9\s]{1,}$" maxlength="30" placeholder="Enter Epic Name" required>
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    </div>
    <div class="row form-group has-feedback">
      <label class="control-label" for="epic_description">Epic Description:</label>
      <textarea type="text" class="form-control" name="epic_description" maxlength="1000" placeholder="Enter Epic Description" rows="3" required></textarea>
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    </div>
    <div class="row form-group pull-right">
      <button type="submit" class="btn btn-primary" id="submit_button">Create Epic <span class="glyphicon glyphicon-plus"></button>
    </div>
  </form>
</div>  
</body>
</html>

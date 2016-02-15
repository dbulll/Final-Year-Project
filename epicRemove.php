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
        <li><a href="taskBoard.html">Task Board</a></li>
        <li><a href="review.html">Review</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="login.html"><span class="glyphicon glyphicon-user"></span> Sign Up / Sign In</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Container-->

<div class="container">

<!-- PHP Code - 1.Remove Epic by the given id. -->

  <?php
    if(isset($_GET["id"]))
    {
      $conn = new mysqli('localhost', 'root', '', 'tempdb');
      if($conn->connect_errno > 0)
      {
        die('Unable to connect to database [' . $conn->connect_error . ']');
      }
      $sql = 'SELECT id FROM tablefour WHERE epic_id = ' . $_GET["id"];
      $sql1 = mysqli_query($conn, $sql);
      while($row = mysqli_fetch_array($sql1))          
      {
        mysqli_query($conn,'DELETE FROM tablefive WHERE story_id = ' . $row['id']);
      }
      $sql3 = mysqli_query($conn, $sql);
      if(mysqli_num_rows($sql3) == 0)
      {
        echo "<div class='alert alert-watning'><strong>Success!</strong> All related tasks have been successfully removed.</div>";
      }
      else 
      {
        echo "<div class='alert alert-failure'><strong>Error!</strong> " . $sql . "<br>" . $conn->error . "</div>";
      }
      $sql4 = 'DELETE FROM tablefour WHERE epic_id = ' . $_GET["id"];
      if ($conn->query($sql4) === TRUE) 
      {
        echo "<div class='alert alert-success'><strong>Success!</strong> All related user stories have been successfully removed.</div>";
      } 
      else 
      {
        echo "<div class='alert alert-failure'><strong>Error!</strong> " . $sql . "<br>" . $conn->error . "</div>";
      }
      $sql5 = 'DELETE FROM tablethree WHERE id = ' . $_GET["id"];
      if ($conn->query($sql5) === TRUE) 
      {
        echo "<div class='alert alert-success'><strong>Success!</strong> Epic has been successfully removed.</div>";
      } 
      else 
      {
        echo "<div class='alert alert-failure'><strong>Error!</strong> " . $sql . "<br>" . $conn->error . "</div>";
      }
    }
  ?>

<!-- List of Epics in the backlog -->

  <h3>Epic's Backlog</h3>
  <div class="table-responsive">           
    <table class="table table-striped">
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
<!-- PHP Code - 1.Grab list of Epics from the database. 2.Count user child user stories. -->
        <?php
          $conn = new mysqli('localhost', 'root', '', 'tempdb');
          if($conn->connect_errno > 0)
          {
            die('Unable to connect to database [' . $conn->connect_error . ']');
          }
          $sql = mysqli_query($conn, 'SELECT * FROM tablethree');
          while($row = mysqli_fetch_array($sql))          
          {
            ?>
              <tr>
                <td><?php echo $row['epicName'];?></td>
                <td><?php echo $row['epicDescription'];?></td>
                <td>1</td>
                <td>
                  <a class="btn btn-info" id="storiesButton" href="storyBacklog.php?id=<?php echo $row['id'];?>">
                    Stories <span class="glyphicon glyphicon-arrow-right"></span>
                  </a>
                </td>
                <td>
                  <a class="btn btn-danger" id="removeButton" href="epicRemove.php?id=<?php echo $row['id'];?>">
                    Remove <span class="glyphicon glyphicon-remove"></span>
                  </a>
                </td>
              </tr>
            <?php
          }
        ?>
      </tbody>
    </table>
  </div>

<!-- Form for creating new epics-->
  
  <h3> Create New Epic </h3>
  <form class="form-horizontal col-lg-8 col-lg-offset-2" id="epicCreationForm" data-toggle="validator" role="form" novalidate="true" action="epicCreate.php" method="post">
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

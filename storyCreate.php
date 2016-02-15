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
            <li class="active"><a href="storyBacklog.php">User Story Backlog</a></li>
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
        <li><a href="taskboard.html">Task Board</a></li>
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

<!-- PHP Code - 1.Insert new Story into the database -->

  <?php
    if(isset($_POST["story_name"]))
    {
      $conn = new mysqli('localhost', 'root', '', 'tempdb');
      if($conn->connect_errno > 0)
      {
        die('Unable to connect to database [' . $conn->connect_error . ']');
      }
      $story_name = $_POST["story_name"];
      $story_description = $_POST["story_description"];
      $story_priority = $_POST["story_priority"];
      $story_estimation = $_POST["story_estimation"];
      $story_epic = $_POST["story_epic"];
      $sql = "INSERT INTO tablefour (storyName, storyDescription, storyPriority, storyEstimation, epic_id) VALUES ('$story_name', '$story_description', '$story_priority', '$story_estimation', '$story_epic')";
      if ($conn->query($sql) === TRUE) 
      {
        echo "<div class='alert alert-success'><strong>Success!</strong> User Story has been successfully created.</div>";
      } 
      else 
      {
        echo "<div class='alert alert-failure'><strong>Error!</strong> " . $sql . "<br>" . $conn->error . "</div>";
      }
      $conn->close();
    }
  ?>

  <h3>User Story Backlog</h3>

<!-- List of Stories in Backlog -->

  <div class="table-responsive">        
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Id</th>
          <th>Story Name</th>
          <th>Description</th>
          <th>Priority</th>
          <th>Estimation (Hrs)</th>
          <th>Epic Owner</th>
          <th>Tasks (No.)</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>

<!-- PHP Code - 1.Grab list of Stories from the database. -->
      
        <?php
          $conn = new mysqli('localhost', 'root', '', 'tempdb');
          if($conn->connect_errno > 0)
          {
            die('Unable to connect to database [' . $conn->connect_error . ']');
          }
          $sql = mysqli_query($conn, 'SELECT * FROM tablefour');
          while($row = mysqli_fetch_array($sql))          
          {
            ?>
              <tr>
                <td><?php echo $row['id'];?></td>
                <td><?php echo $row['storyName'];?></td>
                <td><?php echo $row['storyDescription'];?></td>
                <td><?php echo $row['storyPriority'];?></td>
                <td><?php echo $row['storyEstimation'];?></td>
                <td><?php echo $row['epic_id'];?></td>
                <td>
                  <a class="btn btn-info" id="tasksButton" href="taskBacklog.php?id=<?php echo $row['id'];?>">
                    Tasks <span class="glyphicon glyphicon-arrow-right"></span>
                  </a>
                </td>
                <td>
                  <a class="btn btn-danger" id="removeButton" href="storyRemove.php?id=<?php echo $row['id'];?>">
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
</div>

<div class="container">

<!-- Form for creating new Story -->

  <h3> Create New Story </h3>
  <form class="form-horizontal col-lg-8 col-lg-offset-2" id="storyCreationForm" data-toggle="validator" role="form" novalidate="true" action="storyCreate.php" method="post">
    <div class="row form-group has-feedback">
      <label class="control-label" for="story_name">Story Name:</label>
      <input type="text" class="form-control" name="story_name" pattern="^[A-z0-9\s]{1,}$" maxlength="30" placeholder="Enter Story Name" required>
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    </div>
    <div class="row form-group has-feedback">
      <label class="control-label" for="story_description">Story Description:</label>
      <textarea type="text" class="form-control" name="story_description" maxlength="1000" placeholder="Enter Story Description" rows="3" required></textarea>
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    </div>
    <div class="row">
      <div class="col-lg-5">
        <label class="control-label" for="story_epic">Epic</label>
        <select class="form-control" name="story_epic">
          <?php
          $conn = new mysqli('localhost', 'root', '', 'tempdb');
          if($conn->connect_errno > 0)
          {
            die('Unable to connect to database [' . $conn->connect_error . ']');
          }
          $sql = mysqli_query($conn, 'SELECT id, epicName FROM tablethree');
          while($row = mysqli_fetch_array($sql))          
          {
            ?> 
            <option><?php echo $row['id'] . '. ' . $row['epicName'];?></option>
            <?php
          }
          ?>
        </select>
      </div>
      <div class="col-lg-3">
        <label class="control-label" for="story_priority">Story Priority</label>
        <select class="form-control" name="story_priority">
          <option>Must</option>
          <option>Should</option>
          <option>Could</option>
          <option>Wont</option>
        </select>
      </div>
      <div class="col-lg-4 form-group has-feedback">
        <label class="control-label" for="story_estimation">Story Estimation (hrs.)</label>
        <input type="text" class="form-control" name="story_estimation" pattern="^[0-9]{1,2}$" maxlength="2" required>
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      </div>
    </div>
    <div class="row form-group has-feedback">
      <button type="submit" class="btn btn-primary pull-right" id="submit_button">Create Story <span class="glyphicon glyphicon-plus"></button>
    </div>
  </form>
</div>

</body>
</html>

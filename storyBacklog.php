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

<!-- List of Stories in Backlog -->

  <h2>User Story Backlog</h2>
  <div class="table-responsive">        
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Story Name</th>
          <th>Description</th>
          <th>Priority</th>
          <th>Estimation (Hrs)</th>
          <th>Epic ID</th>
          <th>Tasks (No.)</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>

<!-- PHP Code - 1.Grab list of Stories from the database. -->

        <?php
          $conn = new mysqli('localhost', 'root', '', 'scrum_web_app_db');
          if($conn->connect_errno > 0)
          {
            die('Unable to connect to database [' . $conn->connect_error . ']');
          }
          if(isset($_GET['id']))
          {
            $sql = mysqli_query($conn, 'SELECT * FROM story_table WHERE epic_table_id = '.$_GET['id']);
          }
          else
          {
            $sql = mysqli_query($conn, 'SELECT * FROM story_table');
          }
          while($row = mysqli_fetch_array($sql))          
          {
            $sql2 = mysqli_query($conn, 'SELECT COUNT(*) FROM task_table WHERE story_table_id = ' .$row['id']);
            $result = mysqli_fetch_array($sql2);
            ?>
              <tr>
                <td><?php echo $row['story_name'];?></td>
                <td><?php echo $row['story_description'];?></td>
                <td><?php echo $row['story_priority'];?></td>
                <td><?php echo $row['story_estimation'];?></td>
                <td><?php echo $row['epic_table_id'];?></td>
                <td><?php echo $result[0];?></td>
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

  <h2> Create New Story </h2>
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
          $sql = mysqli_query($conn, 'SELECT id, epic_name FROM epic_table');
          while($row = mysqli_fetch_array($sql))          
          {
            echo '<option value='. $row['id'] .'>'. $row['epic_name'].'</option>';
          }
          $conn->close();
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

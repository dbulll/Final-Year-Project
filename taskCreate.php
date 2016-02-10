<!DOCTYPE html>
<html lang="en">
<head>
  <title>No Name</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-1.12.0.js"></script>
  <script src="js/validator.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

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
            <li><a href="storyBacklog.php">User Story Backlog</a></li>
            <li class="active"><a href="taskbacklog.php">Task Backlog</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Planning<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="releasePlanning.html">Feature/Release Planning</a></li>
            <li><a href="sprintPlanning.html">Sprint Planning</a></li>
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
  
<div class="container">
  <?php
    $conn = new mysqli('localhost', 'root', '', 'tempdb');
    if($conn->connect_errno > 0)
    {
      die('Unable to connect to database [' . $conn->connect_error . ']');
    }

    $task_name = $_POST["task_name"];
    $task_description = $_POST["task_description"];
    $task_priority = $_POST["task_priority"];
    $task_estimation = $_POST["task_estimation"];
    $task_story = $_POST["task_story"];

    $sql = "INSERT INTO tablefive (taskName, taskDescription, taskPriority, taskEstimation, story_id) VALUES ('$task_name', '$task_description', '$task_priority', '$task_estimation', '$task_story')";
      if ($conn->query($sql) === TRUE) 
      {
       echo "<div class='alert alert-success'>
       <strong>Success!</strong> Task Successfully Created.
       </div>";
      } 
      else 
      {
        echo "<div class='alert alert-failure'>
        <strong>Error!</strong> " . $sql . "<br>" . $conn->error . "</div>";
      }
      $conn->close();
    ?>
  <h3>Task Backlog</h3>
  <div class="table-responsive">        
    <table class="table">
      <thead>
        <tr>
          <th>Id</th>
          <th>Task Name</th>
          <th>Task Description</th>
          <th>Priority</th>
          <th>Estimation (Hrs)</th>
          <th>User Story Owner</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
          $conn = new mysqli('localhost', 'root', '', 'tempdb');
          if($conn->connect_errno > 0)
          {
            die('Unable to connect to database [' . $conn->connect_error . ']');
          }
          $sql = mysqli_query($conn, 'SELECT * FROM tablefive');
          while($row = mysqli_fetch_array($sql))          
          {
            ?>
              <tr>
                <td><?php echo $row['id']?></td>
                <td><?php echo $row['taskName']?></td>
                <td><?php echo $row['taskDescription']?></td>
                <td><?php echo $row['taskPriority']?></td>
                <td><?php echo $row['taskEstimation']?></td>
                <td><?php echo $row['story_id']?></td>
                <td>
                  <a class="btn btn-danger" id="removeButton" href="taskRemove.php?id=<?php echo $row['id']?>">
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
  <h3> Create New Task </h3>
  <form class="form-horizontal col-lg-8 col-lg-offset-2" id="taskCreationForm" data-toggle="validator" role="form" novalidate="true" action="taskCreate.php" method="post">
    <div class="row form-group has-feedback">
      <label class="control-label" for="task_name">Task Name:</label>
      <input type="text" class="form-control" name="task_name" pattern="^[A-z0-9\s]{1,}$" maxlength="30" placeholder="Enter Task Name" required>
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    </div>
    <div class="row form-group has-feedback">
      <label class="control-label" for="task_description">Task Description:</label>
      <textarea type="text" class="form-control" name="task_description" maxlength="100" placeholder="Enter Task Description" rows="3" required></textarea>
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <label class="control-label" for="task_story">Story</label>
        <select class="form-control" name="task_story">
          <?php
          $conn = new mysqli('localhost', 'root', '', 'tempdb');
          if($conn->connect_errno > 0)
          {
            die('Unable to connect to database [' . $conn->connect_error . ']');
          }
          $sql = mysqli_query($conn, 'SELECT id, storyName FROM tablefour');
          while($row = mysqli_fetch_array($sql))          
          {
            ?> 
            <option><?php echo $row['id'] . '. ' . $row['storyName']?></option>
            <?php
          }
          ?>
        </select>
      </div>
      <div class="col-lg-3">
        <label class="control-label" for="task_priority">Task Priority</label>
        <select class="form-control" name="task_priority">
          <option>Must</option>
          <option>Should</option>
          <option>Could</option>
          <option>Wont</option>
        </select>
      </div>
      <div class="col-lg-3 form-group has-feedback">
        <label class="control-label" for="task_estimation">Task Estimation (hrs.)</label>
        <input type="text" class="form-control" name="task_estimation" pattern="^[0-9]{1,2}$" maxlength="2" required>
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      </div>
    </div>
    <div class="row form-group has-feedback">
      <button type="submit" class="btn btn-primary pull-right" id="submit_button">Create Task <span class="glyphicon glyphicon-plus"></button>
    </div>
  </form>
</div>

</body>
</html>

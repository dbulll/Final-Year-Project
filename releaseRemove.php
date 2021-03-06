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
            <li><a href="storyBacklog.php">User Story Backlog</a></li>
            <li><a href="taskbacklog.php">Task Backlog</a></li>
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

<!-- PHP Code - 1.Remove Release by the given id. -->

  <?php
    $conn = new mysqli('localhost', 'root', '', 'scrum_web_app_db');
    if($conn->connect_errno > 0)
    {
      die('Unable to connect to database [' . $conn->connect_error . ']');
    }
    if(isset($_GET['id']))
    {
      
      $sql = 'DELETE FROM release_table WHERE id = ' . $_GET['id'];
      if ($conn->query($sql) === TRUE) 
      {
       echo '<div class="alert alert-success"><strong>Success!</strong> Release has been successfully removed.</div>';
      } 
      else 
      {
        echo '<div class="alert alert-failure"><strong>Error!</strong> ' . $sql . '<br>' . $conn->error . '</div>';
      }
    }
  ?>

  <h2>Release Planning</h2>

<!-- List of Releases -->

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

<!-- PHP Code - 1.Grab list of Releases from the database. -->

        <?php
          $sql = mysqli_query($conn, 'SELECT * FROM release_table');
          while($row = mysqli_fetch_array($sql))          
          {
            ?>
              <tr>
                <td><?php echo $row['release_name'];?></td>
                <td><?php echo $row['release_description'];?></td>
                <td><?php echo $row['release_start_date'];?></td>
                <td><?php echo $row['release_end_date'];?></td>
                <td><?php echo $row['release_sprint_length'];?></td>
                <td>
                  <a class="btn btn-info" id="sprintsButton" href="sprintPlanning.php?id=<?php echo $row['id'];?>">
                    Sprints <span class="glyphicon glyphicon-arrow-right"></span>
                  </a>
                </td>
                <td>
                  <a class="btn btn-danger" id="removeButton" href="releaseRemove.php?id=<?php echo $row['id'];?>">
                    Remove <span class="glyphicon glyphicon-remove"></span>
                  </a>
                </td>
                </tr>
            <?php
          }
        $conn->close();
        ?>
      </tbody>
    </table> 
  </div>
</div>

<div class="container">

<!-- Form for creating new Releases -->

  <h2> Create New release </h2>
  <form class="form-horizontal col-lg-8 col-lg-offset-2" id="releaseCreationForm" data-toggle="validator" role="form" novalidate="true" action="releaseCreate.php" method="post">
    <div class="row form-group has-feedback">
      <label class="control-label" for="release_name">Release Name:</label>
      <input type="text" class="form-control" name="release_name" pattern="^[A-z0-9\s]{1,}$" maxlength="30" placeholder="Enter Release Name" required>
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    </div>
    <div class="row form-group has-feedback">
      <label class="control-label" for="release_description">Release Description:</label>
      <textarea type="text" class="form-control" name="release_description" maxlength="1000" placeholder="Enter Release Description" rows="3" required></textarea>
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
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
    <div class="row form-group has-feedback">
      <button type="submit" class="btn btn-primary pull-right" id="submit_button">Create Release <span class="glyphicon glyphicon-plus"></button>
    </div>
  </form>
</div>

</body>
</html>
